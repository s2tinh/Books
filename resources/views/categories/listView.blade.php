@extends('layouts.admin') <!-- Kế thừa layout admin -->

@section('title', 'Danh sách Danh mục')

@section('content')


<div id="headder-listview"class="container-fluid bg-light p-3">
    <div class="container">
        <div class="row align-items-center">
            <!-- Bên trái thanh tìm kiếm -->
            <div class="col-md-3 d-flex align-items-center">
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
            </div>
        </div>
    </div>
</div>
<div class="container-fluid py-3 mt-5">
    <h3 class="mb-0">
        <i class="bi bi-pencil-square me-2"></i>CATEGORIES
    </h3>
    <p class="p-2 h6 text-danger">LIST VIEW</p>
</div>

@foreach($categoryData as $categoryId => $category)
    <div class="category">
        <p>{{ $category['name'] }}</p>
        <p>{{ $category['description'] }}</p>
        <ul>
            @foreach($category['sub_categories'] as $subCategoryId => $subCategory)
                <li>
                    <strong>{{ $subCategory['name'] }}</strong> (Code: {{ $subCategory['code'] }})
                </li>
            @endforeach
        </ul>
    </div>
@endforeach 
@endsection
