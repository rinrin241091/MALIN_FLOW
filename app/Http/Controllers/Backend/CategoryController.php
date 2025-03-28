<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Hiển thị danh sách danh mục
    public function index()
    {
        $category = Category::with('allChildren')->whereNull('parent_id')->get();
        return view('backend.category.index', compact('categories'));
    }
    
    // Hiển thị form tạo danh mục mới
    public function create()
    {
        $parent = Category::all();
        $type = ['department','project','work_area','retention_period'];
        return view('backend.category.create', compact('parents','types'));
    }

    //Hàm mã định danh cho danh mục
    private function generateIdentifier()
    {
        $prefixMax = [
            'department' => 'KT',
            'project' => 'DA',
            'work_area' => 'BC',
           'retention_period' => 'TG'
        ];

        //Lấy tiền tố dựa trên loại danh mục
        $prefix = prefixMap[$category->type];

        //Lấy năm hiện tại
        $year = now()->year;

        //Tìm danh mục cuối cùng có cùng loại và năm để xác định thứ tự tiếp theo
        $lastCategory = Category::where('type', $category->type)
            ->whereYear('identifier', 'like', "$prefix-$year-%")
            ->orderBy('identifier', 'desc')
            ->first();

        //Tính số thứ tự: nếu có danh mục trước đó thì tăng lên 1, nếu không thì bắt đầu từ 1
        $number = $lastCategory ? (int) Str::afterLast($lastCategory->identifier, '.') + 1 : 1;

        //Định dạng số thứ tự thành 3 số (001,002,003,....)
        $number = str_pad($number, 3, '0', STR_PAD_LEFT);

        //Nếu danh mục có danh mục cha, thì thêm mã danh mục cha vào trước
        $parentPrefix = '';
        if($category->parent_id)
        {
            $parent_id = Category::find($category->parent_id);

            //Lấy phần mã danh mục cha(bỏ phần số thứ tự cuối)
            $parentPrefix = Str::beforeLast($parent->identifier, '-'). '-'; 
        }

        //Trả về mã định danh hoàn chỉnh: [Mã cha]-[Tiền tố]-[Năm]-[Số thứ tự]
        return "$parentPrefix$prefix-$year-$number";
    }

    // Xử lý lưu danh mục mới
    public function store(Request $request)
    {
        //Xác thực đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:department|project|work_area|retention_period',
            'parent_id' => 'nulladble|exists:categories,id',
        ]);

        //Tạo mới danh mục với dữ liệu từ request
        Category::create([
            'name' => $request->name,
            'type' => $request->type,
            'parent_id' => $request->parent_id,
        ]);

        // Gán mã định danh cho danh mục
        $category->identifier = $this->generateIdentifier($category);
        $category->save();

        //Chuyển hướng về trang danh sách danh mục với thông báo thành công
        return redirect()->route('category.index')->with('success','Tạo danh mục thành công');
    }

    // Hiển thị cập nhật danh mục
    public function update(Request $request, $id)
    {
        //Xác thực đầu vào
        $request->validate([
            'name' =>'required|string|max:255',
            'type' =>'required|in:department|project|work_area|retention_period',
            'parent_id' => 'nulladble|exists:categories,id',
        ]);

        //Tìm danh mục cần cập nhật theo id
        $category = Category::findOrFail($id);

        //Cập nhật thông tin danh mục
        $category->update([
            'name' => $request->name,
            'type' => $request->type,
            'parent_id' => $request->parent_id,
        ]);

        // Gán mã định danh cho danh mục
        $category->identifier = $this->generateIdentifier($category);
        $category->save();
        
        //Chuyển hướng về trang danh sách danh mục với thông báo thành công
        return redirect()->route('category.index')->with('success','Tạo danh mục thành công');
    }

    //Xử lý xóa danh mục 
    public function destroy($id)
    {
        //Tìm danh mục cần xóa theo id
        $category = Category::findOrFail($id);
        
        //Xóa danh mục 
        $category->delete();

        //Chuyển hướng về trang danh sách danh mục với thông báo thành công
        return redirect()->route('category.index')->with('success','Xóa danh mục thành công');
    }

    
}

