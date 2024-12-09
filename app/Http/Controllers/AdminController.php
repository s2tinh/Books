<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Hiển thị trang dashboard của Admin.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('pages.administration');
    }  
}
