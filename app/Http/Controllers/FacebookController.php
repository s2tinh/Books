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

    // Xử lý phản hồi từ Facebook
    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            // Kiểm tra xem user đã tồn tại hay chưa
            $user = User::updateOrCreate(
                ['facebook_id' => $facebookUser->id],
                [
                    'name' => $facebookUser->name,
                    'email' => $facebookUser->email,
                    'password' =>   $facebookUser->id
                ]
            );

            Auth::login($user);

            return redirect('/')->with('success', 'Đăng nhập thành công!');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['login' => 'Đăng nhập thất bại!']);
        }
    }
}
