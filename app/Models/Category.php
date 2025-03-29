<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['fond_id', 'name', 'code', 'description'];

    public function fond()
    {
        return $this->belongsTo(Fond::class);
    }
}
