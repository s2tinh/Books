@extends('layouts.app')

@section('content')
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center">
    <div class="bg-white p-5 shadow rounded" style="width: 400px;">
        <h2 class="text-center pb-5">Đăng Ký</h2>
        
        <!-- Hiển thị lỗi nếu có -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <!-- Trường nhập tên -->
            <div class="mb-4">
                <input type="text" id="name" name="name" 
                       class="form-control bg-white border-0 border-bottom rounded-0 shadow-none" 
                       placeholder="Nhập tên" required value="{{ old('name') }}">
            </div>
            <div class="mb-4">
                <input type="email" id="email" name="email" 
                       class="form-control bg-white border-0 border-bottom rounded-0 shadow-none" 
                       placeholder="Nhập email" required value="{{ old('email') }}">
            </div>
            <div class="mb-4">
                <input type="password" id="password" name="password" 
                       class="form-control bg-white border-0 border-bottom rounded-0 shadow-none" 
                       placeholder="Nhập mật khẩu" required>
            </div>
            <div class="mb-4">
                <input type="password" id="password_confirmation" name="password_confirmation" 
                       class="form-control bg-white border-0 border-bottom rounded-0 shadow-none" 
                       placeholder="Xác nhận mật khẩu" required>
            </div>
            <!-- Đặt nút Đăng Ký bên phải -->
            <div class="mb-4 text-end">
                <button type="submit" class="btn btn-primary">Đăng Ký</button>
            </div>
            <div class="text-center mt-3">
                <p class="mb-2">Hoặc đăng nhập bằng:</p>
                <button class="btn btn-light border rounded-circle mx-1">
                    <i class="bi bi-facebook text-primary"></i>
                </button>
                <button class="btn btn-light border rounded-circle mx-1">
                    <i class="bi bi-google text-danger"></i>
                </button>
            </div>
            <!-- Đặt liên kết "Đã có tài khoản" xuống dưới -->
            <div class="text-center">
                <p>Đã có tài khoản? <a href="{{ route('login') }}" class="text-decoration-none">Đăng nhập ngay</a></p>
            </div>
        </form>
    </div>
</div>
@endsection
