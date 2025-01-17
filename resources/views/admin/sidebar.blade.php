<div class="sidebar bg-white p-1">
  <div class="mt-3 dashboard-block">
    <div style="display: flex; align-items: center;">
        <p id="sidebar-dashboard" class="h4" style="margin-right: 10px;">
            DASHBOARD
        </p>
        <i id="toggle-icon" class="fas fa-bars ms-auto toggle-icon border p-2" style="font-size: 17px;"></i> <!-- Icon 3 gạch ngang -->
    </div>
    <hr id="sidebar-hr" style="width: 80%; margin-top: 10px; border: 1px solid #000;">
</div>

    <ul class="nav flex-column" id="sidebar-content">
        <!-- Quản lý sách (Dropdown ẩn) -->
        <li class="nav-item">
            <a class="nav-link custom-nav-link" href="#" id="booksLink">
                <i class="fas fa-book icon-color"></i> Quản lý sách
                <i class="fas fa-chevron-down float-end"></i> <!-- Biểu tượng mở/đóng -->
            </a>
            <ul class="collapse" id="booksDropdown">
                <li><a class="dropdown-item" href="{{ route('books.admin.listView')}}"><i class="fas fa-circle"></i> Danh sách sách</a></li>
                <li><a class="dropdown-item" href="{{ route('books.admin.create') }}"><i class="fas fa-circle"></i> Thêm sách mới</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-circle"></i> Quản lý thể loại</a></li>
            </ul>
        </li>

        <!-- Quản lý thể loại sách (Dropdown ẩn) -->
        <li class="nav-item">
            <a class="nav-link custom-nav-link" href="#" id="categoriesLink">
                <i class="fas fa-archive icon-color"></i> Thể loại sách
                <i class="fas fa-chevron-down float-end"></i> <!-- Biểu tượng mở/đóng -->
            </a>
            <ul class="collapse" id="categoriesDropdown">
                <li><a class="dropdown-item" href="{{route('categories.listView')}}"><i class="fas fa-circle"></i> Danh sách thể loại</a></li>
                <li><a class="dropdown-item" href="{{route('categories.create')}}"><i class="fas fa-circle"></i> Thêm thể loại</a></li>
            </ul>
        </li>

        <!-- Quản lý người dùng (Dropdown ẩn) -->
        <li class="nav-item">
            <a class="nav-link custom-nav-link" href="#" id="usersLink">
                <i class="fas fa-user icon-color"></i> Quản lý người dùng
                <i class="fas fa-chevron-down float-end"></i> <!-- Biểu tượng mở/đóng -->
            </a>
            <ul class="collapse" id="usersDropdown">
                <li><a class="dropdown-item" href="#"><i class="fas fa-circle"></i> Danh sách người dùng</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-circle"></i> Thêm người dùng</a></li>
            </ul>
        </li>

        <!-- Quản lý đơn hàng (Dropdown ẩn) -->
        <li class="nav-item">
            <a class="nav-link custom-nav-link" href="#" id="ordersLink">
                <i class="fas fa-cart-plus icon-color"></i> Quản lý đơn hàng
                <i class="fas fa-chevron-down float-end"></i> <!-- Biểu tượng mở/đóng -->
            </a>
            <ul class="collapse" id="ordersDropdown">
                <li><a class="dropdown-item" href="#"><i class="fas fa-circle"></i> Danh sách đơn hàng</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-circle"></i> Thêm đơn hàng mới</a></li>
            </ul>
        </li>

        <!-- Báo cáo (Dropdown ẩn) -->
        <li class="nav-item">
            <a class="nav-link custom-nav-link" href="#" id="reportsLink">
                <i class="fas fa-chart-bar icon-color"></i> Báo cáo
                <i class="fas fa-chevron-down float-end"></i> <!-- Biểu tượng mở/đóng -->
            </a>
            <ul class="collapse" id="reportsDropdown">
                <li><a class="dropdown-item" href="#"><i class="fas fa-circle"></i> Báo cáo doanh thu</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-circle"></i> Báo cáo sản phẩm</a></li>
            </ul>
        </li>

        <!-- Cài đặt (Dropdown ẩn) -->
        <li class="nav-item">
            <a class="nav-link custom-nav-link" href="#" id="settingsLink">
                <i class="fas fa-cogs icon-color"></i> Tùy chọn
                <i class="fas fa-chevron-down float-end"></i> <!-- Biểu tượng mở/đóng -->
            </a>
            <ul class="collapse" id="settingsDropdown">
                <li>
                    <a class="dropdown-item" href="{{ route('home') }}">
                        <i class="fas fa-circle"></i>
                     Trang chủ
                    </a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-circle"></i>
                 </i> Đăng xuất
                        </button>
                    </form>
                </li>
            </ul>
        </li>

    </ul>
</div>

