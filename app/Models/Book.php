<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Thêm Str để tạo UUID
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
class Book extends Model
{
    use HasFactory;
    use HasEagerLimit;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'books';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'book_code',
        'title',
        'author',
        'price',
        'description',
        'year_publication',
        'sub_category_id',
        'images',
        'cover_type',
        'book_size',
        'publisher',
        'language',
        'age_group',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'year_publication' => 'integer',
        'price' => 'decimal:2',
    ];

    /**
     * Define the relationship with the Category model.
     */
    public function category()
    {
        return $this->hasOneThrough(
            Category::class,      // Model đích: Category
            SubCategory::class,   // Model trung gian: SubCategory
            'id',                 // Khóa chính của SubCategory
            'id',                 // Khóa chính của Category
            'sub_category_id',    // Khóa ngoại trong bảng Book
            'category_id'         // Khóa ngoại trong bảng SubCategory
        );
    }


    /**
     * The boot method to automatically generate UUID for new books.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($book) {
            if (!$book->id) {
                $book->id = Str::uuid(); // Tạo UUID nếu không có id
            }
        });
    }

    public function bookImages()
    {
        return $this->hasMany(BookImage::class, 'book_id', 'id');
    }
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id', 'id');
    }
}
