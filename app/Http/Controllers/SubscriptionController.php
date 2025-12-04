<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\VNPay\VNPayService; // Thêm VNPayService

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        $user = Auth::user();

        if (!$user->isEmployer() || !$user->employerProfile) {
            return back()->with('error', 'You must have an employer profile to subscribe.');
        }

        $employerProfile = $user->employerProfile;

        // Xử lý gói miễn phí
        if ($plan->price == 0) {
            Subscription::updateOrCreate(
                ['employer_profile_id' => $employerProfile->id],
                [
                    'plan_id' => $plan->id,
                    'starts_at' => now(),
                    'ends_at' => null, // Gói miễn phí không có ngày hết hạn
                ]
            );
            return redirect()->route('dashboard')->with('success', "You have successfully subscribed to the {$plan->name} plan!");
        }

        // Xử lý gói trả phí: Chuyển hướng đến VNPAY
        // Tạo mã giao dịch duy nhất, chứa thông tin cần thiết để xử lý sau này
        $orderId = 'SUB_' . time() . '_' . $employerProfile->id . '_' . $plan->id;
        $amount = $plan->price;
        $orderInfo = "Thanh toan goi dich vu {$plan->name} cho {$user->name}";

        $paymentUrl = VNPayService::createPayment($orderId, $amount, $orderInfo);

        return redirect($paymentUrl);
    }

    /**
     * Xử lý khi người dùng được VNPAY chuyển hướng về.
     */
    public function vnpayReturn(Request $request)
    {
        $data = $request->all();

        // Kiểm tra chữ ký
        if (!VNPayService::validateResponse($data)) {
            return redirect()->route('pricing')->with('error', 'Invalid signature from VNPay.');
        }

        // Kiểm tra kết quả giao dịch
        if ($data['vnp_ResponseCode'] === '00') {
            // Giao dịch thành công từ phía người dùng.
            // Lưu thông tin vào session để hiển thị ở trang kết quả.
            session()->flash('vnpay_data', $data);
            // Cần chờ IPN để xác nhận cuối cùng và cập nhật DB.
            return redirect()->route('pricing')->with('success', 'Payment successful! Please check the transaction details below.');
        }

        // Giao dịch thất bại hoặc bị hủy
        session()->flash('vnpay_data', $data); // Vẫn lưu để có thể hiển thị mã lỗi
        return redirect()->route('pricing')->with('error', 'Payment failed or was canceled. Please try again.');
    }

    /**
     * Xử lý IPN (Instant Payment Notification) từ VNPAY.
     * Đây là nơi an toàn để cập nhật cơ sở dữ liệu.
     */
    public function vnpayIpn(Request $request)
    {
        $data = $request->all();
        $returnData = ['RspCode' => '99', 'Message' => 'Unknown error'];

        try {
            Log::info('VNPay IPN received', $data);

            // 1. Xác thực chữ ký
            if (!VNPayService::validateResponse($data)) {
                Log::warning('VNPay IPN: Invalid signature', $data);
                $returnData = ['RspCode' => '97', 'Message' => 'Invalid signature'];
                return response()->json($returnData);
            }

            // 2. Lấy thông tin từ mã giao dịch (vnp_TxnRef)
            $orderId = $data['vnp_TxnRef'];
            
            // 3. Kiểm tra xem đơn hàng có tồn tại không
            // TODO: Nên tạo một bảng `transactions` để lưu và kiểm tra.
            // Tạm thời, chúng ta sẽ phân tích orderId.
            $parts = explode('_', $orderId);
            if (count($parts) !== 4 || $parts[0] !== 'SUB') {
                 Log::error('VNPay IPN: Order not found or invalid format.', ['orderId' => $orderId]);
                 $returnData = ['RspCode' => '01', 'Message' => 'Order not found'];
                 return response()->json($returnData);
            }
            $employerProfileId = $parts[2];
            $planId = $parts[3];

            // 4. Kiểm tra trạng thái giao dịch từ VNPAY
            if ($data['vnp_ResponseCode'] === '00') {
                $plan = Plan::find($planId);
                $paidAmount = $data['vnp_Amount'] / 100;

                // 5. Kiểm tra số tiền thanh toán có khớp với giá gói không
                if ($plan && $plan->price == $paidAmount) {
                    // 6. Cập nhật Subscription trong database
                    // Sử dụng updateOrCreate để tránh tạo nhiều subscription cho một nhà tuyển dụng
                    Subscription::updateOrCreate(
                        ['employer_profile_id' => $employerProfileId],
                        [
                            'plan_id' => $planId,
                            'starts_at' => now(),
                            'ends_at' => now()->addMonth(), // Gói trả phí có thời hạn 1 tháng
                        ]
                    );

                    Log::info('Subscription updated successfully for employer profile: ' . $employerProfileId);
                    $returnData = ['RspCode' => '00', 'Message' => 'Confirm Success'];
                } else {
                    Log::error('VNPay IPN: Amount mismatch.', ['paid' => $paidAmount, 'expected' => $plan->price ?? 'N/A']);
                    $returnData = ['RspCode' => '04', 'Message' => 'Invalid amount'];
                }

            } else {
                // Giao dịch không thành công, không làm gì cả
                Log::warning('VNPay IPN: Transaction was not successful.', $data);
                $returnData = ['RspCode' => '00', 'Message' => 'Confirm Success (but transaction failed)'];
            }
        } catch (\Exception $e) {
            Log::error('VNPay IPN Error: ' . $e->getMessage(), ['exception' => $e]);
        }

        return response()->json($returnData);
    }
}
