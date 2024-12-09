<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory; // Import SubCategory model
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // Phương thức hiển thị form thêm thể loại
    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        // Validate dữ liệu
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'required|string|unique:categories,code|max:255', // Validation cho 'code'
            'sub_category_code' => 'nullable|array', // Mảng mã danh mục con
            'sub_category_code.*' => 'nullable|string|max:255', // Validate từng mã danh mục con
            'sub_category_name' => 'nullable|array', // Mảng tên danh mục con
            'sub_category_name.*' => 'nullable|string|max:255', // Validate từng tên danh mục con
        ]);

        // Lưu category
        $category = Category::create([
            'id' => Str::uuid(), // Tạo ID UUID tự động
            'name' => $validated['name'],
            'description' => $validated['description'],
            'code' => $validated['code'], // Lưu 'code' vào cơ sở dữ liệu
        ]);

        // Lưu sub_categories nếu có
        if (isset($validated['sub_category_code']) && isset($validated['sub_category_name'])) {
            foreach ($validated['sub_category_code'] as $index => $code) {
                $subCategoryName = $validated['sub_category_name'][$index] ?? null;

                // Lưu từng sub_category nếu có mã và tên
                if ($code && $subCategoryName) {
                    SubCategory::create([
                        'id' => Str::uuid(), // Tạo ID UUID cho sub-category
                        'category_id' => $category->id, // Liên kết sub-category với category
                        'code' => $code,
                        'name' => $subCategoryName,
                    ]);
                }
            }
        }
        return redirect()->route('categories.create')->with('success', 'Loại sách và danh mục con đã được thêm thành công!');
    }


   // Controller

    public function listView()
    {
        // Lấy tất cả các thể loại sách (categories)
        $categories = Category::with('subCategories')->get(); // Lấy cả subCategories cùng lúc

        // Tạo mảng theo cấu trúc bạn yêu cầu
        $categoryData = $categories->mapWithKeys(function ($category) {
            return [
                $category->id => [
                    'code' => $category->code,
                    'name' => $category->name,
                    'description' => $category->description,
                    'sub_categories' => $category->subCategories->mapWithKeys(function ($subCategory) {
                        return [
                            $subCategory->id => [
                                'code' => $subCategory->code,
                                'name' => $subCategory->name,
                            ],
                        ];
                    }),
                ]
            ];
        });

        // Trả về view và truyền mảng dữ liệu
        return view('categories.listView', compact('categoryData'));
    }

}
