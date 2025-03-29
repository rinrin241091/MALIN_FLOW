<link rel="stylesheet" href="{{ asset('backend/css/category.css') }}">
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Quản lý danh mục</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
            <li>
                <a href="{{ route('category.categories') }}">Danh mục tài liệu</a>
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
                    <h5>Thêm mới danh mục tài liệu</h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="{{ route('category.categories.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="fond_id">Phông</label>
                            <select name="fond_id" id="fond_id" class="form-control" required>
                                <option value="">Chọn phông</option>
                                @foreach($fonds as $fond)
                                    <option value="{{ $fond->id }}">{{ $fond->name }}</option>
                                @endforeach
                            </select>
                            @error('fond_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Tên danh mục</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                        <a href="{{ route('category.categories') }}" class="btn btn-default">Hủy</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>