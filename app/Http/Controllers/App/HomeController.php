<?php

namespace App\Http\Controllers\App;
use Illuminate\Http\Request;
use App\Models\BookImage; // Import model BookImage
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Book;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public static function navbar()
    {
        $categories = Category::with('subCategories')->get();
        $books = Book::paginate(12);
        $dropdowns = config('dropdowns.dropdowns');

        $mergedCategories = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'sub_categories' => $category->subCategories->map(function ($subCategory) {
                    return [
                        'id' => $subCategory->id,
                        'name' => $subCategory->name,
                    ];
                }),
            ];
        });

        return view('components.navbar', [
            'categories' => $mergedCategories,
            'languages' => $dropdowns['languages'],
            'ageGroups' => $dropdowns['age_groups'],
        ])->render(); // render() sẽ trả về chuỗi HTML
    }




public function index()
{
    // Lấy tất cả các category cùng với subcategories và sách
    $categories = Category::with(['subCategories.books'])->get();

    // Mảng chính: Dữ liệu chi tiết cho các category
    $data = $categories->filter(function ($category) {
        // Lọc các category có ít nhất một subcategory có sách
        return $category->subCategories->contains(function ($subCategory) {
            return $subCategory->books->count() > 0;
        });
    })->map(function ($category) {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'subCategories' => $category->subCategories->filter(function ($subCategory) {
                // Lọc subcategory có ít nhất một sách
                return $subCategory->books->count() > 0;
            })->map(function ($subCategory) {
                return [
                    'id' => $subCategory->id,
                    'name' => $subCategory->name,
                    'books' => $subCategory->books->map(function ($book) {
                        return [
                            'id' => $book->id,
                            'title' => $book->title,
                            'images' => $book->images ?? 'images/books/default.png',
                            'price' => $book->price,
                            'author' => $book->author,
                        ];
                    }),
                ];
            })->values(), // Reset lại key cho mảng
        ];
    })->values(); // Reset lại key cho mảng

    // Mảng phụ: Chỉ gồm tên category, subcategories nối với dấu "." và lấy 3 hình ảnh sách
    $simpleData = $categories->map(function ($category) {
        // Lấy tất cả các subCategories và nối tên lại bằng dấu " . "
        $subCategoryNames = $category->subCategories->pluck('name')->join('. ');

        // Lấy 3 hình ảnh từ sách (mỗi subcategory lấy tối đa 3 hình ảnh)
        $images = $category->subCategories
            ->flatMap(function ($subCategory) {
                return $subCategory->books->take(3)->pluck('images'); // Lấy tối đa 3 ảnh cho mỗi subcategory
            })
            ->unique() // Loại bỏ hình ảnh trùng lặp
            ->values(); // Reset lại key cho mảng

        return [
            'name' => $category->name,
            'id'=>  $category->id,
            'subCategories' => $subCategoryNames, // Nối các subCategory lại
            'images' => $images->take(3)->all() ?? ['images/books/default.png'], // Lấy 3 ảnh đầu tiên (nếu có)
        ];
    })->filter(function ($item) {
        // Loại bỏ category không có sách
        return !is_null($item['images']);
    })->values(); // Reset lại key cho mảng

    // Truyền cả 2 mảng ra view
    return view('pages.home', [
        'categories' => $data,      // Mảng đầy đủ chi tiết
        'simpleCategories' => $simpleData, // Mảng đơn giản chỉ có tên, subcategories và hình ảnh
    ]);
}



}


