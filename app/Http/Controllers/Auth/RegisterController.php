<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    */

    use RegistersUsers;

    /**
     * Nơi chuyển hướng mặc định (sẽ bị ghi đè bởi redirectPath() dưới đây).
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Tạo một controller instance mới.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Lấy trình xác thực cho yêu cầu đăng ký.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Tạo một user instance mới sau khi đăng ký hợp lệ.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    
    /**
     * Ghi đè hàm register() từ RegistersUsers để xử lý xác thực email (KHÔNG TỰ ĐỘNG ĐĂNG NHẬP).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        
        event(new Registered($user = $this->create($request->all())));

        // Gửi email xác thực (Không tự động đăng nhập)
        $user->sendEmailVerificationNotification();

        // Gọi hàm registered() để tạo thông báo session
        $this->registered($request, $user);

        // Chuyển hướng đến trang thông báo
        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
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
     * Ghi đè hàm redirectPath() để chuyển hướng đến trang thông báo xác thực.
     *
     * @return string
     */
    public function redirectPath()
    {
        // Trả về route của trang thông báo xác thực
        return route('verification.notice');
    }
}