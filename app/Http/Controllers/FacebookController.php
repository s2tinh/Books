<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FacebookController extends Controller
{
    // Chuyển hướng đến Facebook để đăng nhập
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            // Kiểm tra user theo email trước
            $user = User::where('email', $facebookUser->email)->first();

            if ($user) {
                // Nếu user đã tồn tại, cập nhật app_id (tránh lỗi trùng email)
                $user->update(['app_id' => $facebookUser->id]);
            } else {
                // Nếu chưa có user, tạo mới
                $user = User::create([
                    'app_id' => $facebookUser->id,
                    'name' => $facebookUser->name,
                    'email' => $facebookUser->email ?? $facebookUser->id . '@facebook.com',
                    'password' => bcrypt($facebookUser->id),
                    'avatar' => $facebookUser->avatar,
                    'type_app' => '2',
                ]);
            }

            // Đăng nhập user
            Auth::login($user);

            return redirect('/')->with('success', 'Đăng nhập thành công!');
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors('đăng nhập thất bại');
        }
    }

}
