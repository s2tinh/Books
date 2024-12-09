@extends('layouts.admin') <!-- Kế thừa layout chung -->
@section('content')

<div class="container">
    <h3 class="mb-0">
        <i class="bi bi-pencil-square me-2"></i>BOOKS
    </h3>
    <p class="p-2 h6 text-danger">
        @if(Route::currentRouteName() === 'books.editView')
            EDIT
        @else
            CREATE
        @endif
    </p>

    <div class="mt-3 mb-3">
        <button class="btn btn-danger btn-sm rectangle-btn me-2" style="padding-top: 2px; padding-bottom: 2px;">Save</button>
        <button class="btn btn-danger btn-sm rectangle-btn" style="padding-top: 2px; padding-bottom: 2px;">Cancel</button>
    </div>
</div>

<div class="container">

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

<!-- Hiển thị thông báo thành công hoặc lỗi nếu có -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    <div class="container custom-header d-flex align-items-center">
        <h6 class="mb-0">Basic</h6>
    </div>
    <div class="container bg-white p-5 border">
        <!-- Form thêm sách -->
        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Mã sách, Tiêu đề sách, Tác giả (3 input trên 1 hàng) -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="book_code" class="form-label">Mã sách</label>
                    <input 
                        type="text" 
                        class="form-control-sm form-control bg-white border-0 border-bottom rounded-0 shadow-none" 
                        id="book_code" 
                        name="book_code" 
                        value="{{ isset($book) ? $book->book_code : '' }}" 
                        required>
                    <small id="book-code-feedback" class="form-text"></small> <!-- Thông báo -->
                </div>


                <div class="col-md-4">
                    <label for="title" class="form-label">Tên sách</label>
                    <input 
                        type="text" 
                        class="form-control-sm form-control bg-white border-0 border-bottom rounded-0 shadow-none" 
                        id="title" 
                        name="title" 
                        value="{{ isset($book) ? $book->title : '' }}" 
                        required>
                </div>
                <div class="col-md-4">
                    <label for="author" class="form-label">Tác giả</label>
                    <input 
                        type="text" 
                        class="form-control-sm form-control bg-white border-0 border-bottom rounded-0 shadow-none" 
                        id="author" 
                        name="author" 
                        value="{{ isset($book) ? $book->author : '' }}" 
                        required>
                </div>

            </div>


            <!-- Giá, Nhà xuất bản, Ngày xuất bản (3 input trên 1 hàng) -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="price" class="form-label">Giá</label>
                    <input 
                        type="number" 
                        class="form-control-sm form-control bg-white border-0 border-bottom rounded-0 shadow-none search-input" 
                        id="price" 
                        name="price" 
                        step="0.01" 
                        value="{{ isset($book) ? $book->price : '' }}" 
                        required>
                </div>
                <div class="col-md-4">
                    <label for="publisher" class="form-label">Nhà xuất bản</label>
                    <input 
                        type="text" 
                        class="form-control-sm form-control bg-white border-0 border-bottom rounded-0 shadow-none" 
                        id="publisher" 
                        name="publisher" 
                        value="{{ isset($book) ? $book->publisher : '' }}">
                </div>
                <div class="col-md-4">
                    <label for="publication_date" class="form-label">Ngày xuất bản</label>
                    <input 
                        type="date" 
                        class="form-control-sm form-control bg-white border-0 border-bottom rounded-0 shadow-none" 
                        id="publication_date" 
                        name="publication_date" 
                        value="{{ isset($book) ? $book->publication_date : '' }}" 
                        required>
                </div>
            </div>


            <!-- Thể loại, Loại bìa, Khổ sách (3 input trên 1 hàng) -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="category_id">Chọn danh mục</label>
                    <select class="form-select form-select-sm" id="category_id" name="category_id" required>
                        <option value="" disabled selected>Chọn danh mục</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ isset($book) && $book->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="cover_type" class="form-label">Loại bìa</label>
                    <input 
                        type="text" 
                        class="form-control-sm form-control bg-white border-0 border-bottom rounded-0 shadow-none" 
                        id="cover_type" 
                        name="cover_type" 
                        value="{{ isset($book) ? $book->cover_type : '' }}">
                </div>

                <div class="col-md-4">
                    <label for="book_size" class="form-label">Khổ sách</label>
                    <input 
                        type="text" 
                        class="form-control-sm form-control bg-white border-0 border-bottom rounded-0 shadow-none" 
                        id="book_size" 
                        name="book_size" 
                        value="{{ isset($book) ? $book->book_size : '' }}">
                </div>
            </div>

            <div class="row mb-3 mt-4 mb-4">
                <!-- Cột Danh mục con -->
                <div id="sub_categories" class="col-md-4"></div>

                <!-- Cột Ngôn ngữ -->
                <div class="col-md-4">
                    <select class="form-select form-select-sm bg-white border-0 border-bottom rounded-0 shadow-none" 
                            id="language" name="language">
                        <option value="" selected disabled>Chọn ngôn ngữ</option>
                        @foreach(config('dropdowns.dropdowns.languages') as $key => $value)
                            <option value="{{ $key }}" 
                                {{ isset($book) && $book->language == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Cột Độ tuổi -->
                <div class="col-md-4">
                    <select class="form-select form-select-sm bg-white border-0 border-bottom rounded-0 shadow-none" 
                            id="age_group" name="age_group">
                        <option value="" selected disabled>Chọn độ tuổi</option>
                        @foreach(config('dropdowns.dropdowns.age_groups') as $key => $value)
                            <option value="{{ $key }}" 
                                {{ isset($book) && $book->age_group == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Hình ảnh chính -->
            <div class="mb-3">
                <label for="images" class="form-label">Hình ảnh chính</label>
                <input type="file" class="form-control-sm form-control bg-white border-0 border-bottom rounded-0 shadow-none"
                       id="images" name="images" accept="image/*" onchange="handleMainImageChange(this)">
                <div id="main-image-preview" class="mt-3">
                    @if(isset($book->images)) <!-- Kiểm tra nếu có ảnh hiện tại -->
                        <img src="{{ asset('storage/' . $book->images) }}" alt="Main Image" class="img-fluid" style="height: 200px;">
                    @endif
                </div>
            </div>

            <!-- Hình ảnh phụ -->
            <div class="mb-3" id="additional-images-container" style="display: none;">
                <input type="file" id="extra-images-input" name="extra_images[]" accept="image/*" multiple onchange="handleExtraImages()" class="form-control bg-white border-0 shadow-none mb-3">
                <div id="extra-images-list">
                    @if ($book->bookImages->isNotEmpty()) <!-- Kiểm tra xem có hình ảnh phụ không -->
                        @foreach ($book->bookImages as $image) <!-- Duyệt qua các hình ảnh -->
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Hình ảnh phụ" class="img-fluid" style="max-height: 100px; width: auto;">
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Mô tả -->
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control-sm form-control bg-white border-0 border-bottom rounded-0 shadow-none" 
                          id="description" name="description" rows="4" required>{{ old('description', $book->description ?? '') }}</textarea>
            </div>



            <!-- Nút Save và Cancel -->
            <div class="mt-3">
                <button type="submit" class="btn btn-danger btn-sm rectangle-btn me-2" style="padding-top: 2px; padding-bottom: 2px;">Save</button>
                <button type="button" class="btn btn-danger btn-sm rectangle-btn" style="padding-top: 2px; padding-bottom: 2px;" onclick="window.location.href='#'">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#book_code').on('input', function () {
            let bookCode = $(this).val();

            // Kiểm tra nếu mã sách không rỗng
            if (bookCode.trim() !== '') {
                $.ajax({
                    url: "{{ route('books.checkBookCode') }}", // Route kiểm tra
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}", // Token CSRF
                        book_code: bookCode
                    },
                    success: function (response) {
                        let feedback = $('#book-code-feedback');
                        if (response.status === 'exists') {
                            // Thông báo khi mã sách đã tồn tại
                            feedback.text(response.message).css('color', 'red'); // Hiện thông báo lỗi
                            $('#book_code').css('color', 'red'); // Đổi màu chữ thành đỏ
                        } else if (response.status === 'invalid') {
                            // Thông báo khi mã sách không hợp lệ
                            feedback.text(response.message).css('color', 'orange'); // Màu cam cho lỗi không hợp lệ
                            $('#book_code').css('color', 'orange'); // Đổi màu chữ thành cam
                        } else {
                            // Thông báo khi mã sách hợp lệ
                            feedback.text(response.message).css('color', 'green'); // Màu xanh cho hợp lệ
                            $('#book_code').css('color', 'green'); // Đổi màu chữ thành xanh
                        }
                    },
                    error: function () {
                        alert('Có lỗi xảy ra khi kiểm tra mã sách.');
                    }
                });
            } else {
                // Xóa thông báo khi input rỗng
                $('#book-code-feedback').text('');
                $('#book_code').css('color', ''); // Reset màu chữ về mặc định
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#category_id').on('change', function () {
            var categoryId = $(this).val(); // Lấy giá trị của category_id đã chọn

            if (categoryId) {
                $.ajax({
                    url: "{{ route('get.sub.categories', '') }}/" + categoryId,
                    type: 'GET',
                    success: function (response) {
                        var subCategoryDropdown = '<select class="form-select form-select-sm" id="sub_category_id" name="sub_category_id" required>';
                        subCategoryDropdown += '<option value="" disabled selected>Chọn danh mục con</option>';

                        // Duyệt qua tất cả sub-categories và tạo option cho dropdown
                        $.each(response, function (index, subCategory) {
                            subCategoryDropdown += '<option value="' + subCategory.id + '">' + subCategory.name + '</option>';
                        });

                        subCategoryDropdown += '</select>';

                        // Thêm dropdown mới vào div #sub_categories
                        $('#sub_categories').html(subCategoryDropdown);
                    },
                    error: function () {
                        alert('Lỗi khi lấy danh mục con!');
                    }
                });
            } else {
                // Xóa dropdown sub-category nếu không có category_id
                $('#sub_categories').html('');
            }
        });
    });



</script>


@endsection