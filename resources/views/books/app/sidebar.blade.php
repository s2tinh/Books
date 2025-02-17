<div id="toggle-sidebar" class="mt-3 dashboard-block">
    <div style="display: flex; align-items: center;">
        <i id="toggle-icon" class="fas fa-bars ms-auto toggle-icon  p-2" style="font-size: 17px;"></i> <!-- Icon 3 gạch ngang -->
    </div>
</div>


<div id="sidebarx" class="border sidebar bg-white p-1">

<!-- Thể loại sách -->
<div id="category-container" class="container mt-2 bg-white border rounded" style="height: 200px; padding: 0; overflow: hidden;">
    <!-- Tiêu đề -->
    <div class="header p-2" style="border-bottom: 1px solid #dee2e6; text-align: left; width: 100%;" id="toggle-category">
        <h6 class="icon-sidebar m-0 d-inline-block">
            <i class="fas fa-book"></i> Thể loại sách
        </h6>
        <i class="fas fa-chevron-down d-inline-block" id="arrow-icon-category"></i>
    </div>

    <!-- Nội dung -->
    <div class="p-2" style="height: calc(100% - 50px); overflow-y: auto;" id="category-content">
        <form>
            @foreach($categories2 as $category)
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
        </form>
    </div>
</div>

<!-- Đối tượng -->
<div id="target-audience-container" class="container mt-2 bg-white border rounded" style="height: 200px; padding: 0; overflow: hidden;">
    <!-- Tiêu đề -->
    <div class="header p-2" style="border-bottom: 1px solid #dee2e6; text-align: left; width: 100%;" id="toggle-target-audience">
        <h6 class="icon-sidebar m-0 d-inline-block">
            <i class="fas fa-users"></i> Đối tượng
        </h6>
        <i class="fas fa-chevron-down d-inline-block" id="arrow-icon-target-audience"></i>
    </div>
    
    <!-- Nội dung -->
    <div class="p-2" style="height: calc(100% - 50px); overflow-y: auto;" id="target-audience-content">
        <form>
            <!-- Độ tuổi -->
            <h6 class="text-primary">Độ tuổi</h6>
            @foreach($ageGroups as $key => $group)
                <div>
                    <label>
                        <input class="m-2" type="checkbox" name="doc_gia[]" value="{{ $key }}"> 
                        {{ $group }}
                    </label>
                </div>
            @endforeach

            <!-- Ngôn ngữ -->
            <h6 class="text-primary mt-3">Ngôn ngữ</h6>
            @foreach($languages as $key => $language)
                <div>
                    <label>
                        <input class="m-2" type="checkbox" name="ngon_ngu[]" value="{{ $key }}"> 
                        {{ $language }}
                    </label>
                </div>
            @endforeach
        </form>
    </div>
</div>


    <div class="nav flex-column" id="sidebar-content">
    <div id="price-container" class="container mt-2 bg-white border rounded" style="height: 130px; padding: 0; overflow: hidden;">
        <!-- Tiêu đề -->
        <div class="header p-2" style="border-bottom: 1px solid #dee2e6; text-align: left; width: 100%;" id="toggle-price">
            <h6 class="icon-sidebar m-0 d-inline-block">
                <i class="fas fa-coins"></i> Giá
            </h6>
            <i class="fas fa-chevron-down d-inline-block" id="arrow-icon-price"></i>
        </div>

        <!-- Nội dung -->
        <div class="p-2" style="height: calc(100% - 50px); overflow-y: auto;" id="price-content">
            <form>
                <div class="row g-2">
                    <!-- Input giá thấp -->
                    <div class="col-6">
                        <input type="number" id="price-min" class="form-control" placeholder="Giá tối thiểu" value="10000" min="0" max="1000000">
                    </div>
                    <!-- Input giá cao -->
                    <div class="col-6">
                        <input type="number" id="price-max" class="form-control" placeholder="Giá tối đa" value="150000" min="0" max="1000000">
                    </div>
                </div>
                <!-- Thanh trượt giá -->
                <div id="price-slider" class="mt-3"></div>
            </form>
        </div>
    </div>

<div id="div-publisher" class="container mt-2 bg-white border rounded" style="height: 200px; padding: 0; overflow: hidden;">
    <!-- Tiêu đề -->
    <div class="header p-2" style="border-bottom: 1px solid #dee2e6; text-align: left; width: 100%;" id="toggle-header">
        <h6 class="icon-sidebar m-0 d-inline-block">
            <i class="fas fa-book"></i> Nhà xuất bản
        </h6>
        <i class="fas fa-chevron-down d-inline-block" id="arrow-icon"></i>
    </div>

    <!-- Danh sách checkbox -->
    <div class="p-2" style="height: calc(100% - 50px); overflow-y: auto;" id="checkbox-content">
        <form>
            <div class="form-check">
                @foreach ($arrbooks as $book)
                    <input type="checkbox" class="form-check-input" id="publisher-{{ $book['publisher'] }}" value="{{ $book['publisher'] }}">
                    <label class="form-check-label" for="publisher-{{ $book['publisher'] }}">
                        {{ $book['publisher'] }}
                    </label><br>
                @endforeach
            </div>
        </form>
    </div>
</div>

<div id="div-author" class="container mt-2 bg-white border rounded" style="height: 200px; padding: 0; overflow: hidden;">
    <!-- Tiêu đề -->
    <div class="header p-2" style="border-bottom: 1px solid #dee2e6; text-align: left; width: 100%;" id="toggle-header-author">
        <h6 class="icon-sidebar m-0 d-inline-block">
            <i class="fas fa-user"></i> Tác giả
        </h6>
        <i class="fas fa-chevron-down d-inline-block" id="arrow-icon-author"></i>
    </div>

    <!-- Danh sách checkbox -->
    <div class="p-2" style="height: calc(100% - 50px); overflow-y: auto;" id="checkbox-content-author">
        <form>
            <div class="form-check">
                @foreach ($arrbooks as $book)
                    <input type="checkbox" class="form-check-input" id="author-{{ strtoupper($book['author']) }}" value="{{ strtoupper($book['author']) }}">
                    <label class="form-check-label" for="author-{{ strtoupper($book['author']) }}">
                        {{ strtoupper($book['author']) }}
                    </label><br>
                @endforeach
            </div>
        </form>
    </div>
</div>



    </div>
</div>
<link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.1/nouislider.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.1/nouislider.min.js"></script>


<style>
    #price-slider {
        width: 100%;
        height: 8px; /* Chiều cao của thanh trượt */
        margin: 20px 0;
    }

    .noUi-connect {
        background: #007bff; /* Màu xanh cho phần kết nối */
    }

    .noUi-handle {
        width: 4px; /* Đường kính chấm tròn nhỏ lại */
        height: 4px; /* Chiều cao chấm tròn nhỏ lại */
        border-radius: 50%;
        background: #007bff; /* Màu xanh cho chấm tròn */
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
