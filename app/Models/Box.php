<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory;
    protected $fillable = ['shelf_id', 'name', 'code', 'capacity'];

    public function shelf()
    {
        return $this->belongsTo(Shelf::class);
    }

    public function records()
    {
        return $this->hasMany(Record::class);
    }
}
