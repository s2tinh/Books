@php
    use Illuminate\Pagination\LengthAwarePaginator;
@endphp

@extends('layouts.app')

@section('content')
@include('books.app.sidebar')
<div class="container" id='content-admin'>

    @php
        // Gom tất cả sách từ tất cả danh mục
        $allBooks = collect([]);
        foreach($categories as $category) {
            foreach($category['subCategories'] as $subCategory) {
                $allBooks = $allBooks->merge($subCategory['books']);
            }
        }

        // Kiểm tra từ khóa tìm kiếm
        $searchQuery = request()->get('search');
        if ($searchQuery) {
            $allBooks = $allBooks->filter(function ($book) use ($searchQuery) {
                return stripos($book['title'], $searchQuery) !== false || stripos($book['author'], $searchQuery) !== false;
            });
        }

        // Phân trang chỉ một lần (10 sách mỗi trang)
        $currentPage = request()->get('page', 1);
        $perPage = 10;
        $pagedBooks = new LengthAwarePaginator(
            $allBooks->forPage($currentPage, $perPage),
            $allBooks->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );
    @endphp


        <div class="row mb-4">
            <div class="col-12 mb-0 mt-2">
                <a style="text-decoration: none" href="">Trang chủ / Sách </a>
            </div>

        </div>


    @if($pagedBooks->count())
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4">
            @foreach($pagedBooks as $book)
                <div class="col">
                    <div class="card h-100 rotating-border">
                        <div class="card-img-container card-cimg">
                            <img style="height: 200px" src="{{ asset('storage/'.$book['images']) }}" class="card-img-top" alt="Ảnh sách">
                        </div>
                        <div class="card-body mb-5">
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

        <!-- Phân trang chỉ xuất hiện một lần -->
        <div class="d-flex justify-content-center mt-3">
            <ul class="pagination">
                @if($pagedBooks->currentPage() > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $pagedBooks->previousPageUrl() . '&search=' . request()->get('search') }}">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>
                @endif

                @for($i = 1; $i <= $pagedBooks->lastPage(); $i++)
                    <li class="page-item {{ $i == $pagedBooks->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $pagedBooks->url($i) . '&search=' . request()->get('search') }}">
                            {{ $i }}
                        </a>
                    </li>
                @endfor

                @if($pagedBooks->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $pagedBooks->nextPageUrl() . '&search=' . request()->get('search') }}">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    @endif
</div>
@endsection
