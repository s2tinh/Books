<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'handleLogin']); // Xử lý đăng nhập
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'handleForgotPassword'])->name('password.email');

Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::get('/admin', function () {
    if (Auth::check()) {
        // Lấy danh sách vai trò người dùng
        $roles = Auth::user()->getRoleNames();

        // Kiểm tra nếu không có vai trò
        if ($roles->isEmpty()) {
            return 'No roles assigned to the user.';
        }

        // Hiển thị vai trò
        return 'Roles: ' . implode(', ', $roles->toArray());
    } else {
        return 'You are not logged in';
    }
});
