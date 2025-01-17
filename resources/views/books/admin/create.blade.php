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
<form 
    method="POST" 
    action="{{ isset($book) ? route('books.admin.updateBook', ['id' => $book->id]) : route('books.admin.store') }}" 
    enctype="multipart/form-data">

    @csrf  <!-- CSRF token cho bảo mật -->
    @if(isset($book))
        @method('PUT')  <!-- Chỉ định phương thức PUT -->
        <input type="hidden" name="id" value="{{ $book->id }}">
    @endif


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
                    <label for="year_publication" class="form-label">Ngày xuất bản</label>
                    <input 
                        type="number" 
                        class="form-control-sm form-control bg-white border-0 border-bottom rounded-0 shadow-none" 
                        id="year_publication" 
                        name="year_publication" 
                        value="{{ isset($book) ? $book->year_publication : '' }}" 
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
                                {{ isset($book->subCategory) && $book->subCategory->category_id == $category->id ? 'selected' : '' }}>
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

            <div class="mb-3">
                <label for="images" class="form-label">Hình ảnh chính</label>
                <input type="file" class="form-control-sm form-control bg-white border-0 border-bottom rounded-0 shadow-none"
                       id="images" name="images" accept="image/*" onchange="handleMainImageChange(this)">

                <div id="main-image-preview" class="mt-3">
                </div>
            </div>

            <div class="mb-3" id="additional-images-container">
                <label for="extra-images-input" class="form-label">Ảnh Phụ</label>
                <input type="file" id="extra-images-input" name="extra_images[]" accept="image/*" multiple onchange="handleExtraImages()" class="form-control bg-white border-0 shadow-none">
                
                <div id="extra-images-list" class="d-flex flex-column gap-3">
                    @if(!empty($additionalImages))
                        @foreach($additionalImages as $index => $image)
                            <div class="extra-image-item">
                                <!-- Sử dụng cột image_path từ additionalImages -->
                               <img src="{{ asset('storage/' . $image->image_path) }}" alt="Hình ảnh phụ {{ $index + 1 }}" class="img-thumbnail" style="height: 80px; width: 80px;">
                                
                                <!-- Mô tả ảnh -->
                                <input type="text" name="extra_images_description[]" class="form-control rounded-0 shadow-none" 
                                       value="{{ $image->description ?? '' }}" 
                                       placeholder="Mô tả cho ảnh {{ $index + 1 }}">
                                
                                <!-- Nút xóa -->
                                <span class="remove-btn" onclick="removeExtraImage(this, '{{ $image->image_path }}')">&times;</span>
                            </div>
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
function removeExtraImage(removeBtn, imagePath) {
    const extraImagesList = document.getElementById('extra-images-list');

    // Tạo input hidden để lưu thông tin ảnh đã xóa
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'removed_extra_images[]';
    hiddenInput.value = imagePath; // Lưu thông tin ảnh đã xóa (ví dụ, imagePath)

    // Kiểm tra nếu container 'remove_extra_img' đã tồn tại
    let removeDiv = document.getElementById('remove_extra_img');
    
    // Nếu chưa có, tạo mới
    if (!removeDiv) {
        removeDiv = document.createElement('div');
        removeDiv.id = 'remove_extra_img'; // Chỉ tạo một container duy nhất
        extraImagesList.appendChild(removeDiv);
    }

    // Thêm input hidden vào container này
    removeDiv.appendChild(hiddenInput);

    // Xóa phần tử ảnh đã chọn
    removeBtn.parentElement.remove();
}


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
        // Kiểm tra nếu $book->subCategory->id tồn tại để thiết lập giá trị mặc định
        @if(isset($book->subCategory) && $book->subCategory->id)
            var selectedSubCategory = @json($book->subCategory->id); 
            var categoryId = $('#category_id').val(); // Lấy giá trị category_id đã chọn

            if (categoryId) {
                $.ajax({
                    url: "{{ route('get.sub.categories', '') }}/" + categoryId,
                    type: 'GET',
                    success: function (response) {
                        var subCategoryDropdown = '<select class="form-select form-select-sm" id="sub_category_id" name="sub_category_id" required>';
                        subCategoryDropdown += '<option value="" disabled selected>Chọn danh mục con</option>';

                        // Duyệt qua tất cả sub-categories và tạo option cho dropdown
                        $.each(response, function (index, subCategory) {
                            // Nếu subCategory.id trùng với selectedSubCategory thì chọn nó
                            subCategoryDropdown += '<option value="' + subCategory.id + '" ' + (subCategory.id == selectedSubCategory ? 'selected' : '') + '>' + subCategory.name + '</option>';
                        });

                        subCategoryDropdown += '</select>';

                        // Thêm dropdown mới vào div #sub_categories
                        $('#sub_categories').html(subCategoryDropdown);
                    },
                    error: function () {
                        alert('Lỗi khi lấy danh mục con!');
                    }
                });
            }
        @endif

        // Lắng nghe sự kiện khi thay đổi danh mục chính (category_id)
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
<script>
window.onload = function () {
    function handleMainImageChange(input) {
        const mainImagePreview = document.getElementById('main-image-preview');
        const additionalImagesContainer = document.getElementById('additional-images-container');

        // Xóa nội dung hiện tại
        mainImagePreview.innerHTML = '';

        if (input.files.length > 0) {
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function (e) {
                // Tạo container chứa ảnh
                const imgContainer = document.createElement('div');
                imgContainer.className = 'position-relative d-inline-block';

                // Tạo DOM hiển thị ảnh
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Hình ảnh chính';
                img.style.height = '200px';
                img.className = 'rounded';

                // Tạo chữ X để xóa ảnh chính
                const removeText = document.createElement('span');
                removeText.textContent = '×'; // Ký tự 'X' (không phải button)
                removeText.className = 'remove-btn'; // Sử dụng lớp CSS đã định nghĩa cho chữ X

                removeText.onclick = function () {
                    input.value = ''; // Reset input
                    mainImagePreview.innerHTML = ''; // Xóa preview
                    additionalImagesContainer.style.display = 'none'; // Ẩn ảnh phụ
                };

                // Thêm ảnh và chữ X vào container
                imgContainer.appendChild(img);
                imgContainer.appendChild(removeText);

                // Hiển thị container
                mainImagePreview.appendChild(imgContainer);

                // Hiển thị phần ảnh phụ
                additionalImagesContainer.style.display = 'block';
            };

            reader.readAsDataURL(file);
        }
    }

    // Nếu đã có ảnh chính (khi đang chỉnh sửa), gắn ảnh vào preview
    const mainImagePreview = document.getElementById('main-image-preview');
    const additionalImagesContainer = document.getElementById('additional-images-container');

    // Kiểm tra nếu ảnh chính đã tồn tại
    if ({{ isset($mainImagePath) && $mainImagePath != false ? 'true' : 'false' }}) {
        // Nếu đã có ảnh chính thì không tạo lại ảnh chính
        const imgContainer = document.createElement('div');
        imgContainer.className = 'position-relative d-inline-block';

        const img = document.createElement('img');
        img.src = "{{ asset('storage/' . $mainImagePath) }}";  // Đường dẫn đến ảnh chính
        img.alt = 'Hình ảnh chính';
        img.style.height = '200px';
        img.className = 'rounded';

        const removeText = document.createElement('span');
        removeText.textContent = '×';
        removeText.className = 'remove-btn';

        removeText.onclick = function () {
            document.getElementById('images').value = ''; // Reset input
            mainImagePreview.innerHTML = ''; // Xóa ảnh chính

        };

        imgContainer.appendChild(img);
        imgContainer.appendChild(removeText);
        mainImagePreview.appendChild(imgContainer);

        // Đảm bảo không hiển thị ảnh phụ nếu không có ảnh chính
    }

function handleExtraImages() {
    const input = document.getElementById('extra-images-input');
    const fileList = input.files;
    const extraImagesList = document.getElementById('extra-images-list');

    Array.from(fileList).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function (e) {
            // Create the container
            const container = document.createElement('div');
            container.classList.add('extra-image-item');

            // Create the image
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = `Hình ảnh phụ ${index + 1}`;

            // Create the description input
            const descriptionInput = document.createElement('input');
            descriptionInput.type = 'text';
            descriptionInput.placeholder = `Mô tả cho ảnh ${index + 1}`;
            descriptionInput.name = `extra_images_description[]`;
            descriptionInput.classList.add('form-control', 'rounded-0', 'shadow-none');

            // Create the remove button
            const removeBtn = document.createElement('span');
            removeBtn.classList.add('remove-btn');
            removeBtn.innerHTML = '&times;';

            removeBtn.onclick = function () {
                container.remove();
            };

            // Append elements to the container
            container.appendChild(img);
            container.appendChild(descriptionInput);
            container.appendChild(removeBtn);

            // Add the container to the list
            extraImagesList.appendChild(container);
        };

        reader.readAsDataURL(file);
    });
}

    // Đặt các hàm này vào global scope để dùng trong HTML
    window.handleMainImageChange = handleMainImageChange;
    window.handleExtraImages = handleExtraImages;
};


</script>
@endsection