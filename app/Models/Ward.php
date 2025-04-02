<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $table = 'wards';
    protected $primaryKey = 'wards_id';
    public $timestamps = false;
    
    protected $fillable = [
        'wards_id',
        'district_id',
        'name'
    ];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'district_id');
    }

    public function fonds()
    {
        return $this->hasMany(Fond::class, 'wards_id', 'wards_id');
    }
}