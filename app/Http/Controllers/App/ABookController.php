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

public function cartUpdate(Request $request)
{
    $cart = session()->get('cart', []);

    $id = $request->id;
    $quantity = (int) $request->quantity;

    if (isset($cart[$id])) {
        if ($quantity > 0) {
            $cart[$id]['quantity'] = $quantity;
        } else {
            unset($cart[$id]);
        }
        session()->put('cart', $cart);
    }

    // Tính lại tổng tiền từng sản phẩm và tổng giỏ hàng
    $itemTotal = $cart[$id]['price'] * $cart[$id]['quantity'];
    $cartTotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

    return response()->json([
        'success' => true,
        'newTotal' => number_format($itemTotal, 0, ',', '.') . ' VND', // Định dạng số tiền đúng
        'cartTotal' => number_format($cartTotal, 0, ',', '.') . ' VND',
    ]);
}

    public function checkout_cart(Request $request)
{
    $bookId = $request->input('id');
    $quantity = $request->input('quantity');
    // Tìm sách trong cơ sở dữ liệu
    $book = Book::findOrFail($bookId);

    // Lấy giỏ hàng từ session
    $cart = session()->get('cart', []);

    // Kiểm tra xem sách đã có trong giỏ hàng chưa
    if(isset($cart[$bookId])) {
        $cart[$bookId]['quantity'] += $quantity;
    } else {
        $cart[$bookId] = [
            'id' => $bookId,
            'title' => $book->title,
            'price' => $book->price,
            'quantity' => $quantity,
        ];
    }

    // Lưu giỏ hàng vào session
    session()->put('cart', $cart);

    // Quay lại trang giỏ hàng
    return redirect()->route('books.app.checkout_cart.view');
}
public function viewCart()
{
    // Lấy giỏ hàng từ session
    $cart = session()->get('cart', []);

    // Hiển thị giỏ hàng
    return view('books.app.checkout_cart', compact('cart'));
}
public function removeFromCart($id)
{
    // Lấy giỏ hàng từ session
    $cart = session()->get('cart', []);

    // Kiểm tra nếu sách có trong giỏ hàng và xóa
    if(isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

    // Quay lại trang giỏ hàng
    return redirect()->route('books.app.checkout_cart.view');
}
public function finalizeCheckout()
{
    // Lấy giỏ hàng từ session
    $cart = session()->get('cart', []);

    // Kiểm tra giỏ hàng và thực hiện thanh toán
    if(count($cart) == 0) {
        return redirect()->route('books.app.listView')->with('error', 'Giỏ hàng của bạn trống!');
    }

    // Thực hiện thanh toán (ví dụ: lưu đơn hàng, trừ tiền, v.v...)

    // Sau khi thanh toán xong, xóa giỏ hàng trong session
    session()->forget('cart');

    // Quay lại trang thành công
    return redirect()->route('books.app.listView')->with('success', 'Thanh toán thành công!');
}


public function detailView(Request $request)
{
    // Lấy ID từ query string
    $id = $request->query('id');   

    // Lấy thông tin sách từ cơ sở dữ liệu kèm danh mục, phụ danh mục và hình ảnh
    $book = Book::with(['category', 'subCategory', 'bookImages'])->find($id);



    // Lấy các sách cùng sub_category (5 sản phẩm, ngoại trừ sách hiện tại)
    $relatedBooksSubCategory = Book::where('sub_category_id', $book->subCategory->id)
                                    ->where('id', '!=', $book->id)  // Loại bỏ sách hiện tại
                                    ->limit(5)  // Lấy 5 sách cùng sub_category
                                    ->get();

    // Lấy category của sách hiện tại qua mối quan hệ hasOneThrough
    $categoryId = $book->category ? $book->category->id : null;

    // Lấy các sách cùng category (10 sản phẩm, ngoại trừ sách hiện tại và sách đã lấy từ sub_category)
    $relatedBooksCategory = Book::whereHas('category', function($query) use ($categoryId) {
                                    $query->where('categories.id', $categoryId); // Lọc theo category, chỉ định rõ bảng 'categories'
                                })
                                ->where('id', '!=', $book->id)  // Loại bỏ sách hiện tại
                                ->whereNotIn('id', $relatedBooksSubCategory->pluck('id'))  // Loại bỏ sách đã lấy từ sub_category
                                ->limit(10)  // Lấy 10 sách cùng category
                                ->get();

    // Trả về view với dữ liệu sách và các sách liên quan
    return view('books.app.detailView', compact('book', 'relatedBooksSubCategory', 'relatedBooksCategory'));
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
    if ($priceMin != 0 || $priceMax != 0) {
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



