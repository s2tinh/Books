<div class="container-fluid text-light" style="background-color: rgb(29 66 100);">
<div class="container">
    <div class="row">
        <!-- Thông tin liên hệ (bên trái) -->
        <div class="col-md-6">
            <div class="info d-flex">
                <div class="me-3 d-flex align-items-center p-1">
                    <a href="mailto:example@gmail.com" class="email-link d-flex align-items-center text-type-1">
                        <i class="fas fa-envelope me-2"></i> Email: example@gmail.com
                    </a>
                </div>
                <div class="me-3 d-flex align-items-center p-1">
                    <a href="tel:0123456789" class="d-flex align-items-center text-type-1">
                        <i class="fas fa-phone-alt me-2"></i> Số điện thoại: 0377044322
                    </a>
                </div>
            </div>
        </div>

        <!-- Mạng xã hội và tài khoản (bên phải) -->
        <div class="col-md-6 d-flex justify-content-end">
            <div class="social d-flex">
                <!-- Tìm kiếm -->
                <div class="search-popup d-flex align-items-center me-3  p-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tìm kiếm">
                    <a href="javascript:void(0)" class="d-flex align-items-center text-type-1">
                        <i class="fas fa-search me-2"></i>
                    </a>
                </div>

                <!-- Nếu người dùng đã đăng nhập -->
                @auth
                    <!-- Đăng nhập -->
                    <div class="d-flex align-items-center me-3  p-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tên người dùng">
                        <span class="d-flex align-items-center text-type-1">
                            <i class="fas fa-user me-2"></i>{{ Auth::user()->name }} <!-- Tên người dùng -->
                        </span>
                    </div>


                    <div class="d-flex align-items-center  p-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Đăng xuất">

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf <!-- Token CSRF để bảo mật -->
                            <button type="submit" class="logout-link ms-2 bg-transparent  p-0" title="Đăng xuất">
                                <i class="fas fa-sign-out-alt text-type-1"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Đăng nhập -->
                    <div class="d-flex align-items-center me-3  p-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Đăng nhập">
                        <a href="/login" class="d-flex align-items-center text-type-1">
                            <i class="fas fa-sign-in-alt me-2"></i>
                        </a>
                    </div>

                    <!-- Đăng ký -->
                    <div class="d-flex align-items-center  p-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Đăng ký">

                        <a href="/register" class="d-flex align-items-center text-type-1">
                            <i class="fas fa-user-plus me-2"></i>
                        </a>
                    </div>
                @endauth

            </div>
        </div>
    </div>
</div>
</div>