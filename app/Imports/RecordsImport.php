<?php

namespace App\Imports;

use App\Models\Record;
use Maatwebsite\Excel\Concerns\ToModel;

class RecordsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    protected $fondId;
    public function __construct($fondId)
    {
        $this->fondId = $fondId;
    } 
    public function model(array $row)
    {
        //Tạo mã định danh
        $lastRecord = Record::orderBy('id', 'desc')->first();
        $lastNumnber = $lastRecord ? (intval(substr($lastRecord->code, 6)) ?: 0) + 1 : 1;
        $code = 'RECORD' . str_pad($lastNumnber, 4, '0', STR_PAD_LEFT);
        return new Record([
            'fond_id' => $this->fondId,
            'title' => $row['title'],
            'author' => $row['author'] ?? null,
            'create_date' => $row['create_date'] ?? null,
            'description' => $row['description'] ?? null,
            'code' => $code,
        ]);
    }
}
