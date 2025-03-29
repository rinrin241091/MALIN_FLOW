<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;
    protected $fillable = ['box_id', 'title', 'code', 'description', 'page_count'];

    public function box()
    {
        return $this->belongsTo(Box::class);
    }
}
