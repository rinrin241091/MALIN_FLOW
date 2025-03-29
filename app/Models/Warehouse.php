<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;
    protected $fillable = ['fond_id', 'name', 'code', 'location', 'capacity'];

    public function fond()
    {
        return $this->belongsTo(Fond::class);
    }

    public function shelves()
    {
        return $this->hasMany(Shelf::class);
    }
}
