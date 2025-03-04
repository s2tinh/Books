<!-- Navbar -->
<div class="navbarstick border">
    <div class="container-fluid m-1">
        <nav class="navbar navbar-expand-lg navbar-light bg-white" style="padding: 0;">
            <div class="container" style="padding-right: 0px;">
                <div class="row w-100 align-items-center">
                    <!-- Logo (Col-3) -->
                    <div class="col-2 col-sm-3 col-md-3">
                        <a class="navbar-brand" href="/">
                            <img id='logo' src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
                        </a>
                    </div>

                    <!-- Tìm kiếm (Col-6) -->
                    <div class="col-9 col-sm-6 col-md-6 d-flex justify-content-center">
                        <form action="{{ url('/app/books') }}" method="GET" class="d-flex w-100">
                            <!-- Thêm các tham số category_id và các tham số khác vào URL -->
                            <input id="search1" type="text" name="search" class="form-control" placeholder="Tìm kiếm..." value="{{ request()->get('search') }}" style="border: 1px solid #ddd; border-radius: 30px; padding: 0.5rem 1rem;">
                            
                            <!-- Sử dụng hidden để gửi tham số category_id cùng với tìm kiếm -->
                            <input type="hidden" name="category_id" value="{{ is_array(request()->get('category_id')) ? implode(',', request()->get('category_id')) : request()->get('category_id') }}">
                            
                            <button type="submit" class="btn btn-primary ms-2" style="border-radius: 30px;">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Giỏ hàng (Col-3) -->
                    <div class="col-1 col-sm-3 col-md-3 d-flex justify-content-end p-0">
                        <a class="nav-link text-primary circle-icon" href="/gio-hang">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </div>

                </div>
            </div>
        </nav>
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
