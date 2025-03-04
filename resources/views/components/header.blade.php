<div class="container-fluid" style="background-color: #fff;">
    <div class="container py-3">
        <div class="row align-items-center">
            <!-- Thông tin liên hệ -->
            <div class="col-md-8">
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
            <div class="col-md-4 text-end position-relative">
                <div class="user-auth">
                    @auth
                    <span class="me-3 text-dark" id="userDropdownToggle" style="cursor: pointer;">
                        <i class="fas fa-user me-1 text-primary"></i>{{ Auth::user()->name }}
                        <i class="fas fa-chevron-down ms-2"></i>
                    </span>
                    <ul id="userDropdownMenu" class="dropdown-menu-end" style="display: none;">
                        <li><a class="dropdown-item" href="/admin" style="color: white;">Dashboard</a></li>
                        <li><a class="dropdown-item" href="/admin/settings" style="color: white;">Cài đặt hệ thống</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item" style="color: white;">
                                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                </button>
                            </form>
                        </li>
                    </ul>
                    @else
                    <a href="#" class="btn btn-outline-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="fas fa-sign-in-alt"></i> Đăng nhập
                    </a>
                    <a href="#" class="btn btn-outline-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#registerModal">
                        <i class="fas fa-user-plus"></i> Đăng ký
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hiển thị thông báo lỗi nếu có -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Modal Đăng Nhập -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 shadow-lg p-3">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="loginModalLabel">Đăng Nhập</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="loginForm" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label text-muted">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Nhập email" value="{{ old('email') }}" required style="max-width: 100%;">
                        <small class="text-danger" id="emailError"></small>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label text-muted">Mật khẩu</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required style="max-width: 100%;">
                        <small class="text-danger" id="passwordError"></small>
                    </div>
                    <div id="error-container" class="alert alert-danger d-none"></div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('password.request') }}" class="text-decoration-none text-muted">Quên mật khẩu?</a>
                        <button type="submit" class="btn btn-primary">Đăng Nhập</button>
                    </div>
                </form>
            </div>
                <div class="modal-footer border-0">
                    <div class="text-center w-100">
                        <p class="mb-2 text-muted">Hoặc đăng nhập bằng:</p>
                        <div class="d-flex justify-content-center">
                            <!-- Nút đăng nhập bằng Facebook -->
                            <a href="{{ route('auth.facebook') }}" class="btn btn-light border rounded-circle mx-2">
                                <i class="bi bi-facebook text-primary"></i>
                            </a>
                            <!-- Nút đăng nhập bằng Google -->
                            <a href="{{ route('login.google') }}" class="btn btn-light border rounded-circle mx-2">
                                <i class="bi bi-google text-danger"></i>
                            </a>
                        </div>
                    </div>
                </div>

        </div>
    </div>
</div>

<!-- Modal Đăng Ký -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 shadow-lg p-3">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="registerModalLabel">Đăng Ký</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registerForm" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label text-muted">Tên</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Nhập tên" required value="{{ old('name') }}">
                        <small class="text-danger" id="nameError"></small>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label text-muted">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Nhập email" required value="{{ old('email') }}">
                        <small class="text-danger" id="emailError"></small>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label text-muted">Mật khẩu</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
                        <small class="text-danger" id="passwordError"></small>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label text-muted">Xác nhận mật khẩu</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Xác nhận mật khẩu" required>
                        <small class="text-danger" id="passwordConfirmationError"></small>
                    </div>
                    <div id="error-container" class="alert alert-danger d-none"></div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Đăng Ký</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <div class="text-center w-100">
                    <p class="mb-2 text-muted">Hoặc đăng ký bằng:</p>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-light border rounded-circle mx-2">
                            <i class="bi bi-facebook text-primary"></i>
                        </button>
                        <button class="btn btn-light border rounded-circle mx-2">
                            <i class="bi bi-google text-danger"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Lấy các phần tử cần thiết
    const userDropdownToggle = document.getElementById('userDropdownToggle');
    const userDropdownMenu = document.getElementById('userDropdownMenu');

    // Khi người dùng nhấn vào tên người dùng
    userDropdownToggle.addEventListener('click', function() {
        // Kiểm tra xem menu có đang mở không
        if (userDropdownMenu.style.display === 'block') {
            // Nếu đã mở, ẩn menu
            userDropdownMenu.style.display = 'none';
        } else {
            // Nếu chưa mở, hiển thị menu
            userDropdownMenu.style.display = 'block';
        }
    });
</script>
