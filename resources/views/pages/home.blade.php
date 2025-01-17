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
    @foreach($categories as $category)
        <div class="category">
            <p><a class="url text-muted" href="{{ route('home') }}">Trang chủ </a>/</p>
            <h2 class="fs-4 fw-bold mt-1 mb-5">{{ $category['name'] }}</h2>

            @foreach($category['sub_categories'] as $subCategory)
                <div class="sub-category">
                    <h3 class="fs-5 fw-bold">{{ $subCategory['name'] }}</h3>

                    <!-- Hiển thị sách theo hàng ngang, mỗi hàng tối đa 5 ảnh -->
                    <div class="d-flex book-container">
                        <div class="books mb-5 mt-1" >
                            @foreach($subCategory['books'] as $book)
                                <div class="card cardx">
                                 <img style="" src="{{ asset('storage/'.$book['images']) }}" class="card-img-top img-fluid" alt="{{ $book['title'] }}">

                                    <div class="card-body">
                                        <h6 class="card-title">{{ $book['title'] }}</h6>
                                        <p class="">{{ $book['price'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @endforeach
</div>

<div class="container">
    <!-- Nội dung với hiệu ứng AOS -->
    <h2 class="text-center text-type-2 m-5" data-aos="fade-up">Sản phẩm & Dịch vụ của chúng tôi</h2>
    <p data-aos="fade-up" data-aos-delay="300">
        Ấn tượng, khác biệt và chuyên nghiệp là những đặc điểm ưu việt khi thiết kế website. Mỗi sản phẩm chúng tôi tạo ra cho khách hàng là cả một công trình nghệ thuật.
    </p>
    <div class="row">
        <div class="col-md-3 mb-4 d-flex">
            <div style="background-color: #74a2a7;" class="text-black d-flex flex-column justify-content-center align-items-center square w-100" data-aos="fade-up" data-aos-delay="500">
                <i class="fas fa-book-open fa-3x m-3 mb-0"></i>
                <h5 class="text-center">Books</h5>
                <p class="text-center">Khám phá kho sách phong phú với nhiều thể loại hấp dẫn. Mua sắm dễ dàng và nhận sách ngay tại nhà chỉ với vài thao tác đơn giản.</p>
            </div>
        </div>
        
        <div class="col-md-3 mb-4 d-flex">
            <div style="background-color: #c36161;" class="text-black d-flex flex-column justify-content-center align-items-center square w-100" data-aos="fade-up" data-aos-delay="600">
                <i class="fas fa-paint-brush fa-3x m-3 mb-1"></i>
                <h5 class="text-center">Graphic Design</h5>
                <p class="text-center">Chúng tôi có khả năng thiết kế đẹp và tiện lợi mẫu trên cả trang web và di động.</p>
            </div>
        </div>

        <div class="col-md-3 mb-4 d-flex">
            <div style="background-color: #ffc107;" class="text-black d-flex flex-column justify-content-center align-items-center square w-100" data-aos="fade-up" data-aos-delay="700">
                <i class="fas fa-laptop-code fa-3x m-3 mb-1"></i>
                <h5 class="text-center">Website</h5>
                <p class="text-center">
                    Ấn tượng, khác biệt và chuyên nghiệp khi thiết kế website, mỗi sản phẩm tạo ra cho khách hàng là cả một công trình nghệ thuật.
                </p>
            </div>
        </div>
        
        <div class="col-md-3 mb-4 d-flex">
            <div style="background-color: #73ecff;" class="text-black d-flex flex-column justify-content-center align-items-center square w-100" data-aos="fade-up" data-aos-delay="800">
                <i class="fas fa-bullhorn fa-3x m-3 mb-1"></i>
                <h5 class="text-center">Marketing</h5>
                <p class="text-center">Chiến lược marketing sáng tạo để giúp thương hiệu của bạn nổi bật và tiếp cận khách hàng tiềm năng hiệu quả.</p>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript để điều khiển hiệu ứng -->

@endsection
