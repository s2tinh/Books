<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\App\HomeController;
use App\Http\Controllers\App\ABookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\PaymentController;

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\FacebookController;


Route::prefix('admin')->middleware('check.admin')->group(function () {
    // Route để hiển thị form thêm sách
    Route::get('addbook', [BookController::class, 'create'])->name('admin.addbook');
    
    // Route để lưu sách vào cơ sở dữ liệu
    Route::post('addbook', [BookController::class, 'store'])->name('admin.storebook');
});

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('login', [AuthController::class, 'login'])->name('login'); // Route GET cho trang login
Route::post('login', [AuthController::class, 'handleLogin'])->name('login.post');



Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'handleForgotPassword'])->name('password.email');

Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);




Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('auth/facebook', [FacebookController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback'])->name('auth.facebook.callback');



Route::post('/check-book-code', [BookController::class, 'checkBookCode'])->name('books.checkBookCode');




Route::prefix('admin')->middleware('check.admin')->group(function () {
// Route quản lý trang chính của admin
Route::get('/', [AdminController::class, 'index'])->name('administration');

Route::get('books/create', [BookController::class, 'create'])->name('books.admin.create');
Route::post('books/store', [BookController::class, 'store'])->name('books.admin.store');

Route::get('books', [BookController::class, 'listView'])->name('books.admin.listView');

Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('categories/store', [CategoryController::class, 'store'])->name('categories.store');

Route::get('categories', [CategoryController::class, 'listView'])->name('categories.listView');

Route::post('books/check-book-code', [BookController::class, 'checkBookCode'])->name('books.admin.checkBookCode');

Route::get('books/get-sub-categories/{category_id}', [BookController::class, 'getSubCategories'])->name('get.sub.categories');

Route::get('/books/detail', [BookController::class, 'detailView'])->name('books.admin.detailView');

Route::get('/books/edit', [BookController::class, 'edit'])->name('books.admin.editView');

Route::put('/books/update', [BookController::class, 'update'])->name('books.admin.updateBook');



});



Route::prefix('app')->group(function() {
    Route::get('books', [ABookController::class, 'listView'])->name('books.app.listView');
    Route::get('/books/detail', [ABookController::class, 'detailView'])->name('books.app.detailView');
    
    Route::post('books/checkout_cart', [ABookController::class, 'checkout_cart'])->name('books.app.checkout_cart');
    
    // Route DELETE để xóa sách khỏi giỏ hàng
    Route::delete('books/checkout_cart/remove/{id}', [ABookController::class, 'removeFromCart'])->name('books.app.checkout_cart.remove');
    
    // Route GET để xem giỏ hàng
    Route::get('books/checkout_cart', [ABookController::class, 'viewCart'])->name('books.app.checkout_cart.view');
    
    // Route để tiến hành thanh toán (finalize checkout)
    Route::get('books/checkout_cart/finalize', [ABookController::class, 'finalizeCheckout'])->name('books.app.checkout_cart.finalize');

    Route::post('books/cart/update', [ABookController::class, 'cartUpdate'])->name('books.app.checkout_cart.update');
});



Route::get('/webhooks', [WebhookController::class, 'handleWebhook']);


Route::get('/payment/check/{transactionId}', [PaymentController::class, 'checkPayment']); //xxx  NH sacombank k hổ trợ 


Route::get('/privacy-policy', function () {
    return view('privacy-policy');
});
Route::get('/data-deletion', function () {
    return view('data-deletion');
});
