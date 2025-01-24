<!-- resources/views/books/listView.blade.php -->
@extends('layouts.app') <!-- Kế thừa layout admin -->

@section('title', 'Books')

@section('content')

    <div class="d-flex container-fluid">

        @include('books.app.sidebar')

        <main class="flex-grow-1 p-4 ">
            <div id="content-admin" class=" ms-auto">
           <div class="container">
    <div class="card-view-content" style="display:block;">
        @foreach($categories as $category) <!-- $data thay cho $categories -->
            <!-- Hiển thị tên Category -->
            <div class="row mb-4">
                <div class="col-12 mb-3 mt-3"><a style="text-decoration: none" href="">Trang chủ / {{$category['name']}} </a></div>
                <div class="col-12">
                    <h4 class="">{{ $category['name'] }}</h4>
                </div>
            </div>

            <!-- Hiển thị danh sách sách trong Category -->
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4">
                @foreach($category['subCategories'] as $subCategory) <!-- Bỏ qua subCategory và lấy sách trực tiếp từ Category -->
                    @foreach($subCategory['books'] as $book)
                        <div class="col">
                            <div class="card h-100 rotating-border">
                                <div class="card-img-container card-cimg">
                                    <img style="height: 200px" src="{{ asset('storage/'.$book['images']) }}" class="card-img-top" alt="Ảnh sách">
                                </div>
                                <div class="card-body mb-5">
                                    <!-- Tiêu đề sách -->
                                    <h6 class="card-title">{{ $book['title'] }}</h6>
                                    <p class="card-text">{{ $book['author'] }}</p>
                                </div>
                                <div class="card-footer d-flex justify-content-between align-items-center">
                                    <span class="text-danger">{{ $book['price'] }} đ</span>
                                    <a href="{{ route('books.admin.detailView', ['id' => $book['id']]) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        @endforeach
    </div>
</div>
<div class="container">
    <!-- Tiêu đề -->
    <div class="text-type-2 mt-5 mb-5">
        <h2 class="text-center p-2" data-aos="fade-up">Danh sách sản phẩm</h2>
        <p class="text" data-aos="fade-up">
            Dù bạn yêu thích tiểu thuyết lãng mạn, khoa học viễn tưởng, hay những cuốn sách về phát triển bản thân, bạn đều có thể tìm thấy niềm đam mê và sự thỏa mãn trong từng trang sách. Hãy để sách là nguồn cảm hứng, mở rộng tầm nhìn và làm phong phú thêm cuộc sống của bạn.
        </p>
    </div>

    <div class="row">
        @foreach($simpleCategories as $category)
        <div class="col-md-4 mb-4">
            <!-- Thêm thẻ <a> bao quanh mỗi card category -->
            <a href="{{ url('app/books?category_id=' . $category['id']) }}" class="text-decoration-none text-black">
                <div class="type-list-card d-flex flex-column align-items-center border p-3 bg-white rounded" style="height: 180px;">
                    <div class="row w-100 h-100">
                        <!-- Tên Category -->
                        <div class="col-7 d-flex align-items-center justify-content-center">
                            <h5 class="text-center">{{ $category['name'] }}</h5>
                        </div>

                        <!-- Các hình ảnh chồng lên nhau -->
                        <div class="border col-5 d-flex align-items-center justify-content-center position-relative" style="height: 120px;">
                            <!-- Ảnh 1: Xoay lệch 20 độ (Kiểm tra nếu tồn tại ảnh 0) -->
                            @if(isset($category['images'][0]))
                                <img 
                                src="{{ asset('storage/' . $category['images'][0]) }}"  
                                    alt="Hình ảnh 1" 
                                    class="img-fluid rounded image-rotate-left"
                                    style="position: absolute; top: 0; left: 50%; transform: translateX(-50%) rotate(-20deg); z-index: 1; height: 120px; object-fit: cover;">
                            @endif
                            
                            <!-- Ảnh 2: Mặt định (Kiểm tra nếu tồn tại ảnh 1) -->
                            @if(isset($category['images'][1]))
                                <img 
                                src="{{ asset('storage/' . $category['images'][1]) }}" 
                                    alt="Hình ảnh 2" 
                                    class="img-fluid rounded"
                                    style="position: absolute; top: 0; left: 50%; transform: translateX(-50%); z-index: 2; height: 120px; object-fit: cover;">
                            @endif
                            
                            <!-- Ảnh 3: Xoay lệch 20 độ (Kiểm tra nếu tồn tại ảnh 2) -->
                        @if(isset($category['images'][2]))
                            <img 
                                src="{{ asset('storage/' . $category['images'][2]) }}" 
                                alt="Hình ảnh 3" 
                                class="img-fluid rounded image-rotate-right"
                                style="position: absolute; top: 0; left: 50%; transform: translateX(-50%) rotate(20deg); z-index: 3; height: 120px; object-fit: cover;">
                        @endif

                        </div>

                        <!-- Subcategories -->
                        <div class="col-12 d-flex align-items-center justify-content-center subcategory-text">
                            <marquee direction="left" scrollamount="5" scrolldelay="100">
                                <p class="text-danger" style="font-size: 14px;">{{ $category['subCategories'] }}</p>
                            </marquee>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

</div>

            </div>
        </main>
    </div>


@endsection
