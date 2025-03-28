<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    //Các cột có thể được gắn giá trị hàng loạt
    protected $fillable = ['title', 'identifier', 'category_id'];

    //Quan hệ với danh mục: một tài liệu thuộc về một danh mục
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}