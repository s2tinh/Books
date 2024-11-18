<!-- Navbar -->
<div class="navbarstick">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand" href="/" style="position: relative; display: inline-block;">
                    <!-- Logo chính -->
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo" style="width: 100px;">
                    <!-- Ảnh book căn góc dưới cùng và dịch phải -->
                    <img src="{{ asset('images/book.png') }}" alt="Book" style="width: 80px; position: absolute; bottom: 0; right: -40px;">
                </a>

                <!-- Toggle button for mobile view -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar links -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <!-- Trang chủ -->
                        <li class="nav-item">
                            <a class="nav-link" href="/">Trang chủ</a>
                        </li>

                        <!-- Dịch vụ (Dropdown) -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dịch vụ
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/dich-vu/de-xuat">Đề xuất</a></li>
                                <li><a class="dropdown-item" href="/dich-vu/khac">Khác</a></li>
                                <li><a class="dropdown-item" href="/dich-vu/tu-van">Tư vấn</a></li>
                                <li><a class="dropdown-item" href="/dich-vu/dich-vu-1">Dịch vụ 1</a></li>
                                <li><a class="dropdown-item" href="/dich-vu/dich-vu-2">Dịch vụ 2</a></li>
                                <li><a class="dropdown-item" href="/dich-vu/dich-vu-3">Dịch vụ 3</a></li>
                                <li><a class="dropdown-item" href="/dich-vu/dich-vu-4">Dịch vụ 4</a></li>
                            </ul>
                        </li>

                        <!-- Tin tức -->
                        <li class="nav-item">
                            <a class="nav-link" href="/tin-tuc">Tin tức</a>
                        </li>

                        <!-- Giới thiệu -->
                        <li class="nav-item">
                            <a class="nav-link" href="/gioi-thieu">Giới thiệu</a>
                        </li>

                        <!-- Liên hệ -->
                        <li class="nav-item">
                            <a class="nav-link" href="/lien-he">Liên hệ</a>
                        </li>

                        <!-- Giỏ hàng -->
                        <li class="nav-item">
                            <a class="nav-link text-type-1 border" href="/gio-hang">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                        </li>


                        
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
