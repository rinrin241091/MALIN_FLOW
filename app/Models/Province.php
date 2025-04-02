<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'province';
    protected $primaryKey = 'province_id';
    public $timestamps = false;
    
    protected $fillable = [
        'province_id',
        'name'
    ];

    public function districts()
    {
        return $this->hasMany(District::class, 'province_id', 'province_id');
    }

    public function fonds()
    {
        return $this->hasMany(Fond::class, 'province_id', 'province_id');
    }
}