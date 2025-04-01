<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Box extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        'shelf_id',
        'status',
        'capacity',
        'used_capacity',
        'created_by',
        'updated_by'
    ];

    // Relationship với Shelf
    public function shelf()
    {
        return $this->belongsTo(Shelf::class);
    }

    // Relationship với User (người tạo)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relationship với User (người cập nhật)
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scope để lọc theo trạng thái
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    // Kiểm tra còn chỗ trống không
    public function hasAvailableSpace()
    {
        return $this->used_capacity < $this->capacity;
    }

    // Lấy số lượng còn trống
    public function getAvailableSpace()
    {
        return $this->capacity - $this->used_capacity;
    }

    public function records()
    {
        return $this->hasMany(Record::class);
    }
}
