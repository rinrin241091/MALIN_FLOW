<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'type', 'parent_id'];

    //Quan hệ với danh mục cha
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    //Quan hệ với danh mục con
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    //Lấy tất cả danh mục con đệ quy
    public function getAllChildren()
    {
        return $this->children()->with('allChildren');
    }
}
