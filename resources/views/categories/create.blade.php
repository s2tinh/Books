@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="mb-0">
        <i class="bi bi-pencil-square me-2"></i>CATEGORIES
    </h3>
    <p class="p-2 h6 text-danger">CREATE</p>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-3 mb-3">
        <button class="btn btn-danger btn-sm rectangle-btn me-2" style="padding-top: 2px; padding-bottom: 2px;">Save</button>
        <button class="btn btn-danger btn-sm rectangle-btn" style="padding-top: 2px; padding-bottom: 2px;">Cancel</button>
    </div>
</div>

<div class="container">
    <div class="container custom-header d-flex align-items-center">
        <h6 class="mb-0">Categories</h6>
    </div>
<form action="{{ route('categories.store') }}" method="POST">
    <div class="container bg-white p-5 border">
        <!-- Form thêm category -->

            @csrf
            
            <!-- Mã danh mục, Tên danh mục, Mô tả (3 input trên 1 hàng) -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="code" class="form-label">Code</label>
                    <input type="text" class="form-control-sm form-control bg-white border-0 border-bottom rounded-0 shadow-none" id="code" name="code" value="{{ old('code') }}" required>
                    @error('code')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control-sm form-control bg-white border-0 border-bottom rounded-0 shadow-none" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control-sm form-control bg-white border-0 border-bottom rounded-0 shadow-none" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="container custom-header d-flex align-items-center">
            <h6 class="mb-0">Sub Categories</h6>
        </div>

        <div class="container bg-white p-5 border">
            <div id="sub-category-details" class="mt-3">
                <div id="sub-category-list">
                    <!-- Sub category form fields will be added here dynamically -->
                </div>
                <button type="button" id="add-sub-category" class="btn btn-danger btn-sm mt-2">Thêm danh mục con</button>
            </div>

            <!-- Nút Save và Cancel -->
            <div class="mt-3">
                <button type="submit" class="btn btn-danger btn-sm rectangle-btn me-2" style="padding-top: 2px; padding-bottom: 2px;">Save</button>
                <button type="button" class="btn btn-danger btn-sm rectangle-btn" style="padding-top: 2px; padding-bottom: 2px;" onclick="window.location.href='#'">Cancel</button>
            </div>
        </div>
    </div>
</div>
</form>

<script>
    // Thêm Sub Category
    document.getElementById('add-sub-category').addEventListener('click', function() {
        var subCategoryList = document.getElementById('sub-category-list');
        var newSubCategory = document.createElement('div');
        newSubCategory.innerHTML = `
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="sub_category_code" class="form-label">Code</label>
                    <input type="text" class="form-control-sm form-control bg-white border-0 border-bottom rounded-0 shadow-none" name="sub_category_code[]" required>
                </div>
                <div class="col-md-6">
                    <label for="sub_category_code" class="form-label">Name</label>
                    <input type="text" class="form-control-sm form-control bg-white border-0 border-bottom rounded-0 shadow-none" name="sub_category_code[]" required>
                </div>
            </div>
        `;
        subCategoryList.appendChild(newSubCategory);
    });
</script>

@endsection
