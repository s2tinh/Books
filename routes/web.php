<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
Route::prefix('admin')->middleware('check.admin')->group(function () {
    // Route để hiển thị form thêm sách
    Route::get('addbook', [BookController::class, 'create'])->name('admin.addbook');
    
    // Route để lưu sách vào cơ sở dữ liệu
    Route::post('addbook', [BookController::class, 'store'])->name('admin.storebook');
});

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'handleLogin']); // Xử lý đăng nhập
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'handleForgotPassword'])->name('password.email');

Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);


Route::post('/check-book-code', [BookController::class, 'checkBookCode'])->name('books.checkBookCode');




Route::prefix('admin')->middleware('check.admin')->group(function () {
    // Route quản lý trang chính của admin
    Route::get('/', [AdminController::class, 'index'])->name('administration');
    
    Route::get('books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('books/store', [BookController::class, 'store'])->name('books.store');

    Route::get('books', [BookController::class, 'listView'])->name('books.listView');

    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories/store', [CategoryController::class, 'store'])->name('categories.store');

    Route::get('categories', [CategoryController::class, 'listView'])->name('categories.listView');
    
    Route::post('books/check-book-code', [BookController::class, 'checkBookCode'])->name('books.checkBookCode');
    
    Route::get('books/get-sub-categories/{category_id}', [BookController::class, 'getSubCategories'])->name('get.sub.categories');

    Route::get('/books/detail', [BookController::class, 'detailView'])->name('books.detailView');

    Route::get('/books/edit', [BookController::class, 'edit'])->name('books.editView');

    // Route để lưu sách sau khi chỉnh sửa
    // Route::put('/books/edit', [BookController::class, 'update'])->name('books.updatebook');
});






