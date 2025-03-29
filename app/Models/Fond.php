<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fond extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'code', 'description'];
    
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }
}
