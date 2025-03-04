@extends('layouts.app')

@section('title', 'Trang Chủ')

@section('content')

<!-- Carousel -->
<div class="container-fluid">
<div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <!-- Banner 1 -->
        <div class="carousel-item active banner" id="banner1">
            <img src="images/bn1.jpeg" class="d-block w-100" alt="Banner 1">
            <div class="position-absolute" style="top: 50px; left: 120px;">
                <img id="book1" src="images/book.png" alt="Book" style="width: 160px; height: auto;">
            </div>
            <div class="carousel-caption d-none d-md-block" style="position: absolute; top: 60%; left: 50%; transform: translateX(-50%); text-align: center; width: 80%; max-width: 900px;">
                <h1 class="text-white" id="heading1">
                    <span class="text-orange">READ</span> AND <span class="text-orange">DREAM</span>
                </h1>
                <p class="text-white pt-4" id="text1">
                    Discover the world of knowledge and transform your dreams into reality with inspiring books that spark creativity and imagination. Dive into a universe where every page opens new doors to possibilities, encouraging you to think beyond limits, explore the unknown, and fuel your passions.
                </p>
            </div>
        </div>

        <!-- Banner 2 -->
        <div class="carousel-item">
            <img src="images/bn2.jpg" class="d-block w-100" alt="Banner 2">
            <div class="position-absolute" style="top: 50px; left: 120px;">
                <img id="book2" src="images/book.png" alt="Book" style="width: 160px; height: auto; position: relative; transform: translateX(-200px); opacity: 0;">
            </div>
            <div class="carousel-caption d-none d-md-block" style="position: absolute; top: 60%; left: 50%; transform: translateX(-50%); text-align: center; width: 80%; max-width: 900px;">
                <h1 class="text-white" id="heading2" style="position: relative; transform: translateY(-200px); opacity: 0;">
                    <span class="text-orange">JUST</span> ANOTHER <span class="text-orange">CHAPTER</span>
                </h1>
                <p class="text-white pt-5" id="text2" style="position: relative; transform: translateY(200px); opacity: 0;">
                    Immerse yourself in stories that inspire, captivate, and empower. Each chapter takes you on a journey of discovery. Explore new worlds, discover hidden truths, and let each story resonate with your deepest thoughts and emotions. Every page turns into a step forward, unlocking new opportunities to learn, grow, and dream.
                </p>
            </div>
        </div>
    </div>
</div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
</div>
<hr>


<div class="container">
    <div class="card-view-content" style="display:block;">
        @foreach($categories as $category)
            <!-- Hiển thị tên Category -->
            <div class="row mb-4">
                <div class="col-12 type-param mb-3"><a class="h6" href="">Trang chủ /</a></div>
                <div class="col-12">
                    <h4 class="">{{ $category['name'] }}</h4>
                </div>
            </div>
            
            @foreach($category['subCategories'] as $subCategory)
                <!-- Hiển thị tên SubCategory -->
                <div class="row m-1 mb-4 mt-4">
                    <div class="col-sm-4 col-10 d-flex justify-content-between align-items-center category-container">
                        <h6 class="category-name">{{ $subCategory['name'] }}</h6>
                        <a href="" class="btn btn-sm view-more">Xem Thêm</a>
                    </div>
                </div>


                <!-- Hiển thị danh sách sách trong SubCategory -->
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4">
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
                                    <a href="{{ route('books.app.detailView', ['id' => $book['id']]) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
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
                                    src="storage/{{ $category['images'][0] }}" 
                                    alt="Hình ảnh 1" 
                                    class="img-fluid rounded image-rotate-left"
                                    style="position: absolute; top: 0; left: 50%; transform: translateX(-50%) rotate(-20deg); z-index: 1; height: 120px; object-fit: cover;">
                            @endif
                            
                            <!-- Ảnh 2: Mặt định (Kiểm tra nếu tồn tại ảnh 1) -->
                            @if(isset($category['images'][1]))
                                <img 
                                    src="storage/{{ $category['images'][1] }}" 
                                    alt="Hình ảnh 2" 
                                    class="img-fluid rounded"
                                    style="position: absolute; top: 0; left: 50%; transform: translateX(-50%); z-index: 2; height: 120px; object-fit: cover;">
                            @endif
                            
                            <!-- Ảnh 3: Xoay lệch 20 độ (Kiểm tra nếu tồn tại ảnh 2) -->
                            @if(isset($category['images'][2]))
                                <img 
                                    src="storage/{{ $category['images'][2] }}" 
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


@endsection
