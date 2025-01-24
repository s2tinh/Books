<!-- Navbar -->
<div class="navbarstick border">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-white" style="padding: 0;">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand" href="/" style="position: relative; display: inline-block;">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo" style="width: 60px;">
                </a>

                <!-- Toggle button for mobile view -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar links -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="row w-100">
                        <!-- Danh mục -->
              <div class="col-md-3 d-flex align-items-center">
                <button id="toggle-category" class="btn btn-c border d-flex align-items-center text-black">
                    <i class="fas fa-list me-2"></i>
                    <span>Danh mục</span>
                    <i id="category-icon" class="fas fa-chevron-down ms-2"></i>
                </button>
            </div>

                        <!-- Tìm kiếm -->
            <div class="col-md-4 text-center">
                <div class="search-box">
                    <form action="/search" method="GET" class="d-flex">
                        <input type="text" name="query" class="form-control" placeholder="Tìm kiếm..." style="border: 1px solid #ddd; border-radius: 30px; padding: 0.5rem 1rem; width: 100%;">
                        <button type="submit" class="btn btn-primary ms-2" style="border-radius: 30px;">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
                        <!-- Links -->
            <div class="col-md-5 d-flex justify-content-end" style="padding-right: 0px;">
                            <ul class="navbar-nav ms-auto">
              
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Dịch vụ
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="/dich-vu/de-xuat">Đề xuất</a></li>
                                        <li><a class="dropdown-item" href="/dich-vu/khac">Khác</a></li>
                                        <li><a class="dropdown-item" href="/dich-vu/tu-van">Tư vấn</a></li>
                                    </ul>
                                </li>


                                <li class="nav-item">
                                    <a class="nav-link" href="/tin-tuc">Tin tức</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/gioi-thieu">Giới thiệu</a>
                                </li>
  

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
                                <li class="nav-item">
                                    <a class="nav-link text-primary circle-icon" href="/gio-hang">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
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

</div>
<script>
    if(document.getElementById('category')){
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
    });

}
   document.addEventListener('DOMContentLoaded', function () {
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


