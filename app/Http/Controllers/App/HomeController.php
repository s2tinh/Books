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

        $categories = Category::with(['subCategories.books' => function ($query) {
            $query->limit(10); // Lấy tối đa 10 sách cho mỗi subCategory
        }])->get();

        // Chuyển đổi dữ liệu để truyền vào view, chỉ lấy category và subcategory có sách
        $mergedCategories = $categories->map(function ($category) {
            $categoryData = [
                'id' => $category->id,
                'name' => $category->name,
                'sub_categories' => $category->subCategories->filter(function ($subCategory) {
                    // Kiểm tra xem SubCategory có sách hay không
                    return $subCategory->books->count() > 0;
                })->map(function ($subCategory) {
                    return [
                        'id' => $subCategory->id,
                        'name' => $subCategory->name,
                        'books' => $subCategory->books->map(function ($book) {
                            return [
                                'id' => $book->id,
                                'title' => $book->title,
                                'images'=> $book->images,
                                'price' => $book->price,
                            ];
                        }),
                    ];
                }),
            ];

            // Nếu không có subcategory có sách, thì loại bỏ category
            return $categoryData['sub_categories']->isEmpty() ? null : $categoryData;
        })->filter(); // Loại bỏ những category không có subcategory nào có sách

        return view('pages.home', [
            'categories' => $mergedCategories,

        ]);
    }


}


