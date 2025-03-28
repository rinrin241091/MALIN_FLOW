<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    // Hàm tạo mã định danh cho tài liệu
    private function generateDocumentIdentifier($category)
    {
        $year = now()->year;
        //Lấy phần mã danh mục(bỏ phần số thứ tự cuối)
        $categoryPrefix = Str::beforeLast($category->identifier, '-');

        //Tìm tài liệu cuối cùng trong danh mục để xác định số thứ tự tiếp theo
        $lastDocument = Document::where('category_id', $category_id)
            ->where('identifier', 'like', "$categoryPrefix-$year-%")
            ->orderBy('identifier', 'desc')
            ->first();
            
        //Tính số thứ tự
        $number = $lastDocument ? (int) Str::afterLast($lastDocument->identifier, '-') + 1 : 1;
        // Định dạng số thứ tự thành 3 chữ số
        $number = str_pad($number, 3, '0', STR_PAD_LEFT);

        // Trả về mã định danh: [Mã danh mục]-[Năm]-[Số thứ tự]
        return "$categoryPrefix-$year-$number";
    }

    // Hiển thị danh sách tài liệu
    public function index()
    {
        $documents = Document::with('category')->get();
        return view('backend.document.index', compact('documents'));
    }

    // Hiển thị form tạo tài liệu mới
    public function create()
    {
        $categories = Category::all();
        return view('backend.document.create', compact('categories'));
    }

    //Xử lý lưu tài liệu mới
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255', 
            'category_id' => 'required|exists:categories,id', 
        ]);
        $category = Category::findOrFail($request->category_id);

        $document = Document::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
        ]);

        $document->identifier = $this->generateDocumentIdentifier($category);
        $document->save();

        return redirect()->route('document.index')->with('success', 'Tạo tài liệu thành công.');
    }
    // Thêm phương thức edit
    public function edit($id)
    {
        $document = Document::findOrFail($id);
        $categories = Category::all();
        return view('backend.document.edit', compact('document', 'categories'));
    }

    // Thêm phương thức update
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $document = Document::findOrFail($id);
        $category = Category::findOrFail($request->category_id);

        $document->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
        ]);

        $document->identifier = $this->generateDocumentIdentifier($category);
        $document->save();

        return redirect()->route('document.index')->with('success', 'Cập nhật tài liệu thành công.');
    }

    // Thêm phương thức destroy
    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        $document->delete();

        return redirect()->route('document.index')->with('success', 'Xóa tài liệu thành công.');
    }
}