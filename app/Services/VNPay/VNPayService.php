<?php

namespace App\Services\VNPay;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;

class VNPayService
{
    /**
     * Create a new payment URL.
     *
     * @param string $orderId
     * @param float $amount
     * @param string $orderInfo
     * @return string
     */
    public static function createPayment(string $orderId, float $amount, string $orderInfo): string
    {
        $config = Config::get('services.vnpay');
        
        $now = \Carbon\Carbon::now('Asia/Ho_Chi_Minh');

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $config['tmn_code'],
            "vnp_Amount" => $amount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => $now->format('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => Request::ip(),
            "vnp_Locale" => "vn",
            "vnp_OrderInfo" => $orderInfo,
            "vnp_OrderType" => 'billpayment',
            "vnp_ReturnUrl" => route($config['return_url']),
            "vnp_TxnRef" => $orderId,
            "vnp_ExpireDate" => $now->addMinutes(15)->format('YmdHis'),
        );

        if (isset($config['bank_code']) && $config['bank_code'] != "") {
            $inputData['vnp_BankCode'] = $config['bank_code'];
        }

        ksort($inputData);
        $query = "";
        $hashdata = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $config['url'] . "?" . $query;
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $config['hash_secret']);
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

        return $vnp_Url;
    }

    /**
     * Validate the response from VNPay.
     *
     * @param array $data
     * @return bool
     */
    public static function validateResponse(array $data): bool
    {
        $config = Config::get('services.vnpay');
        $vnp_SecureHash = $data['vnp_SecureHash'];
        unset($data['vnp_SecureHash']);

        // Remove parameters that are not used for hashing in some versions or scenarios
        unset($data['vnp_SecureHashType']); 

        ksort($data);

        $hashData = "";
        $i = 0;
        foreach ($data as $key => $value) {
            // Skip empty values
            if ($value === null || $value === '') {
                continue;
            }
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        
        $secureHash = hash_hmac('sha512', $hashData, $config['hash_secret']);

        return $secureHash === $vnp_SecureHash;
    }
}