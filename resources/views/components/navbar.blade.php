<!-- Navbar -->
<div class="navbarstick border">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-white" style="padding: 0;">
            <div class="container">
                <div class="row w-100 align-items-center">
                    <!-- Logo (Col-3) -->
                    <div class="col-2 col-sm-2 col-md-2">
                        <a class="navbar-brand" href="/">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo" style="width: 60px;">
                        </a>
                    </div>

                    <!-- Tìm kiếm (Col-6) -->
                    <div class="col-7 col-sm-6 col-md-6 d-flex justify-content-center">
                        <form action="/search" method="GET" class="d-flex w-100">
                            <input type="text" name="query" class="form-control" placeholder="Tìm kiếm..." style="border: 1px solid #ddd; border-radius: 30px; padding: 0.5rem 1rem;">
                            <button type="submit" class="btn btn-primary ms-2" style="border-radius: 30px;">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Giỏ hàng (Col-3) -->
                    <div class="col-3 col-sm-2 col-md-2 text-end">
                        <a class="nav-link text-primary circle-icon" href="/gio-hang">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </div>
                </div>

                <!-- Toggle button for mobile view -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar collapse -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="row w-100">
                        <!-- Danh mục (Hiện ở cả PC và di động) -->
                        <div class="col-12 col-md-9 d-flex align-items-center justify-content-start">
                            <button id="toggle-category" class="btn btn-c border d-flex align-items-center text-black">
                                <i class="fas fa-list me-2"></i>
                                <span>Danh mục</span>
                                <i id="category-icon" class="fas fa-chevron-down ms-2"></i>
                            </button>
                        </div>

                        <!-- Quản lý và Giỏ hàng (Cột hiển thị ở PC, mobile sẽ ẩn đi khi nhỏ) -->
                        <div class="col-12 col-md-3">
                            <ul class="navbar-nav ms-auto">
                                @if(auth()->user() && (auth()->user()->hasRole('admin') || auth()->user()->can('manage_users')))
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAdmin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-cogs"></i> Quản lý
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownAdmin">
                                            <li><a class="dropdown-item" href="/admin">Dashboard</a></li>
                                            <li><a class="dropdown-item" href="/admin/settings">Cài đặt hệ thống</a></li>
                                        </ul>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>

<!-- Danh mục -->
<div id="category" class="container-fluid bg-c mt-3">
    <div class="container mt-4 mb-4">
        <div class="row">
            <!-- Khối thể loại sách -->
            <div class="col-md-6">
                <h6 class="text-primary">Thể loại sách:</h6>
                @foreach($categories as $category)
                    <div>
                        <label style="font-weight: 500;">
                            <input 
                                class="m-2 category-checkbox" 
                                type="checkbox" 
                                data-category-id="{{ $category['id'] }}" 
                            >
                            {{ $category['name'] }}
                        </label>
                    </div>
                    <!-- Sub-categories container -->
                    <div class="sub-category-container" id="sub-category-{{ $category['id'] }}" style="margin-left: 20px; display: none;">
                        @foreach($category['sub_categories'] as $subCategory)
                            <div>
                                <label>
                                    <input 
                                        class="m-2" 
                                        type="checkbox" 
                                        name="sub_categories[]" 
                                        value="{{ $subCategory['id'] }}" 
                                    >
                                    {{ $subCategory['name'] }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <!-- Lọc theo Ngôn ngữ -->
            <div class="col-md-3">
                <h6>Ngôn ngữ</h6>
                @foreach($languages as $key => $language)
                    <div>
                        <label>
                            <input class="m-2" type="checkbox" name="ngon_ngu[]" value="{{ $key }}"> 
                            {{ $language }}
                        </label>
                    </div>
                @endforeach
            </div>

            <!-- Lọc theo Đối tượng -->
            <div class="col-md-3">
                <h6>Đối tượng</h6>
                @foreach($ageGroups as $key => $group)
                    <div>
                        <label>
                            <input class="m-2" type="checkbox" name="doc_gia[]" value="{{ $key }}"> 
                            {{ $group }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS và Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleButton = document.getElementById('toggle-category');
        const categoryDiv = document.getElementById('category');
        const categoryIcon = document.getElementById('category-icon');

        if (toggleButton && categoryDiv && categoryIcon) {
            toggleButton.onclick = function () {
                if (categoryDiv.classList.contains('show')) {
                    categoryDiv.classList.remove('show');
                    categoryIcon.classList.remove('fa-chevron-up');
                    categoryIcon.classList.add('fa-chevron-down');
                } else {
                    categoryDiv.classList.add('show');
                    categoryIcon.classList.remove('fa-chevron-down');
                    categoryIcon.classList.add('fa-chevron-up');
                }
            };
        } else {
            console.error("Các phần tử cần thiết không tồn tại trên trang.");
        }

        // Lấy tất cả các checkbox của Category
        const categoryCheckboxes = document.querySelectorAll('.category-checkbox');

        // Thêm sự kiện 'change' cho từng checkbox
        categoryCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                const categoryId = this.getAttribute('data-category-id');
                const subCategoryContainer = document.getElementById(`sub-category-${categoryId}`);
                
                if (this.checked) {
                    // Hiển thị sub-categories khi category được check
                    subCategoryContainer.style.display = 'block';
                } else {
                    // Ẩn sub-categories khi category bị bỏ check
                    subCategoryContainer.style.display = 'none';
                    
                    // Bỏ check tất cả sub-categories bên trong
                    const subCheckboxes = subCategoryContainer.querySelectorAll('input[type="checkbox"]');
                    subCheckboxes.forEach(function (subCheckbox) {
                        subCheckbox.checked = false;
                    });
                }
            });
        });
    });




</script>
