<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CandidateProfile;
use App\Models\EmployerProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Xử lý yêu cầu đăng ký cho ứng dụng: 
     * 1. Tạo User & Profile. 
     * 2. Gửi Email Xác thực.
     */
    public function register(Request $request)
    {
        // 1. Validation 
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:candidate,employer'],
            'company_name' => ['nullable', 'string', 'max:191'],
        ]);

        $validator->sometimes('company_name', 'required', function ($input) {
            return $input->role === 'employer';
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // 2. Tạo User và Profile trong DB::transaction
            $user = DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                ]);

                if ($request->role === 'candidate') {
                    CandidateProfile::create(['user_id' => $user->id]);
                } else {
                    $companyName = $request->company_name ?? 'Company '.$user->id;
                    $slugBase = Str::slug($companyName);
                    $slug = $slugBase;
                    $counter = 1;
                    while (EmployerProfile::where('company_slug', $slug)->exists()) {
                        $slug = $slugBase.'-'.$counter++;
                    }

                    EmployerProfile::create([
                        'user_id' => $user->id,
                        'company_name' => $companyName,
                        'company_slug' => $slug,
                    ]);
                }
                return $user;
            });
        } catch (\Exception $e) {
            \Log::error('Registration Error: ' . $e->getMessage());
            throw $e;
        }

        // 3. Logic Ghi đè Hành vi Mặc định:
        
        // Gửi sự kiện Registered
        event(new Registered($user));
        
        // Gửi email xác thực (KHÔNG TỰ ĐỘNG ĐĂNG NHẬP)
        $user->sendEmailVerificationNotification();

        // Gọi hàm registered() để tạo thông báo session
        $this->registered($request, $user);

        // Chuyển hướng đến trang đăng nhập
        return redirect($this->redirectPath());
    }


    /**
     * Ghi đè hàm registered() để thêm thông báo flash sau khi đăng ký.
     */
    protected function registered(Request $request, $user)
    {
        // Thêm thông báo vào session
        session()->flash('status', 'Đăng ký thành công! Chúng tôi đã gửi một liên kết xác thực đến địa chỉ email của bạn. Vui lòng kiểm tra hộp thư đến (và cả thư mục spam) để hoàn tất xác thực.');
    }

    /**
     * Ghi đè hàm redirectPath(): Chuyển hướng đến route đăng nhập thay vì /home.
     */
    public function redirectPath()
    {
        return route('login');
    }
}