<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthController extends Controller
{
    // Hiển thị trang đăng nhập
    public function login()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
public function handleLogin(Request $request)
{
    // Kiểm tra dữ liệu đầu vào
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    // Trả về lỗi nếu dữ liệu không hợp lệ
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    // Kiểm tra thông tin đăng nhập
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
        return back();
    }

    // Nếu đăng nhập thất bại
    return back()->withErrors([
        'email' => 'Thông tin đăng nhập không chính xác!'
    ]);
    
}


    public function logout(Request $request)
    {

            // Đảm bảo có session trước khi logout
        if (session()->has('state')) {
            session()->forget('state');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
    
    // Hiển thị form quên mật khẩu
    public function showForgotPasswordForm()
    {
        return view('auth.reset_password');
    }

    // Xử lý quên mật khẩu
    public function handleForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Tích hợp gửi email reset mật khẩu
        $response = Password::sendResetLink(
            $request->only('email')
        );

        if ($response == Password::RESET_LINK_SENT) {
            return back()->with('status', 'Yêu cầu đặt lại mật khẩu đã được gửi!');
        } else {
            return back()->withErrors(['email' => 'Không tìm thấy email này trong hệ thống.']);
        }
    }

    // Hiển thị form đăng ký
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        // Validate thông tin
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',  // name là chuỗi không phải email
            'email' => 'required|email|unique:users,email', // validate email đúng và không trùng
            'password' => 'required|min:6|confirmed', // validate mật khẩu và kiểm tra mật khẩu xác nhận
        ]);

        // Nếu thông tin không hợp lệ, quay lại với thông báo lỗi
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Kiểm tra nếu email đã tồn tại trong cơ sở dữ liệu
        if (User::where('email', $request->email)->exists()) {
            return redirect()->back()->withErrors(['email' => 'Email đã được sử dụng!'])->withInput();
        }

        // Kiểm tra nếu mật khẩu và mật khẩu xác nhận không khớp
        if ($request->password !== $request->password_confirmation) {
            return redirect()->back()->withErrors(['password' => 'Mật khẩu và xác nhận mật khẩu không khớp!'])->withInput();
        }

        // Tạo người dùng mới
        $user = User::create([
            'name' => $request->name, // Lưu tên người dùng vào cơ sở dữ liệu
            'email' => $request->email,
            'password' => Hash::make($request->password), // Mã hóa mật khẩu
        ]);

        // Đăng nhập người dùng ngay sau khi đăng ký
        Auth::login($user);

        // Chuyển hướng đến trang chủ hoặc nơi bạn muốn
        return redirect()->route('home');
    }

}
