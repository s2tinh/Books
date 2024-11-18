<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // Hàm hiển thị danh sách sản phẩm
    public function index()
    {
        // Lấy tất cả sản phẩm từ cơ sở dữ liệu
        $products = Product::all();

        // Trả về view với dữ liệu sản phẩm
        return view('pages.home', compact('products'));
    }
}
