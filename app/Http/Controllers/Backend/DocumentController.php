<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DocumentsImport;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::paginate(10);
        return view('backend.documents.index', compact('documents'));
    }

    public function create()
    {
        return view('backend.documents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doc_code' => 'required|string|max:25',
            'file_code' => 'required|string|max:13',
            'identifier' => 'required|string|max:13',
            'organ_id' => 'required|string|max:13',
            'file_catalog' => 'required|integer',
            'file_notation' => 'required|string|max:20',
            'doc_ordinal' => 'required|integer',
            'type_name' => 'required|string|max:100',
            'code_number' => 'required|string|max:11',
            'code_notation' => 'required|string|max:30',
            'issued_date' => 'required|date',
            'organ_name' => 'required|string|max:200',
            'subject' => 'required|string|max:500',
            'language' => 'required|string|max:100',
            'page_amount' => 'required|integer',
            'description' => 'nullable|string|max:500',
            'infor_sign' => 'required|string|max:30',
            'keyword' => 'required|string|max:100',
            'mode' => 'required|string|max:20',
            'confidence_level' => 'required|string|max:30',
            'autograph' => 'required|string|max:2000',
            'format' => 'required|string|max:50',
        ]);

        try {
            DB::beginTransaction();
            Document::create($validated);
            DB::commit();
            return redirect()->route('documents.index')->with('success', 'Tài liệu đã được tạo thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra khi tạo tài liệu: ' . $e->getMessage());
        }
    }

    public function edit(Document $document)
    {
        return view('backend.documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'doc_code' => 'required|string|max:25',
            'file_code' => 'required|string|max:13',
            'identifier' => 'required|string|max:13',
            'organ_id' => 'required|string|max:13',
            'file_catalog' => 'required|integer',
            'file_notation' => 'required|string|max:20',
            'doc_ordinal' => 'required|integer',
            'type_name' => 'required|string|max:100',
            'code_number' => 'required|string|max:11',
            'code_notation' => 'required|string|max:30',
            'issued_date' => 'required|date',
            'organ_name' => 'required|string|max:200',
            'subject' => 'required|string|max:500',
            'language' => 'required|string|max:100',
            'page_amount' => 'required|integer',
            'description' => 'nullable|string|max:500',
            'infor_sign' => 'required|string|max:30',
            'keyword' => 'required|string|max:100',
            'mode' => 'required|string|max:20',
            'confidence_level' => 'required|string|max:30',
            'autograph' => 'required|string|max:2000',
            'format' => 'required|string|max:50',
        ]);

        try {
            DB::beginTransaction();
            $document->update($validated);
            DB::commit();
            return redirect()->route('documents.index')->with('success', 'Tài liệu đã được cập nhật thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật tài liệu: ' . $e->getMessage());
        }
    }

    public function destroy(Document $document)
    {
        try {
            DB::beginTransaction();
            $document->delete();
            DB::commit();
            return redirect()->route('documents.index')->with('success', 'Tài liệu đã được xóa thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra khi xóa tài liệu: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new DocumentsImport, $request->file('excel_file'));

            return redirect()->route('documents.index')
                ->with('success', 'Đã import dữ liệu thành công');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            
            foreach ($failures as $failure) {
                $errors[] = "Dòng {$failure->row()}: {$failure->errors()[0]}";
            }

            return back()->withErrors($errors)->withInput();
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Có lỗi xảy ra khi import dữ liệu: ' . $e->getMessage())
                ->withInput();
        }
    }
} 