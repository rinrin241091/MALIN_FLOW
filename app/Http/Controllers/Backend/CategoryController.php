<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Fond;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\Shelf;
use App\Models\Box;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // Phông Chỉnh Lý
    public function fonds(Request $request)
    {
        $search = $request->query('search');
        $fonds = Fond::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
        })->paginate(20);

        $template = 'backend.category.fonds';
        $title = 'Quản lý danh mục - Phông chỉnh lý';
        return view('backend.dashboard.layout', compact('fonds', 'template', 'title'));
    }

    public function createFond()
    {
        $template = 'backend.category.create_fond';
        $title = 'Quản lý danh mục - Thêm mới phông chỉnh lý';
        return view('backend.dashboard.layout', compact('template', 'title'));
    }

    public function storeFond(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:fonds,name',
            'description' => 'nullable|string',
        ]);

        $code = $this->generateCode('FOND');
        Fond::create([
            'name' => $request->name,
            'code' => $code,
            'description' => $request->description,
        ]);

        return redirect()->route('category.fonds')->with('success', 'Thêm phông thành công!');
    }

    public function editFond($id)
    {
        $fond = Fond::findOrFail($id);
        $template = 'backend.category.update_fond';
        $title = 'Quản lý danh mục - Chỉnh sửa phông chỉnh lý';
        return view('backend.dashboard.layout', compact('fond', 'template', 'title'));
    }

    public function updateFond(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:fonds,code,'.$id,
            'description' => 'nullable|string'
        ]);

        $fond = Fond::findOrFail($id);
        $fond->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description
        ]);

        return redirect()->route('category.fonds')->with('success', 'Cập nhật phông thành công!');
    }

    public function destroyFond($id)
    {
        try {
            $fond = Fond::findOrFail($id);
            
            // Kiểm tra xem có danh mục nào đang sử dụng phông này không
            if ($fond->categories()->count() > 0) {
                return redirect()->route('category.fonds')
                    ->with('error', 'Không thể xóa phông này vì đang có danh mục sử dụng!');
            }
            
            // Kiểm tra xem có kho nào đang sử dụng phông này không
            if ($fond->warehouses()->count() > 0) {
                return redirect()->route('category.fonds')
                    ->with('error', 'Không thể xóa phông này vì đang có kho sử dụng!');
            }

            $fond->delete();
            return redirect()->route('category.fonds')
                ->with('success', 'Xóa phông thành công!');
        } catch (\Exception $e) {
            return redirect()->route('category.fonds')
                ->with('error', 'Có lỗi xảy ra khi xóa phông!');
        }
    }

    // Danh Mục Tài Liệu
    public function categories(Request $request)
    {
        $search = $request->query('search');
        $fond_id = $request->query('fond_id');
        $categories = Category::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
        })->when($fond_id, function ($query, $fond_id) {
            return $query->where('fond_id', $fond_id);
        })->paginate(20);

        $fonds = Fond::all();
        $template = 'backend.category.categories';
        $title = 'Quản lý danh mục - Danh mục tài liệu';
        return view('backend.dashboard.layout', compact('categories', 'fonds', 'fond_id', 'template', 'title'));
    }

    public function createCategory()
    {
        $fonds = Fond::all();
        $template = 'backend.category.create_category';
        $title = 'Quản lý danh mục - Thêm mới danh mục tài liệu';
        return view('backend.dashboard.layout', compact('fonds', 'template', 'title'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'fond_id' => 'required|exists:fonds,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $code = $this->generateCode('CAT');
        Category::create([
            'fond_id' => $request->fond_id,
            'name' => $request->name,
            'code' => $code,
            'description' => $request->description,
        ]);

        return redirect()->route('category.categories')->with('success', 'Thêm danh mục thành công!');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $fonds = Fond::all();
        $template = 'backend.category.update_category';
        $title = 'Quản lý danh mục - Chỉnh sửa danh mục tài liệu';
        return view('backend.dashboard.layout', compact('category', 'fonds', 'template', 'title'));
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'fond_id' => 'required|exists:fonds,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:categories,code,'.$id,
            'description' => 'nullable|string'
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'fond_id' => $request->fond_id,
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description
        ]);

        return redirect()->route('category.categories')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroyCategory($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return redirect()->route('category.categories')
                ->with('success', 'Xóa danh mục thành công!');
        } catch (\Exception $e) {
            return redirect()->route('category.categories')
                ->with('error', 'Có lỗi xảy ra khi xóa danh mục!');
        }
    }

    // Kho Lưu Trữ
    public function warehouses(Request $request)
    {
        $search = $request->query('search');
        $fond_id = $request->query('fond_id');
        $warehouses = Warehouse::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
        })->when($fond_id, function ($query, $fond_id) {
            return $query->where('fond_id', $fond_id);
        })->paginate(20);

        $fonds = Fond::all();
        $template = 'backend.category.warehouses';
        $title = 'Quản lý danh mục - Kho lưu trữ';
        return view('backend.dashboard.layout', compact('warehouses', 'fonds', 'fond_id', 'template', 'title'));
    }

    public function createWarehouse()
    {
        $fonds = Fond::all();
        $template = 'backend.category.create_warehouse';
        $title = 'Quản lý danh mục - Thêm mới kho lưu trữ';
        return view('backend.dashboard.layout', compact('fonds', 'template', 'title'));
    }

    public function storeWarehouse(Request $request)
    {
        $request->validate([
            'fond_id' => 'required|exists:fonds,id',
            'name' => 'required|string|max:255',
            'location' => 'nullable|string',
            'capacity' => 'nullable|integer',
        ]);

        $code = $this->generateCode('WH');
        Warehouse::create([
            'fond_id' => $request->fond_id,
            'name' => $request->name,
            'code' => $code,
            'location' => $request->location,
            'capacity' => $request->capacity,
        ]);

        return redirect()->route('category.warehouses')->with('success', 'Thêm kho thành công!');
    }

    public function editWarehouse($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $fonds = Fond::all();
        $template = 'backend.category.update_warehouse';
        $title = 'Quản lý danh mục - Chỉnh sửa kho lưu trữ';
        return view('backend.dashboard.layout', compact('warehouse', 'fonds', 'template', 'title'));
    }

    public function updateWarehouse(Request $request, $id)
    {
        $request->validate([
            'fond_id' => 'required|exists:fonds,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:warehouses,code,'.$id,
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string'
        ]);

        $warehouse = Warehouse::findOrFail($id);
        $warehouse->update([
            'fond_id' => $request->fond_id,
            'name' => $request->name,
            'code' => $request->code,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'description' => $request->description
        ]);

        return redirect()->route('category.warehouses')->with('success', 'Cập nhật kho thành công!');
    }

    public function destroyWarehouse($id)
    {
        try {
            $warehouse = Warehouse::findOrFail($id);
            
            // Kiểm tra xem có kệ nào trong kho không
            if ($warehouse->shelves()->count() > 0) {
                return redirect()->route('category.warehouses')
                    ->with('error', 'Không thể xóa kho này vì đang có kệ bên trong!');
            }

            $warehouse->delete();
            return redirect()->route('category.warehouses')
                ->with('success', 'Xóa kho thành công!');
        } catch (\Exception $e) {
            return redirect()->route('category.warehouses')
                ->with('error', 'Có lỗi xảy ra khi xóa kho!');
        }
    }

    // Kệ Trong Kho
    public function shelves(Request $request)
    {
        $search = $request->query('search');
        $warehouse_id = $request->query('warehouse_id');
        $shelves = Shelf::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
        })->when($warehouse_id, function ($query, $warehouse_id) {
            return $query->where('warehouse_id', $warehouse_id);
        })->paginate(20);

        $warehouses = Warehouse::all();
        $template = 'backend.category.shelves';
        $title = 'Quản lý danh mục - Kệ trong kho';
        return view('backend.dashboard.layout', compact('shelves', 'warehouses', 'warehouse_id', 'template', 'title'));
    }

    public function createShelf()
    {
        $warehouses = Warehouse::all();
        $template = 'backend.category.create_shelf';
        $title = 'Quản lý danh mục - Thêm mới kệ trong kho';
        return view('backend.dashboard.layout', compact('warehouses', 'template', 'title'));
    }

    public function storeShelf(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'name' => 'required|string|max:255',
            'capacity' => 'nullable|integer',
        ]);

        $code = $this->generateCode('SHELF');
        Shelf::create([
            'warehouse_id' => $request->warehouse_id,
            'name' => $request->name,
            'code' => $code,
            'capacity' => $request->capacity,
        ]);

        return redirect()->route('category.shelves')->with('success', 'Thêm kệ thành công!');
    }

    public function editShelf($id)
    {
        $shelf = Shelf::findOrFail($id);
        $warehouses = Warehouse::all();
        $template = 'backend.category.update_shelf';
        $title = 'Quản lý danh mục - Chỉnh sửa kệ trong kho';
        return view('backend.dashboard.layout', compact('shelf', 'warehouses', 'template', 'title'));
    }

    public function updateShelf(Request $request, $id)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:shelves,code,'.$id,
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string'
        ]);

        $shelf = Shelf::findOrFail($id);
        $shelf->update([
            'warehouse_id' => $request->warehouse_id,
            'name' => $request->name,
            'code' => $request->code,
            'capacity' => $request->capacity,
            'description' => $request->description
        ]);

        return redirect()->route('category.shelves')->with('success', 'Cập nhật kệ thành công!');
    }

    public function destroyShelf($id)
    {
        try {
            $shelf = Shelf::findOrFail($id);
            $shelf->delete();
            return redirect()->route('category.shelves')
                ->with('success', 'Xóa kệ thành công!');
        } catch (\Exception $e) {
            return redirect()->route('category.shelves')
                ->with('error', 'Có lỗi xảy ra khi xóa kệ!');
        }
    }

    private function generateCode($prefix)
    {
        $lastFond = Fond::orderBy('id', 'desc')->first();
        $lastNumber = $lastFond ? intval(substr($lastFond->code, strlen($prefix))) : 0;
        $newNumber = $lastNumber + 1;
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
