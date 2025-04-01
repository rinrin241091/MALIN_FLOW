// Hộp trên kệ
    public function boxes(Request $request)
    {
        $search = $request->query('search');
        $shelf_id = $request->query('shelf_id');
        $boxes = Box::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
        })->when($shelf_id, function ($query, $shelf_id) {
            return $query->where('shelf_id', $shelf_id);
        })->paginate(20);

        $shelves = Shelf::all();
        $template = 'backend.category.boxes';
        $title = 'Quản lý danh mục - Hộp trên kệ';
        return view('backend.dashboard.layout', compact('boxes', 'shelves', 'shelf_id', 'template', 'title'));
    }

    public function createBox()
    {
        $shelves = Shelf::all();
        $template = 'backend.category.create_box';
        $title = 'Quản lý danh mục - Thêm mới hộp trên kệ';
        return view('backend.dashboard.layout', compact('shelves', 'template', 'title'));
    }

    public function storeBox(Request $request)
    {
        $request->validate([
            'shelf_id' => 'required|exists:shelves,id',
            'name' => 'required|string|max:255',
            'capacity' => 'nullable|integer',
        ]);

        // Kiểm tra mã đã tồn tại
        $code = $this->generateCode('BOX');
        while (Box::where('code', $code)->exists()) {
            $code = $this->generateCode('BOX'); // Tạo mã mới nếu đã tồn tại
        }

        Box::create([
            'shelf_id' => $request->shelf_id,
            'name' => $request->name,
            'code' => $code,
            'capacity' => $request->capacity,
        ]);
    }

    public function editBox($id)
    {
        $box = Box::findOrFail($id);
        $shelves = Shelf::all();
        $template = 'backend.category.update_box';
        $title = 'Quản lý danh mục - Chỉnh sửa kệ trong kho';
        return view('backend.dashboard.layout', compact('box', 'shelves', 'template', 'title'));
    }

    public function updateBox(Request $request, $id)
    {
        $request->validate([
            'shelf_id' => 'required|exists:shelf,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:boxes,code,'.$id,
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string'
        ]);

        $box = Box::findOrFail($id);
        $box->update([
            'shelf_id' => $request->shelf_id,
            'name' => $request->name,
            'code' => $request->code,
            'capacity' => $request->capacity,
            'description' => $request->description
        ]);

        return redirect()->route('category.boxes')->with('success', 'Cập nhật hộp thành công!');
    }

    public function destroyBox($id)
    {
        try {
            $box = Box::findOrFail($id);
            $box->delete();
            return redirect()->route('category.boxes')
                ->with('success', 'Xóa hộp thành công!');
        } catch (\Exception $e) {
            return redirect()->route('category.boxes')
                ->with('error', 'Có lỗi xảy ra khi xóa hộp!');
        }
    }