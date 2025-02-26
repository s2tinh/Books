<div id="toggle-sidebar" class="mt-3 dashboard-block">
    <div style="display: flex; align-items: center;">
        <i id="toggle-icon" class="fas fa-bars ms-auto toggle-icon p-2" style="font-size: 17px;"></i> <!-- Icon 3 gạch ngang -->
    </div>
</div>

<div id="sidebarx" class="border sidebar bg-white p-1">
    <form action="{{ url('/app/books') }}" method="GET">
        <div class="" id="sidebar-content">

        <!-- Thể loại sách -->
        <div id="category-container" class="container mt-2 bg-white border rounded" style="height: 200px; padding: 0; overflow: hidden;">
            <div class="header p-2" style="border-bottom: 1px solid #dee2e6; text-align: left; width: 100%;" id="toggle-category">
                <h6 class="icon-sidebar m-0 d-inline-block">
                    <i class="fas fa-book"></i> Thể loại sách
                </h6>
                <i class="fas fa-chevron-down d-inline-block" id="arrow-icon-category"></i>
            </div>

            <input type="hidden" id="search2" name="search" placeholder="Search 2" value="{{ request()->get('search') }}">

            <div class="p-2" style="height: calc(100% - 50px); overflow-y: auto;" id="category-content">
                @foreach($categories2 as $category)
                    <div>
                        <label style="font-weight: 500;">
                            <input 
                                name="category_id[]" 
                                class="m-2 category-checkbox" 
                                type="checkbox" 
                                data-category-id="{{ $category['id'] }}" 
                                value="{{ $category['id'] }}" 
                                {{ in_array($category['id'], (array) request()->input('category_id', [])) ? 'checked' : '' }} 
                            >
                            {{ $category['name'] }}
                        </label>
                    </div>
                    <div class="sub-category-container" id="sub-category-{{ $category['id'] }}" style="margin-left: 20px; display: none;">
                    @foreach($category['sub_categories'] as $subCategory)
                        <div>
                            <label>
                                <input 
                                    class="m-2" 
                                    type="checkbox" 
                                    name="sub_category_id[]" 
                                    value="{{ $subCategory['id'] }}"
                                    @if(in_array($subCategory['id'], request()->input('sub_category_id', []))) checked @endif
                                >
                                {{ $subCategory['name'] }}
                            </label>
                        </div>
                    @endforeach
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Đối tượng -->
        <div id="target-audience-container" class="container mt-2 bg-white border rounded" style="height: 200px; padding: 0; overflow: hidden;">
            <div class="header p-2" style="border-bottom: 1px solid #dee2e6; text-align: left; width: 100%;" id="toggle-target-audience">
                <h6 class="icon-sidebar m-0 d-inline-block">
                    <i class="fas fa-users"></i> Đối tượng
                </h6>
                <i class="fas fa-chevron-down d-inline-block" id="arrow-icon-target-audience"></i>
            </div>
            <div class="p-2" style="height: calc(100% - 50px); overflow-y: auto;" id="target-audience-content">
                <!-- Độ tuổi -->
                <h6 class="text-primary">Độ tuổi</h6>
                @foreach($ageGroups as $key => $group)
                    <div>
                        <label>
                            <input 
                                class="m-2" 
                                type="checkbox" 
                                name="age_group[]" 
                                value="{{ $key }}"
                                @if(in_array($key, request()->input('age_group', []))) checked @endif
                            >
                            {{ $group }}
                        </label>
                    </div>
                @endforeach

                <!-- Ngôn ngữ -->
                <h6 class="text-primary mt-3">Ngôn ngữ</h6>
                @foreach($languages as $key => $language)
                    <div>
                        <label>
                            <input class="m-2" 
                            type="checkbox" 
                            name="language[]" 
                            value="{{ $key }}" 
                            @if(in_array($key, request()->input('language', []))) checked @endif
                            >
                            {{ $language }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Giá -->
        <div id="price-container" class="container mt-2 bg-white border rounded" style="height: 130px; padding: 0; overflow: hidden;">
            <div class="header p-2" style="border-bottom: 1px solid #dee2e6; text-align: left; width: 100%;" id="toggle-price">
                <h6 class="icon-sidebar m-0 d-inline-block">
                    <i class="fas fa-coins"></i> Giá
                </h6>
                <i class="fas fa-chevron-down d-inline-block" id="arrow-icon-price"></i>
            </div>
            <div class="p-2" style="height: calc(100% - 50px); overflow-y: auto;" id="price-content">
                <div class="row g-2">
                    <div class="col-6">
                        <input type="number" id="price-min" name="price-min" class="form-control" placeholder="Giá tối thiểu" value="10000" min="0" max="1000000">
                    </div>
                    <div class="col-6">
                        <input type="number" id="price-max" name="price-max" class="form-control" placeholder="Giá tối đa" value="150000" min="0" max="1000000">
                    </div>
                </div>
                <div id="price-slider" class="mt-3"></div>
            </div>
        </div>

        <!-- Nhà xuất bản -->
        <div id="div-publisher" class="container mt-2 bg-white border rounded" style="height: 200px; padding: 0; overflow: hidden;">
            <div class="header p-2" style="border-bottom: 1px solid #dee2e6; text-align: left; width: 100%;" id="toggle-header">
                <h6 class="icon-sidebar m-0 d-inline-block">
                    <i class="fas fa-book"></i> Nhà xuất bản
                </h6>
                <i class="fas fa-chevron-down d-inline-block" id="arrow-icon"></i>
            </div>
            <div class="p-2" style="height: calc(100% - 50px); overflow-y: auto;" id="checkbox-content">
                <div class="form-check">
                    @foreach ($arrbooks['publisher'] as $id => $publisher)
                        <div>
                            <label>
                                <input 
                                    class="m-2" 
                                    type="checkbox" 
                                    name="publisher[]" 
                                    value="{{ $publisher }}" 
                                    @if(in_array($publisher, request()->input('publisher', []))) checked @endif
                                >
                                {{ $publisher }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Tác giả -->
        <div id="div-author" class="container mt-2 bg-white border rounded" style="height: 200px; padding: 0; overflow: hidden;">
            <div class="header p-2" style="border-bottom: 1px solid #dee2e6; text-align: left; width: 100%;" id="toggle-header-author">
                <h6 class="icon-sidebar m-0 d-inline-block">
                    <i class="fas fa-user"></i> Tác giả
                </h6>
                <i class="fas fa-chevron-down d-inline-block" id="arrow-icon-author"></i>
            </div>
            <div class="p-2" style="height: calc(100% - 50px); overflow-y: auto;" id="checkbox-content-author">
                <div class="form-check">
                    @foreach ($arrbooks['author'] as $id => $author)
                        <div>
                            <label>
                                <input 
                                    class="m-2" 
                                    type="checkbox" 
                                    name="author[]" 
                                    value="{{ $author }}" 
                                    @if(in_array($author, request()->input('author', []))) checked @endif
                                >
                                {{ $author }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-sm btn-danger w-100 mt-2">Lọc</button>

    </div>
    </form>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.1/nouislider.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.1/nouislider.min.js"></script>




<script>
    
    // Chạy khi trang đã tải xong
document.addEventListener('DOMContentLoaded', function () {
    // Lặp qua tất cả các checkbox category
    document.querySelectorAll('.category-checkbox').forEach(function (categoryCheckbox) {
        // Kiểm tra nếu checkbox đã được chọn
        if (categoryCheckbox.checked) {
            const categoryId = categoryCheckbox.getAttribute('data-category-id');
            // Hiển thị sub-categories tương ứng với category được chọn
            const subCategoryContainer = document.getElementById('sub-category-' + categoryId);
            if (subCategoryContainer) {
                subCategoryContainer.style.display = 'block';
            }
        }
    });

    // Thêm sự kiện cho các category-checkbox để toggle sub-categories khi người dùng thay đổi
    document.querySelectorAll('.category-checkbox').forEach(function (categoryCheckbox) {
        categoryCheckbox.addEventListener('change', function () {
            const categoryId = categoryCheckbox.getAttribute('data-category-id');
            const subCategoryContainer = document.getElementById('sub-category-' + categoryId);
            if (categoryCheckbox.checked) {
                subCategoryContainer.style.display = 'block'; // Hiển thị sub-categories
            } else {
                subCategoryContainer.style.display = 'none'; // Ẩn sub-categories
            }
        });
    });
});

</script>
<style>
    #price-slider {
        width: 100%;
        height: 8px;
        margin: 20px 0;
    }

    .noUi-connect {
        background: #007bff;
    }

    .noUi-handle {
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: #007bff;
        border: none;
        cursor: pointer;
    }

    .noUi-tooltip {
        background: #007bff;
        color: #fff;
        border-radius: 5px;
        padding: 5px;
    }
</style>