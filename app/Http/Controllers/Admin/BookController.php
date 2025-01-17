<?php

namespace App\Http\Controllers\Admin;
use App\Models\BookImage; // Import model BookImage
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // Phương thức hiển thị form thêm sách mới
    public function create()
    {
        $categories = Category::all(); 
        $mainImagePath = false;
        $additionalImages = false;
        return view('books.admin.create', compact('categories','mainImagePath', 'additionalImages'));
    }

    public function edit(Request $request)
    {
        $id = $request->query('id'); // Lấy ID từ query string
        $book = Book::with(['subCategory.category', 'bookImages', 'subCategory'])->findOrFail($id);
        $categories = Category::all(); // Lấy tất cả danh mục

        // Truyền đường dẫn của ảnh chính vào view
        $mainImagePath = $book->images; // Lấy ảnh chính từ bảng books (giả sử trường là 'images')

        // Truyền ảnh phụ (nếu có) từ bảng book_images
        $additionalImages = $book->bookImages;


        // Trả về view với dữ liệu sách, danh mục, ảnh chính và ảnh phụ
        return view('books.admin.create', compact('book', 'categories', 'mainImagePath', 'additionalImages'));

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
                'year_publication' => 'required|integer|min:1900|max:' . date('Y'),

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
                'year_publication' => $validated['year_publication'],
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
            return redirect()->route('books.admin.create')->with('success', 'Sách đã được thêm thành công!');
        } catch (\Exception $e) {
            // Nếu có lỗi xảy ra, trả về lỗi
            return redirect()->route('books.admin.create')->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
        }
    }

public function update(Request $request)
{
    try {
        // Tìm sách cần cập nhật
        $book = Book::findOrFail($request->id);
        $id = $request->id;

        // Validate dữ liệu form
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'year_publication' => 'required|integer|min:1900|max:' . date('Y'),
            'sub_category_id' => 'required|exists:sub_categories,id',
            'images' => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:2048', // Ảnh chính (nếu có)
            'extra_images.*' => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:2048', // Ảnh phụ
            'extra_images_description.*' => 'nullable|string|max:500', // Mô tả ảnh phụ
            'cover_type' => 'nullable|string',
            'book_size' => 'nullable|string',
            'publisher' => 'nullable|string',
            'book_code' => 'required|string|unique:books,book_code,' . $book->id, // Bỏ qua mã sách hiện tại
            'language' => 'required|integer',
            'age_group' => 'required|integer',
            'removed_extra_images' => 'nullable|array', // Thêm validation cho ảnh phụ đã xóa
            'removed_extra_images.*' => 'nullable|string', // Kiểu đường dẫn ảnh
        ]);

        // Xử lý upload ảnh chính (nếu có)
        if ($request->hasFile('images')) {
            // Xóa ảnh cũ
            if ($book->images && Storage::disk('public')->exists($book->images)) {
                Storage::disk('public')->delete($book->images);
            }
            // Upload ảnh mới
            $imagePath = $request->file('images')->store('images/books', 'public');
            $book->images = $imagePath;
        }

        // Cập nhật thông tin sách
        $book->update([
            'book_code' => $validated['book_code'],
            'title' => $validated['title'],
            'author' => $validated['author'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'year_publication' => $validated['year_publication'],
            'sub_category_id' => $validated['sub_category_id'],
            'cover_type' => $validated['cover_type'],
            'book_size' => $validated['book_size'],
            'publisher' => $validated['publisher'],
            'language' => $validated['language'],
            'age_group' => $validated['age_group'],
        ]);

        // Xử lý ảnh phụ (nếu có)
        if ($request->hasFile('extra_images')) {
            $extraImages = $request->file('extra_images');
            $extraDescriptions = $request->input('extra_images_description', []);

            foreach ($extraImages as $index => $image) {
                // Upload ảnh phụ
                $imagePath = $image->store('images/books/extra', 'public');
                $description = isset($extraDescriptions[$index]) ? $extraDescriptions[$index] : null;

                // Lưu vào bảng book_images
                BookImage::create([
                    'id' => (string) Str::uuid(),
                    'book_id' => $book->id,
                    'image_path' => $imagePath,
                    'description' => $description,
                ]);
            }
        }

        // Xử lý xóa ảnh phụ (nếu có)
        if ($request->has('removed_extra_images') && !empty($request->removed_extra_images)) {
            foreach ($request->removed_extra_images as $imagePath) {
                // Tìm ảnh phụ trong bảng book_images
                $bookImage = BookImage::where('book_id', $book->id)->where('image_path', $imagePath)->first();

                if ($bookImage) {
                    // Xóa ảnh khỏi hệ thống lưu trữ
                    if (Storage::disk('public')->exists($imagePath)) {
                        Storage::disk('public')->delete($imagePath);
                    }

                    // Xóa ảnh khỏi bảng book_images
                    $bookImage->delete();
                }
            }
        }

        // Thông báo thành công
        return redirect()->route('books.admin.editView', ['id' => $book->id])->with('success', 'Sách đã được cập nhật thành công!');
    } catch (\Exception $e) {
        // Trả về lỗi nếu có
        return redirect()->route('books.admin.editView', ['id' => $id])->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
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
        return view('books.admin.listView', [
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
        return view('books.admin.detailView', compact('book'));
    }



































}




