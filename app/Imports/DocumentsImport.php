<?php

namespace App\Imports;

use App\Models\Document;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;

class DocumentsImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    public function model(array $row)
    {
        return new Document([
            'doc_code' => $row['doc_code'],
            'file_code' => $row['file_code'],
            'identifier' => $row['identifier'],
            'organ_id' => $row['organ_id'],
            'file_catalog' => $row['file_catalog'],
            'file_notation' => $row['file_notation'],
            'doc_ordinal' => $row['doc_ordinal'],
            'type_name' => $row['type_name'],
            'code_number' => $row['code_number'],
            'code_notation' => $row['code_notation'],
            'issued_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['issued_date']),
            'organ_name' => $row['organ_name'],
            'subject' => $row['subject'],
            'language' => $row['language'],
            'page_amount' => $row['page_amount'],
            'description' => $row['description'] ?? null,
            'infor_sign' => $row['infor_sign'],
            'keyword' => $row['keyword'],
            'mode' => $row['mode'],
            'confidence_level' => $row['confidence_level'],
            'autograph' => $row['autograph'],
            'format' => $row['format']
        ]);
    }

    public function rules(): array
    {
        return [
            'doc_code' => 'required|max:25',
            'file_code' => 'required|max:13',
            'identifier' => 'required|max:13',
            'organ_id' => 'required|max:13',
            'file_catalog' => 'required|numeric',
            'file_notation' => 'required|max:20',
            'doc_ordinal' => 'required|numeric',
            'type_name' => 'required|max:100',
            'code_number' => 'required|max:11',
            'code_notation' => 'required|max:30',
            'issued_date' => 'required',
            'organ_name' => 'required|max:200',
            'subject' => 'required|max:500',
            'language' => 'required|max:100',
            'page_amount' => 'required|numeric',
            'description' => 'nullable|max:500',
            'infor_sign' => 'required|max:30',
            'keyword' => 'required|max:100',
            'mode' => 'required|max:20',
            'confidence_level' => 'required|max:30',
            'autograph' => 'required|max:2000',
            'format' => 'required|max:50'
        ];
    }

    public function customValidationMessages()
    {
        return [
            'doc_code.required' => 'Mã định danh là bắt buộc',
            'file_code.required' => 'Mã hồ sơ là bắt buộc',
            'identifier.required' => 'Mã cơ quan là bắt buộc',
            'organ_id.required' => 'Mã phòng là bắt buộc',
            'file_catalog.required' => 'Mục lục số là bắt buộc',
            'file_notation.required' => 'Ký hiệu hồ sơ là bắt buộc',
            'doc_ordinal.required' => 'STT văn bản là bắt buộc',
            'type_name.required' => 'Loại văn bản là bắt buộc',
            'code_number.required' => 'Số văn bản là bắt buộc',
            'code_notation.required' => 'Ký hiệu là bắt buộc',
            'issued_date.required' => 'Ngày văn bản là bắt buộc',
            'organ_name.required' => 'Cơ quan ban hành là bắt buộc',
            'subject.required' => 'Trích yếu là bắt buộc',
            'language.required' => 'Ngôn ngữ là bắt buộc',
            'page_amount.required' => 'Số trang là bắt buộc',
            'infor_sign.required' => 'Ký hiệu thông tin là bắt buộc',
            'keyword.required' => 'Từ khóa là bắt buộc',
            'mode.required' => 'Chế độ sử dụng là bắt buộc',
            'confidence_level.required' => 'Mức độ tin cậy là bắt buộc',
            'autograph.required' => 'Bút tích là bắt buộc',
            'format.required' => 'Tình trạng vật lý là bắt buộc',
            '*.numeric' => 'Trường :attribute phải là số',
            '*.max' => 'Trường :attribute không được vượt quá :max ký tự'
        ];
    }
} 