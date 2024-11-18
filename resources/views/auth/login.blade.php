@extends('layouts.app') <!-- Kế thừa từ layout chính -->

@section('content')
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center">
    <div class="bg-white p-5 shadow rounded" style="width: 400px;">
        <h2 class="text-center pb-5">Đăng Nhập</h2>
        
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

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <input type="text" id="email" name="email" 
                       class="form-control bg-white border-0 border-bottom rounded-0 shadow-none" 
                       placeholder="Nhập Email" value="{{ old('email') }}" required>
            </div>
            <div class="mb-4">
                <input type="password" id="password" name="password" 
                       class="form-control bg-white border-0 border-bottom rounded-0 shadow-none" 
                       placeholder="Nhập Mật khẩu" required>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('password.request') }}" class="text-decoration-none">Quên mật khẩu?</a>
                <button type="submit" class="btn btn-primary">Đăng Nhập</button>
            </div>
        </form>
        <hr>
        <div class="text-center mt-3">
            <p class="mb-2">Hoặc đăng nhập bằng:</p>
            <button class="btn btn-light border rounded-circle mx-1">
                <i class="bi bi-facebook text-primary"></i>
            </button>
            <button class="btn btn-light border rounded-circle mx-1">
                <i class="bi bi-google text-danger"></i>
            </button>
        </div>
        <div class="text-center mt-3">
            <p>Chưa có tài khoản? <a href="{{ route('register') }}" class="text-decoration-none">Đăng ký ngay</a></p>
        </div>
    </div>
</div>
@endsection
