@extends('layouts.app') <!-- Kế thừa layout chính -->

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">Quên Mật Khẩu</h2>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email của bạn" required>
        </div>
        <button type="submit" class="btn btn-primary">Gửi Yêu Cầu</button>
    </form>
</div>
@endsection
