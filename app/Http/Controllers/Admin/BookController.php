<?php

namespace App\Http\Controllers\Admin;
use App\Models\BookImage; // Import model BookImage
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookController extends Controller
{
    // Phương thức hiển thị form thêm sách mới
    public function create()
    {
        $categories = Category::all(); 
        return view('books.create', compact('categories'));
    }

    public function edit(Request $request)
    {
        $id = $request->query('id'); // Lấy ID từ query string
        $book = Book::with(['category', 'subCategory', 'bookImages'])->findOrFail($id); // Lấy sách kèm danh mục, phụ danh mục và hình ảnh
        $categories = Category::all(); // Lấy tất cả danh mục

        // Trả về view với dữ liệu sách và danh mục
        return view('books.create', compact('book', 'categories'));
    }




    public function store(Request $request)
    {

        // return dd($request->all());
        try {
            // Validate dữ liệu form
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'price' => 'required|numeric',
                'description' => 'required|string',
                'publication_date' => 'required|date',
                'sub_category_id' => 'required|exists:sub_categories,id', // Thay category_id bằng sub_category_id
                'images' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', // Validate ảnh chính
                'extra_images.*' => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:2048', // Validate ảnh phụ
                'extra_images_description.*' => 'nullable|string|max:500', // Mô tả ảnh phụ (nếu có)
                'cover_type' => 'nullable|string',
                'book_size' => 'nullable|string',
                'publisher' => 'nullable|string',
                'book_code' => 'required|string|unique:books,book_code', // Bắt buộc nhập và không được trùng
                'language' => 'required|integer', // Chỉ cần là số nguyên
                'age_group' => 'required|integer', // Chỉ cần là số nguyên
            ]);

            // Xử lý upload ảnh chính
            $imagePath = $request->file('images')->store('images/books', 'public');  // Lưu ảnh vào storage

            // Tạo sách mới
            $book = Book::create([
                'id' => (string) Str::uuid(),  // Sử dụng UUID cho id
                'book_code' => $validated['book_code'],  // Mã sách
                'title' => $validated['title'],
                'author' => $validated['author'],
                'price' => $validated['price'],
                'description' => $validated['description'],
                'publication_date' => $validated['publication_date'],
                'sub_category_id' => $validated['sub_category_id'], // Thay category_id bằng sub_category_id
                'images' => $imagePath,  // Lưu đường dẫn vào cơ sở dữ liệu
                'cover_type' => $validated['cover_type'],
                'book_size' => $validated['book_size'],
                'publisher' => $validated['publisher'],
                'language' => $validated['language'], // Thêm ngôn ngữ
                'age_group' => $validated['age_group'], // Thêm độ tuổi
            ]);

            // Xử lý upload ảnh phụ (nếu có)
            if ($request->hasFile('extra_images')) {
                $extraImages = $request->file('extra_images');
                $extraDescriptions = $request->input('extra_images_description', []); // Lấy mô tả ảnh phụ (nếu có)

                foreach ($extraImages as $index => $image) {
                    // Lưu ảnh phụ
                    $imagePath = $image->store('images/books/extra', 'public');
                    // Mô tả ảnh phụ (nếu có)
                    $description = isset($extraDescriptions[$index]) ? $extraDescriptions[$index] : null;

                    // Lưu vào bảng `book_images`
                    BookImage::create([
                        'id' => (string) Str::uuid(),
                        'book_id' => $book->id,
                        'image_path' => $imagePath,  // Lưu đường dẫn ảnh phụ vào cơ sở dữ liệu
                        'description' => $description,
                    ]);
                }
            }

            // Quay lại trang danh sách sách với thông báo thành công
            return redirect()->route('books.create')->with('success', 'Sách đã được thêm thành công!');
        } catch (\Exception $e) {
            // Nếu có lỗi xảy ra, trả về lỗi
            return redirect()->route('books.create')->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function listView()
    {
        // Lấy tất cả danh mục và danh mục con
        $categories = Category::with('subCategories')->get(); // Tận dụng quan hệ đã định nghĩa
        $books = Book::paginate(12); // Hiển thị 10 cuốn sách mỗi trang

        // Lấy mảng cấu hình từ file config
        $dropdowns = config('dropdowns.dropdowns');

        // Tạo mảng gộp danh mục và danh mục con
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

        // Trả về view và truyền dữ liệu
        return view('books.listView', [
            'books' => $books,
            'categories' => $mergedCategories, // Truyền mảng gộp vào view
            'languages' => $dropdowns['languages'], // Lấy ngôn ngữ
            'ageGroups' => $dropdowns['age_groups'], // Lấy đối tượng
        ]);
    }



    public function checkBookCode(Request $request)
    {
        $bookCode = $request->input('book_code');
        $bookCode = str_replace(' ', '', $bookCode); // Loại bỏ khoảng trắng

        // Kiểm tra xem mã sách có chứa ký tự không hợp lệ hay không
        if (!preg_match('/^[a-zA-Z0-9]+$/', $bookCode)) {
            return response()->json(['status' => 'invalid', 'message' => 'Mã sách chỉ được chứa chữ cái và số.'], 200);
        }

        // Kiểm tra xem mã sách có tồn tại trong database hay không
        $exists = Book::where('book_code', $bookCode)->exists();

        if ($exists) {
            return response()->json(['status' => 'exists', 'message' => 'Mã sách đã tồn tại.'], 200);
        }

        return response()->json(['status' => 'available', 'message' => 'Mã sách hợp lệ.'], 200);
    }

    public function getSubCategories($categoryId)
    {
        // Lấy tất cả sub_categories theo category_id
        $subCategories = SubCategory::where('category_id', $categoryId)->get();

        // Trả về dữ liệu dưới dạng JSON
        return response()->json($subCategories);
    }

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
        return view('books.detailView', compact('book'));
    }



































}




