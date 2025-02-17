<div class="container-fluid" style="background-color: #fff;">
    <div class="container py-3">
        <div class="row align-items-center">
            <!-- Thông tin liên hệ -->
            <div class="col-md-10">
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
            <div class="col-md-2 text-end position-relative"> <!-- Thêm position-relative ở đây -->
                <div class="user-auth">
                    @auth
                    <span class="me-3 text-dark" id="userDropdownToggle" style="cursor: pointer;">
                        <i class="fas fa-user me-1 text-primary"></i>{{ Auth::user()->name }}
                        <i class="fas fa-chevron-down ms-2"></i> <!-- Thêm icon hướng xuống -->
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
                    <a href="/login" class="btn btn-outline-primary btn-sm me-2">
                        <i class="fas fa-sign-in-alt"></i> Đăng nhập
                    </a>
                    @endauth
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

// Khi người dùng nhấn ra ngoài dropdown, ẩn menu
document.addEventListener('click', function(event) {
    if (!userDropdownToggle.contains(event.target) && !userDropdownMenu.contains(event.target)) {
        userDropdownMenu.style.display = 'none';
    }
});

</script>