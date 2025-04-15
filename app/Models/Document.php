<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    //Các cột có thể được gắn giá trị hàng loạt
    protected $fillable = [
        'doc_code',
        'file_code',
        'identifier',
        'organ_id',
        'file_catalog',
        'file_notation',
        'doc_ordinal',
        'type_name',
        'code_number',
        'code_notation',
        'issued_date',
        'organ_name',
        'subject',
        'language',
        'page_amount',
        'description',
        'infor_sign',
        'keyword',
        'mode',
        'confidence_level',
        'autograph',
        'format'
    ];

    protected $casts = [
        'issued_date' => 'date',
        'file_catalog' => 'integer',
        'doc_ordinal' => 'integer',
        'page_amount' => 'integer'
    ];

    //Quan hệ với danh mục: một tài liệu thuộc về một danh mục
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}