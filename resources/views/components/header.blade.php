<div class="container-fluid" style="background-color: #fff;">
    <div class="container py-3">
        <div class="row align-items-center">
            <!-- Thông tin liên hệ -->
            <div class="col-md-4">
                <div class="contact-info">
                    <p class="mb-1">
                        <i class="fas fa-envelope me-2 text-primary"></i>
                        <a href="mailto:tranvoanhtinh@gmail.com" class="text-dark text-decoration-none">tranvoanhtinh@gmail.com</a>
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-phone-alt me-2 text-primary"></i>
                        <a href="tel:0377044322" class="text-dark text-decoration-none">0377044322</a>
                    </p>
                </div>
            </div>



            <!-- Tài khoản -->
            <div class="col-md-8 text-end">
                <div class="user-auth">
                    @auth
                    <span class="me-3 text-dark">
                        <i class="fas fa-user me-1 text-primary"></i>{{ Auth::user()->name }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                        </button>
                    </form>
                    @else
                    <a href="/login" class="btn btn-outline-primary btn-sm me-2">
                        <i class="fas fa-sign-in-alt"></i> Đăng nhập
                    </a>
                    <a href="/register" class="btn btn-primary btn-sm">
                        <i class="fas fa-user-plus"></i> Đăng ký
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
