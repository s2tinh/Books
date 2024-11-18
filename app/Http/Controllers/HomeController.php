<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Hàm hiển thị trang chủ
    public function index()
    {
        return view('pages.home'); // Trả về view cho trang chủ
    }
}
