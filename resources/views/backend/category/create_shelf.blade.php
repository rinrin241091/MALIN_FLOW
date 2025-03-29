<link rel="stylesheet" href="{{ asset('backend/css/category.css') }}">
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Quản lý danh mục</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
            <li>
                <a href="{{ route('category.shelves') }}">Kệ trong kho</a>
            </li>
            <li class="active">
                <strong>Thêm mới</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Thêm mới kệ trong kho</h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="{{ route('category.shelves.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="warehouse_id">Kho</label>
                            <select name="warehouse_id" id="warehouse_id" class="form-control" required>
                                <option value="">Chọn kho</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                            @error('warehouse_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Tên kệ</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="capacity">Sức chứa</label>
                            <input type="number" name="capacity" id="capacity" class="form-control" value="{{ old('capacity') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                        <a href="{{ route('category.shelves') }}" class="btn btn-default">Hủy</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>