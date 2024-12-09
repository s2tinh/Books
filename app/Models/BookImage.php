<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BookImage extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'book_id', 'image_path', 'description'];

    public $incrementing = false; // Vô hiệu hóa auto-increment
    protected $keyType = 'string'; // ID sẽ là chuỗi

    // Gắn UUID tự động khi tạo bản ghi
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}
