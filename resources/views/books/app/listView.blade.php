<!-- resources/views/books/listView.blade.php -->
@extends('layouts.admin') <!-- Kế thừa layout admin -->

@section('title', 'Danh sách sách')

@section('content')


<div id="headder-listview" class="container-fluid bg-c p-3" style="padding-left: 0px !important; padding-right: 0px !important; padding-bottom: 0px !important ;">
    <div class="container">
        <div class="row align-items-center">
            <!-- Bên trái thanh tìm kiếm -->
            <div class="col-md-3 d-flex align-items-center">
                <button  id="toggle-category" class="btn btn-c border d-flex align-items-center">
                    <i class="fas fa-list me-2"></i> 
                    <span>Danh mục</span> 
                    <i  id="category-icon" class="fas fa-chevron-down ms-2"></i>
                </button>
            </div>

            <!-- Thanh tìm kiếm -->
            <div class="col-md-6 mx-auto">
                <form action="#" method="GET" class="d-flex">
                    <input type="text" style="background-color: white; width: 100%; border: 0.5px solid #ccc;" 
                           name="query" 
                           class="form-control-sm bg-white rounded-0 shadow-none" 
                           placeholder="Tìm kiếm..." 
                           aria-label="Tìm kiếm">
                    <button type="submit" class="btn btn-danger rounded-0 shadow-none">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Bên phải thanh tìm kiếm -->
            <div class="col-md-3 d-flex justify-content-end">
                <button id="toggle-advanced-filter" class="btn btn-c border">
                    <i class="fas fa-filter me-2"></i> Bộ lọc nâng cao
                </button>
            </div>
        </div>
    </div>
<!-- Lọc theo Danh mục -->
<div id="category" class="container-fluid bg-c mt-3">
    <div class="container mt-4 mb-4">
        <div class="row">
            <!-- Khối thể loại sách -->
            <div class="col-md-6">
                <h6>Thể loại sách:</h6>
                @foreach($categories as $category)
                    <div>
                        <label>
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

<!-- Lọc nâng cao -->
<div id="advanced-filtering"  class="container-fluid bg-c">

    <div class="container mb-4">
        <div class="row">
            <!-- Bộ lọc theo book_code -->
            <div class="col-md-3">
                <h6>Mã sách:</h6>
                <input type="text" class="bg-input form-control-sm form-control border-0 border-bottom rounded-0 shadow-none search-input" name="book_code" placeholder="Nhập mã sách" />
            </div>

            <!-- Bộ lọc theo author -->
            <div class="col-md-3">
                <h6>Tác giả:</h6>
                <input type="text" class="bg-input form-control-sm form-control border-0 border-bottom rounded-0 shadow-none search-input" name="author" placeholder="Nhập tác giả" />
            </div>

            <!-- Bộ lọc theo publisher -->
            <div class="col-md-3">
                <h6>Nxb:</h6>
                <input type="text" class="bg-input form-control-sm form-control border-0 border-bottom rounded-0 shadow-none search-input" name="publisher" placeholder="Nhập nhà xuất bản" />
            </div>

            <!-- Bộ lọc theo publication_date -->
            <div class="col-md-3">
                <h6>Năm xuất bản:</h6>
                <input type="number" class="bg-input fbg-input orm-control-sm form-control border-0 border-bottom rounded-0 shadow-none search-input" 
                       name="year_publication" min="1000" max="9999" placeholder="Nhập năm" />
            </div>

        </div>
    </div>
</div>
</div>
<!-- Lọc nâng cao sẽ hiển thị vào đây -->
<div id="advanced-filtering" class="container-fluid bg-light" style="display: none;">
    <div class="container">
        <div class="row">
            <!-- Bộ lọc theo book_code -->
            <div class="col-md-3">
                <h6>Mã sách:</h6>
                <input type="text" class="form-control" name="book_code" placeholder="Nhập mã sách" />
            </div>

            <!-- Bộ lọc theo author -->
            <div class="col-md-3">
                <h6>Tác giả:</h6>
                <input type="text" class="form-control" name="author" placeholder="Nhập tác giả" />
            </div>

            <!-- Bộ lọc theo publisher -->
            <div class="col-md-3">
                <h6>Nxb:</h6>
                <input type="text" class="form-control" name="publisher" placeholder="Nhập nhà xuất bản" />
            </div>

            <!-- Bộ lọc theo publication_date -->
            <div class="col-md-3">
                <h6>Ngày xuất bản:</h6>
                <input type="number" class="form-control" name="year_publication" />
            </div>
        </div>
    </div>
</div>


<div class="container-fluid py-3">
    <h3 class="mb-0">
        <i class="bi bi-pencil-square me-2"></i>BOOKS
    </h3>
    <p class="p-2 h6 text-danger">LIST VIEW</p>
</div>

