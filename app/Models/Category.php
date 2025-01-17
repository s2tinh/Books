<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Tên bảng trong database
    protected $table = 'categories';

    // Tùy chỉnh khóa chính
    protected $primaryKey = 'id';

    // Chỉ rõ rằng id là một UUID
    public $incrementing = false;
    protected $keyType = 'string'; // Chỉ định ID là chuỗi

    // Các thuộc tính có thể được gán đại trà
    protected $fillable = [
        'id', // ID sẽ là UUID
        'name',
        'description',
        'code',
    ];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id');
    }
 
    
}
