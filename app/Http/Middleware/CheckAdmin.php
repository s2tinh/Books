<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Lấy thông tin người dùng đang đăng nhập
        $user = Auth::user();

        // Kiểm tra vai trò của người dùng
        if (!$user || !$user->roles->contains('name', 'admin')) {
            // Nếu không phải Admin, chuyển hướng hoặc trả về lỗi
            return redirect('/')->with('error', 'Bạn không có quyền truy cập trang này.');
        }

        // Nếu là Admin, cho phép tiếp tục
        return $next($request);
    }
}