<div class="container-fluid bg-light py-3 listView" id="book-list-view">
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-light me-2 border" id="list-view-btn" onclick="setLayout('list')" data-bs-toggle="tooltip" data-bs-placement="top" title="List view">
            <i class="bi bi-list"></i>
        </button>
        <button class="btn btn-light border" id="card-view-btn" onclick="setLayout('card')" data-bs-toggle="tooltip" data-bs-placement="top" title="Card view">
            <i class="bi bi-grid-3x3"></i>
        </button>
    </div>

    <!-- Kiểm tra danh sách sách -->
    @if($books->isEmpty())
        <div class="alert alert-warning text-center">
            Hiện tại chưa có sách nào trong danh sách.
        </div>
    @else
        <!-- List View -->
        <div class="list-view-content">
            <table class="table table-bordered table-striped" id="book-list-table">
                <thead class="table-dark text-center">
                    <tr>
                        <th>STT</th>
                        <th>Mã sách</th>
                        <th>Hình ảnh</th>
                        <th>Tên sách</th>
                        <th>Giá</th>
                        <th>Tác giả</th>
                        <th>NXB</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $index => $book)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">{{ $book->book_code }}</td>
                        <td class="text-center">
                            @if($book->images)
                                <img src="{{ asset('storage/'.$book->images) }}" alt="Ảnh sách" width="auto" height="60" class="rounded">
                            @else
                                <img src="{{ asset('storage/images/books/default.png') }}" alt="Ảnh mặc định" width="auto" height="60" class="rounded">
                            @endif
                        </td>
                        <td>{{ $book->title }}</td>
                        <td class="text-danger">{{ $book->price }} đ</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->publisher ?? 'Không xác định' }}</td>
                        <td class="text-center">
                            <a href="{{ route('books.admin.detailView', ['id' => $book->id]) }}" class="btn btn-sm btn-danger">View</a>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Card View (ẩn mặc định) -->
            <div class="card-view-content" style="display:none;">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
                    @foreach($books as $book)
                    <div class="col">
                        <div class="card h-100">
                        <div class="card-img-container">
                            <img  style="height: 200px" src="{{ asset('storage/'.$book->images ?? 'images/books/default.png') }}" class="card-cimg" alt="Ảnh sách">
                        </div>
                            <div class="card-body mb-5">
                                <!-- Tiêu đề sách -->
                                <h6 class="card-title">{{ $book->title }}</h6>
                                <p class="card-text">{{ $book->author }}</p>
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <span class="text-danger">{{ $book->price }} đ</span>
                                <a href="{{ route('books.admin.detailView', ['id' => $book->id]) }}" class="btn btn-sm btn-danger">View</a>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    @endif
</div>
<div class="d-flex justify-content-center mt-3">
    <ul class="pagination">
        <!-- Nút Previous -->
        @if($books->currentPage() > 1)
            <li class="page-item">
                <a class="page-link" href="{{ $books->previousPageUrl() }}">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>
        @endif

        <!-- Số trang -->
        @for($i = 1; $i <= $books->lastPage(); $i++)
            <li class="page-item {{ $i == $books->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $books->url($i) }}">
                    {{ $i }} <!-- Hiển thị số trang ở đây -->
                </a>
            </li>
        @endfor

        <!-- Nút Next -->
        @if($books->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $books->nextPageUrl() }}">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        @endif
    </ul>
</div>



</div>

<script>
    
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

document.addEventListener("DOMContentLoaded", function () {
    // Toggle phần lọc nâng cao
    const toggleAdvancedFilterButton = document.getElementById('toggle-advanced-filter');
    const advancedFilteringDiv = document.getElementById('advanced-filtering');
    const advancedFilterIcon = toggleAdvancedFilterButton.querySelector('i');  // Lấy icon của nút bộ lọc nâng cao

    toggleAdvancedFilterButton.addEventListener('click', function () {
        // Kiểm tra trạng thái hiện tại của phần lọc nâng cao
        if (advancedFilteringDiv.classList.contains('show')) {
            // Ẩn bộ lọc nâng cao
            advancedFilteringDiv.classList.remove('show');
            advancedFilterIcon.classList.replace('fa-chevron-up', 'fa-chevron-down');
        } else {
            // Hiện bộ lọc nâng cao
            advancedFilteringDiv.classList.add('show');
            advancedFilterIcon.classList.replace('fa-chevron-down', 'fa-chevron-up');
        }
    });
});
function setLayout(layout) {
    // Lưu trạng thái vào localStorage
    localStorage.setItem('layout', layout);

    // Xử lý cho List view
    if (layout === 'list') {
        document.getElementById('book-list-view').classList.add('listView');
        document.getElementById('book-list-view').classList.remove('cardView');
        document.querySelector('.list-view-content').style.display = 'block';
        document.querySelector('.card-view-content').style.display = 'none';
        
        // Thêm viền cho icon List view
        document.getElementById('list-view-btn').classList.add('border-selected');
        document.getElementById('card-view-btn').classList.remove('border-selected');
    }

    // Xử lý cho Card view
    if (layout === 'card') {
        document.getElementById('book-list-view').classList.remove('listView');
        document.getElementById('book-list-view').classList.add('cardView');
        document.querySelector('.list-view-content').style.display = 'none';
        document.querySelector('.card-view-content').style.display = 'block';
        
        // Thêm viền cho icon Card view
        document.getElementById('card-view-btn').classList.add('border-selected');
        document.getElementById('list-view-btn').classList.remove('border-selected');
    }
}
document.addEventListener('DOMContentLoaded', function () {
    // Kiểm tra xem trạng thái chế độ hiển thị đã được lưu trong localStorage chưa
    const savedLayout = localStorage.getItem('layout') || 'list'; // Mặc định là 'list'

    // Gọi hàm setLayout với giá trị trạng thái đã lưu
    setLayout(savedLayout);
});


</script>


@endsection
