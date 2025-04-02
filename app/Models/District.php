<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'district';
    protected $primaryKey = 'district_id';
    public $timestamps = false;
    
    protected $fillable = [
        'district_id',
        'province_id',
        'name'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }

    public function wards()
    {
        return $this->hasMany(Ward::class, 'district_id', 'district_id');
    }

    public function fonds()
    {
        return $this->hasMany(Fond::class, 'district_id', 'district_id');
    }
}