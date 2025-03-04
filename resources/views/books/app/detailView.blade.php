@extends('layouts.app') <!-- Kế thừa layout chung -->

@section('content')

<div class="container">
    <div class="row mb-4">
        <div class="col-12 mb-0 mt-2">
            <a style="text-decoration: none" href="">Trang chủ / Xem chi tiết </a>
        </div>
        <div class="col-md-12">  <p class="book-title h3 pt-2">{{ $book->title }}</p> <!-- Di chuyển Tên sách lên đây --></div>
    </div>
</div>

<div class="container bg-white shadow-sm">  

    <!-- Tên sách (Đã di chuyển sang vị trí bên trái, cột bên trái của layout) -->
    <div class="row">
        <div class="col-md-2 col-4" style="max-height: 420px; overflow-y: auto;">
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

        <!-- Cột bên phải: Tên sách, Ảnh được chọn và Sticky Div -->
        <div class="col-md-6 col-8 text-center">
            <div class="card">
                <div class="card-body">
                  
                    <img id="selectedImage" src="{{ asset('/storage/'.$book->images) }}" alt="Ảnh được chọn" class="img-fluid" style="height: 400px !important; width: auto;">
                </div>
            </div>
        </div>

        <!-- Phần sticky-div (Giá, Số lượng và nút Mua) -->
        <div class="col-md-4 col-12 sticky-div">
            <form action="{{ route('books.app.checkout_cart') }}" method="POST">
            <!-- Phần chọn số lượng và hiển thị "Còn hàng" -->
            <div class="product-quantity">
                <div class="quantity-control">
                    <button class="quantity-btn" id="decreaseBtn">-</button>
                    <input type="number" id="quantity" name ="quantity"class="quantity-input" value="1" min="1">
                    <button class="quantity-btn" id="increaseBtn">+</button>
                </div>
                <div class="stock-status">
                    Còn hàng
                </div>
            </div>

            <!-- Giá sách -->
            <div class="price">
                <p class="h6 text-danger">{{ number_format($book->price, 0) }} Đ</p>
            </div>

            <!-- Nút Mua Hàng -->
    <!-- Nút Mua Hàng -->

                @csrf <!-- CSRF Token để bảo mật POST request -->
                <input type="hidden" name="id" value="{{ $book->id }}">
                <button type="submit" class="buy-btn">
                    <i class="fas fa-shopping-cart"></i> Đặt hàng
                </button>
            </form>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="ty-tabs__list row" >
        <li id="description" class="col-sm-3 ty-tabs__item cm-js active"><a class="ty-tabs__a" href="#">Mô tả sản phẩm</a></li>
        <li id="features" class="col-sm-3 ty-tabs__item cm-js"><a class="ty-tabs__a" href="#">Thông tin chi tiết</a></li>
        <li id="discussion" class="col-sm-3 ty-tabs__item cm-js"><a class="ty-tabs__a" href="#">Đánh giá </a></li>
    </ul>

    <!-- Nội dung các tab -->
    <div class="tab-content">
        <!-- Tab Mô tả sản phẩm -->
        <div id="description-content" class="tab-pane active">
            <div class="mb-3">
                <label class="form-label text-weight-1">Mô tả</label>
                <p class="border-0 bg-light">{{ $book->description }}</p>
            </div>
        </div>

        <!-- Tab Thông tin chi tiết -->
        <div id="features-content" class="tab-pane">
            <div class="row mb-3 pt-5">
                <div class="col-md-4">
                    <label class="form-label text-weight-1">Mã sách</label>
                    <p class="border-0 bg-light">{{ $book->book_code }}</p>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-weight-1">Tác giả</label>
                    <p class="border-0 bg-light">{{ $book->author }}</p>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-weight-1">Nhà xuất bản</label>
                    <p class="border-0 bg-light">{{ $book->publisher }}</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label text-weight-1">Ngày xuất bản</label>
                    <p class="border-0 bg-light">{{ $book->year_publication }}</p>
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
        </div>

        <!-- Tab Đánh giá của khách hàng -->
        <div id="discussion-content" class="tab-pane">
            <p>Chưa có đánh giá</p>
        </div>
    </div>

<!-- Có thể bạn cũng thích -->
<div class="row mt-5">
    <div class="col-12">
        @if(count($relatedBooksSubCategory) > 0) <!-- Kiểm tra nếu mảng có dữ liệu -->
            <h4>Có thể bạn cũng thích</h4>
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4">
                @foreach ($relatedBooksSubCategory as $relatedBook)
                    <div class="col">
                        <div class="card h-100 rotating-border">
                            <div class="card-img-container card-cimg">
                                <img style="height: 200px" src="{{ asset('storage/'.$relatedBook['images']) }}" class="card-img-top" alt="Ảnh sách">
                            </div>
                            <div class="card-body mb-5">
                                <h6 class="card-title">{{ $relatedBook['title'] }}</h6>
                                <p class="card-text">{{ $relatedBook['author'] }}</p>
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <span class="text-danger">{{ $relatedBook['price'] }} đ</span>
                                <a href="{{ route('books.app.detailView', ['id' => $relatedBook['id']]) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

  <div class="row mt-5">
    <div class="col-12">
        @if(count($relatedBooksCategory) > 0) <!-- Kiểm tra nếu mảng có dữ liệu -->
            <h4>Khám phá thêm</h4>
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4">
                @foreach ($relatedBooksCategory as $relatedBook)
                    <div class="col">
                        <div class="card h-100 rotating-border">
                            <div class="card-img-container card-cimg">
                                <img style="height: 200px" src="{{ asset('storage/'.$relatedBook['images']) }}" class="card-img-top" alt="Ảnh sách">
                            </div>
                            <div class="card-body mb-5">
                                <h6 class="card-title">{{ $relatedBook['title'] }}</h6>
                                <p class="card-text">{{ $relatedBook['author'] }}</p>
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <span class="text-danger">{{ $relatedBook['price'] }} đ</span>
                                <a href="{{ route('books.app.detailView', ['id' => $relatedBook['id']]) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

</div>




<!-- JavaScript -->
<script>
    function updateMainImage(imageUrl) {
        // Cập nhật src của ảnh bên phải (selectedImage)
        document.getElementById('selectedImage').src = imageUrl;
    }

    // JavaScript để xử lý tăng giảm số lượng
    const decreaseBtn = document.getElementById('decreaseBtn');
    const increaseBtn = document.getElementById('increaseBtn');
    const quantityInput = document.getElementById('quantity');

    decreaseBtn.addEventListener('click', () => {
        let currentQuantity = parseInt(quantityInput.value);
        if (currentQuantity > 1) {
            quantityInput.value = currentQuantity - 1;
        }
    });

    increaseBtn.addEventListener('click', () => {
        let currentQuantity = parseInt(quantityInput.value);
        quantityInput.value = currentQuantity + 1;
    });

    // JavaScript để chuyển đổi giữa các tab
    document.querySelectorAll('.ty-tabs__a').forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.ty-tabs__item').forEach(item => {
                item.classList.remove('active');
            });
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.remove('active');
            });

            tab.closest('li').classList.add('active');
            const target = document.getElementById(tab.closest('li').id + '-content');
            target.classList.add('active');
        });
    });
</script>

@endsection