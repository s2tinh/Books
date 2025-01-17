@extends('layouts.admin') <!-- Kế thừa layout chung -->

@section('content')

<div class="container-fluid py-3">

    <h3 class="mb-0">
        <i class="bi bi-pencil-square me-2"></i>BOOKS

    </h3>
    <p class="p-2 h6 text-danger">DETAIL</p>
</div>

<div class="container d-flex justify-content-start mb-3">
    <!-- Back Button -->
    <a style="padding-top: 2px; padding-bottom: 2px; padding-left: 16px ; padding-right: 16px; margin-right: 8px " href="{{ route('books.admin.listView') }}" class="btn btn-danger btn-sm rectangle-btn">
        Back
    </a>

    <!-- Edit Button -->
    <a style="padding-top: 2px; padding-bottom: 2px; padding-left: 16px; padding-right: 16px" href="{{ route('books.admin.editView', ['id' => $book->id]) }}" class="btn btn-danger btn-sm rectangle-btn">
        Edit
    </a>

</div>
<div class="container-fluid">
<div class="container bg-white border py-5 px-5 shadow-sm">  

    <div class="row">
        <div class="col-md-2" style="max-height: 420px; overflow-y: auto;">
            <!-- Hình ảnh chính -->
            <div class="card mb-3">
                <div class="card-body text-center">
                    <img id="mainImage" src="{{ asset('/storage/'.$book->images) }}" alt="Hình ảnh chính" class="img-fluid" style="height: 100px !important; width: auto;" onclick="updateMainImage('{{ asset('/storage/'.$book->images) }}')">
                </div>
            </div>

            <!-- Các hình ảnh phụ -->
            @if ($book->bookImages->isNotEmpty()) <!-- Kiểm tra xem có hình ảnh phụ không -->
                <div class="d-flex flex-column">
                    @foreach ($book->bookImages as $image) <!-- Duyệt qua các hình ảnh -->
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Hình ảnh phụ" class="img-fluid" style="height: 100px !important; width: auto;" onclick="updateMainImage('{{ asset('storage/' . $image->image_path) }}')">
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Cột bên phải: Ảnh được chọn -->
        <div class="col-md-10 text-center">
            <div class="card">
                <div class="card-body">
                    <img id="selectedImage" src="{{ asset('/storage/'.$book->images) }}" alt="Ảnh được chọn" class="img-fluid" style="height: 400px !important; width: auto;">
                </div>
            </div>
        </div>
    </div>
        <!-- Thông tin sách -->
        <div class="row mb-3 pt-5">
            <div class="col-md-4">
                <label class="form-label text-weight-1">Mã sách</label>
                <p class="border-0 bg-light">{{ $book->book_code }}</p>
            </div>
            <div class="col-md-4">
                <label class="form-label text-weight-1">Tên sách</label>
                <p class="border-0 bg-light">{{ $book->title }}</p>
            </div>
            <div class="col-md-4">
                <label class="form-label text-weight-1">Tác giả</label>
                <p class="border-0 bg-light">{{ $book->author }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label text-weight-1">Giá</label>
                <p class="border-0 bg-light">{{ number_format($book->price, 2) }} VND</p>
            </div>
            <div class="col-md-4">
                <label class="form-label text-weight-1">Nhà xuất bản</label>
                <p class="border-0 bg-light">{{ $book->publisher }}</p>
            </div>
            <div class="col-md-4">
                <label class="form-label text-weight-1">Ngày xuất bản</label>
                <p class="border-0 bg-light">{{ $book->year_publication}}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label text-weight-1">Danh mục</label>
                <p class="border-0 bg-light">{{ $book->category->name }}</p>
            </div>
            <div class="col-md-4">
                <label class="form-label text-weight-1">Loại bìa</label>
                <p class="border-0 bg-light">{{ $book->cover_type }}</p>
            </div>
            <div class="col-md-4">
                <label class="form-label text-weight-1">Khổ sách</label>
                <p class="border-0 bg-light">{{ $book->book_size }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label text-weight-1">Ngôn ngữ</label>
                <p class="border-0 bg-light">{{ config('dropdowns.dropdowns.languages')[$book->language] }}</p>
            </div>
            <div class="col-md-4">
                <label class="form-label text-weight-1">Độ tuổi</label>
                <p class="border-0 bg-light">{{ config('dropdowns.dropdowns.age_groups')[$book->age_group] }}</p>
            </div>
            <div class="col-md-4">
                <label class="form-label text-weight-1">Danh mục con</label>
                <p class="border-0 bg-light">{{ $book->subCategory->name ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label text-weight-1">Mô tả</label>
            <p class="border-0 bg-light">{{ $book->description }}</p>
        </div>
    
</div>
</div>
<!-- JavaScript -->
<script>
    function updateMainImage(imageUrl) {
        // Cập nhật src của ảnh bên phải (selectedImage)
        document.getElementById('selectedImage').src = imageUrl;
    }
</script>
@endsection
