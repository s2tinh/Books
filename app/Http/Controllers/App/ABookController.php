<?php

namespace App\Http\Controllers\App;
use Illuminate\Http\Request;
use App\Models\BookImage; // Import model BookImage
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Book;
use App\Http\Controllers\Controller;

class ABookController extends Controller
{

    public function detailView(Request $request)
    {
        // Lấy ID từ query string
        $id = $request->query('id');

        // Lấy thông tin sách từ cơ sở dữ liệu kèm danh mục, phụ danh mục và hình ảnh
        $book = Book::with(['category', 'subCategory', 'bookImages'])->find($id);

        // Kiểm tra nếu sách không tồn tại
        if (!$book) {
            return redirect()->route('home')->with('error', 'Sách không tồn tại.');
        }

        // Trả về view với dữ liệu sách
        return view('books.app.detailView', compact('book'));
    }
    public function listView(Request $request)
    {
        // Lấy tham số từ URL
        $categoryId = $request->query('category_id');
        $bookss = Book::select('id', 'author', 'cover_type', 'book_size', 'publisher')->get();  // ds cho filler sidebar
        $arrbooks = $bookss->map(function ($book) {
            return [
                'id' => $book->id,
                'author' => strtoupper($book->author),
                'cover_type' => ucfirst($book->cover_type),
                'book_size' => $book->book_size,
                'publisher' => $book->publisher,
            ];
        })->unique('publisher'); // Loại bỏ phần tử trùng lặp theo publisher

        // Lấy dữ liệu cho sidebar (mergedCategories và dropdowns)
        $categories = Category::with('subCategories')->get();
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

        $dropdowns = config('dropdowns.dropdowns');

        // Lấy tất cả các category cùng với subcategories và sách
        $categories = Category::with(['subCategories.books'])->get();
        // Nếu có tham số category_id, lọc chỉ lấy category đó
        if ($categoryId) {
            $categories = $categories->where('id', $categoryId);
        }

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
        $simpleData = Category::with(['subCategories.books'])->get()->map(function ($category) {
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

        // Trả dữ liệu cho view (ví dụ: 'books.app.listView') hoặc trả lại dưới dạng JSON
        return view('books.app.listView',  [
            'categories' => $data,      // Mảng đầy đủ chi tiết
            'simpleCategories' => $simpleData, // Mảng đơn giản chỉ có tên, subcategories và hình ảnh
            'arrbooks'=> $arrbooks, // Mảng sách
            'categories2' => $mergedCategories,  // Dữ liệu sidebar
            'languages' => $dropdowns['languages'], // Dữ liệu dropdown ngôn ngữ
            'ageGroups' => $dropdowns['age_groups'], // Dữ liệu dropdown nhóm tuổi
        ]);
    }


}



