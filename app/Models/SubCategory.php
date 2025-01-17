<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
class SubCategory extends Model
{
    use HasFactory;
    use HasEagerLimit;
    
    protected $table = 'sub_categories'; 
    // Định nghĩa rằng khóa chính là kiểu char (36)
    protected $primaryKey = 'id';
    protected $keyType = 'string'; // Vì ID là UUID (string), nên kiểu của nó là 'string'
    protected $fillable = ['id', 'category_id', 'code', 'name'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id'); // category_id là cột liên kết
    }

    public function books()
    {
        return $this->hasMany(Book::class, 'sub_category_id', 'id');
    }

}
