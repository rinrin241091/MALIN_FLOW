<?php

namespace App\Imports;

use App\Models\Record;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class RecordsImport implements ToModel, WithHeadingRow, WithValidation
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
        // Tạo mã định danh
        $lastRecord = Record::orderBy('id', 'desc')->first();
        $lastNumber = $lastRecord ? (intval(substr($lastRecord->code, 6)) ?: 0) + 1 : 1;
        $code = 'RECORD' . str_pad($lastNumber, 4, '0', STR_PAD_LEFT);

        return new Record([
            'fond_id' => $this->fondId,
            'title' => $row['title'],
            'author' => $row['author'] ?? null,
            'created_date' => $row['created_date'] ?? null,
            'description' => $row['description'] ?? null,
            'code' => $code
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'created_date' => 'nullable|date',
            'description' => 'nullable|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'title.required' => 'Tiêu đề là bắt buộc',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',
            'author.max' => 'Tên tác giả không được vượt quá 255 ký tự',
            'created_date.date' => 'Ngày tạo không đúng định dạng',
        ];
    }
}
