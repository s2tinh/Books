<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;  // Đảm bảo đã import Auth

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        // Xóa session trước khi chuyển hướng đến Google
        session()->forget('state');
        session()->flush(); // Dọn sạch session

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // Lấy thông tin người dùng từ Google
            $googleUser = Socialite::driver('google')->user();

            // Xóa token đã lưu trong session (nếu có)
            session()->forget('google_token');

            // Kiểm tra nếu người dùng đã có trong cơ sở dữ liệu
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Nếu người dùng chưa có trong cơ sở dữ liệu, tạo mới
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' =>$googleUser->getId(),
                ]);
            }

            // Đăng nhập người dùng
            Auth::login($user);
            return redirect()->to('/');
        } catch (\Exception $e) {
            // Xử lý lỗi và hiển thị thông báo
            return redirect()->route('login')->withErrors('Có lỗi xảy ra: ' . $e->getMessage());
        }
    }


}
