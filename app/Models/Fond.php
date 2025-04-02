<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fond extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'address',
        'province_id',
        'district_id',
        'wards_id'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'district_id');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'wards_id', 'wards_id');
    }
}