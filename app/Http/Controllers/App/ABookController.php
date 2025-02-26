<?php

namespace App\Http\Controllers\App;
use Illuminate\Http\Request;
use App\Models\BookImage; // Import model BookImage
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Book;
use Illuminate\Support\Arr;

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
    // Lấy tham số từ URL và đảm bảo rằng chúng luôn là mảng
    $categoryId = Arr::wrap($request->query('category_id', [])); // Lấy category_id
    $subCategoryId = Arr::wrap($request->query('sub_category_id', [])); // Lấy sub_category_id
    $ageGroup = Arr::wrap($request->query('age_group', [])); // Lấy age_group (tên của trường nhóm tuổi)
    $languages = Arr::wrap($request->query('language', [])); // Lấy ngôn ngữ
    $priceMin = $request->query('price-min', null); // Lấy price-min
    $priceMax = $request->query('price-max', null); // Lấy price-max
    $publisher = Arr::wrap($request->query('publisher', [])); // Lọc theo publisher
    $author = Arr::wrap($request->query('author', [])); // Lọc theo tác giả

    // Lấy danh sách sách cho filler sidebar
    $bookss = Book::select('id', 'author', 'cover_type', 'book_size', 'publisher', 'age_group', 'language', 'price')->get();


    $arrbooks = [
        'publisher' => [],
        'author' => [],
        'language' => []
    ];

    foreach ($bookss as $book) {
        // Thêm vào mảng publisher
        $arrbooks['publisher'][$book->publisher] = $book->publisher;

        // Thêm vào mảng author
        $arrbooks['author'][$book->author] = $book->author;

        // Thêm vào mảng language
        $arrbooks['language'][$book->language] = $book->language;
    }


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
    $categories = Category::with(['subCategories.books'])->get();

    // Lọc theo category_id nếu có
    if (!empty($categoryId)) {
        $categories = $categories->whereIn('id', $categoryId);
    }

    // Lọc theo sub_category_id nếu có
    if (!empty($subCategoryId)) {
        $categories = $categories->map(function ($category) use ($subCategoryId) {
            $category->subCategories = $category->subCategories->filter(function ($subCategory) use ($subCategoryId) {
                return in_array($subCategory->id, (array) $subCategoryId);
            });
            return $category;
        });
    }

    // Lọc theo age_group nếu có
    if (!empty($ageGroup)) {
        $categories = $categories->map(function ($category) use ($ageGroup) {
            $category->subCategories = $category->subCategories->map(function ($subCategory) use ($ageGroup) {
                $subCategory->books = $subCategory->books->filter(function ($book) use ($ageGroup) {
                    return in_array($book->age_group, (array) $ageGroup); // Lọc sách theo age_group
                });
                return $subCategory;
            });
            return $category;
        });
    }

    // Lọc theo ngôn ngữ nếu có
    if (!empty($languages)) {
        $categories = $categories->map(function ($category) use ($languages) {
            $category->subCategories = $category->subCategories->map(function ($subCategory) use ($languages) {
                $subCategory->books = $subCategory->books->filter(function ($book) use ($languages) {
                    return in_array($book->language, (array) $languages); // Lọc sách theo ngôn ngữ
                });
                return $subCategory;
            });
            return $category;
        });
    }

    // Lọc theo price-min và price-max nếu có
    if ($priceMin !== null || $priceMax !== null) {
        $categories = $categories->map(function ($category) use ($priceMin, $priceMax) {
            $category->subCategories = $category->subCategories->map(function ($subCategory) use ($priceMin, $priceMax) {
                $subCategory->books = $subCategory->books->filter(function ($book) use ($priceMin, $priceMax) {
                    $price = $book->price;
                    if ($priceMin !== null && $price < $priceMin) {
                        return false; // Loại bỏ sách có giá thấp hơn price-min
                    }
                    if ($priceMax !== null && $price > $priceMax) {
                        return false; // Loại bỏ sách có giá cao hơn price-max
                    }
                    return true;
                });
                return $subCategory;
            });
            return $category;
        });
    }
    // Lọc theo publisher nếu có
    if (!empty($publisher)) {
        $categories = $categories->map(function ($category) use ($publisher) {
            $category->subCategories = $category->subCategories->map(function ($subCategory) use ($publisher) {
                $subCategory->books = $subCategory->books->filter(function ($book) use ($publisher) {
                    return in_array($book->publisher, (array) $publisher); // Lọc sách theo publisher
                });
                return $subCategory;
            });
            return $category;
        });
    }
    // Lọc theo tác giả nếu có
    if (!empty($author)) {
        $categories = $categories->map(function ($category) use ($author) {
            $category->subCategories = $category->subCategories->map(function ($subCategory) use ($author) {
                $subCategory->books = $subCategory->books->filter(function ($book) use ($author) {
                    return in_array($book->author, (array) $author); // Lọc sách theo tác giả
                });
                return $subCategory;
            });
            return $category;
        });
    }

    // Mảng chính: Dữ liệu chi tiết cho các category
    $data = $categories->filter(function ($category) {
        return $category->subCategories && $category->subCategories->contains(function ($subCategory) {
            return $subCategory->books && $subCategory->books->count() > 0;
        });
    })->map(function ($category) {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'subCategories' => $category->subCategories->filter(function ($subCategory) {
                return $subCategory->books && $subCategory->books->count() > 0;
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
            })->values(),
        ];
    })->values();

    // Mảng phụ: Chỉ gồm tên category, subcategories nối với dấu "." và lấy 3 hình ảnh sách
    $simpleData = Category::with(['subCategories.books'])->get()->map(function ($category) {
        $subCategoryNames = $category->subCategories->pluck('name')->join('. ');
        $images = $category->subCategories
            ->flatMap(function ($subCategory) {
                return $subCategory->books->take(3)->pluck('images');
            })
            ->unique()
            ->values();
        return [
            'name' => $category->name,
            'id' => $category->id,
            'subCategories' => $subCategoryNames,
            'images' => $images->take(3)->all() ?? ['images/books/default.png'],
        ];
    })->filter(function ($item) {
        return !is_null($item['images']);
    })->values();

    // Trả dữ liệu cho view
    return view('books.app.listView', [
        'categories' => $data,      
        'simpleCategories' => $simpleData, 
        'arrbooks' => $arrbooks, 
        'categories2' => $mergedCategories,  
        'languages' => $dropdowns['languages'], 
        'ageGroups' => $dropdowns['age_groups'], // Truyền thêm ageGroups vào view
    ]);
}

}



