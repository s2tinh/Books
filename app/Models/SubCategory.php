<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'sub_categories'; 
    // Định nghĩa rằng khóa chính là kiểu char (36)
    protected $primaryKey = 'id';
    protected $keyType = 'string'; // Vì ID là UUID (string), nên kiểu của nó là 'string'
    protected $fillable = ['id', 'category_id', 'code', 'name'];
}
