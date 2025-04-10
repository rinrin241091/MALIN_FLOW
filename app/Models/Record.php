<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;
    protected $fillable = ['fond_id', 'title', 'author', 'created_date', 'description', 'code'];

    public function box()
    {
        return $this->belongsTo(Box::class);
    }
}
