<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelf extends Model
{
    use HasFactory;
    protected $fillable = ['warehouse_id', 'name', 'code', 'capacity'];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function boxes()
    {
        return $this->hasMany(Box::class);
    }
}
