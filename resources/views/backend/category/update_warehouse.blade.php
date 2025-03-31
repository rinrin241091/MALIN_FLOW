<link rel="stylesheet" href="{{ asset('backend/css/category.css') }}">
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Quản lý danh mục</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
            <li>
                <a href="{{ route('category.shelves') }}">Kho lưu trữ</a>
            </li>
            <li class="active">
                <strong>Chỉnh sửa</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Chỉnh sửa Kho lưu trữ</h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="{{ route('category.updateWarehouse', $warehouse->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="fond_id">Phông <span class="text-danger">*</span></label>
                            <select name="fond_id" id="fond_id" class="form-control" required>
                                <option value="">Chọn Phông</option>
                                @foreach($fonds as $fond)
                                    <option value="{{ $fond->id }}" {{ old('fond_id', $warehouse->fond_id) == $fond->id ? 'selected' : '' }}>
                                        {{ $fond->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('fond_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Tên kho <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $warehouse->name) }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="code">Mã kho <span class="text-danger">*</span></label>
                            <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $warehouse->code) }}" required>
                            @error('code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="location">Vị trí <span class="text-danger">*</span></label>
                            <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $warehouse->location) }}" required>
                            @error('location')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="capacity">Sức chứa <span class="text-danger">*</span></label>
                            <input type="number" name="capacity" id="capacity" class="form-control" value="{{ old('capacity', $warehouse->capacity) }}" required min="1">
                            @error('capacity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $warehouse->description) }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                            <a href="{{ route('category.warehouses') }}" class="btn btn-default">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>            

@push('styles')
<style>
.form-group {
    margin-bottom: 20px;
}

label {
    font-weight: 600;
    margin-bottom: 5px;
}

.text-danger {
    color: #ed5565;
}

.form-control {
    border: 1px solid #e5e6e7;
    border-radius: 1px;
    padding: 6px 12px;
    height: 34px;
}

textarea.form-control {
    height: auto;
}

.btn {
    margin-right: 5px;
}

.btn-primary {
    background-color: #1ab394;
    border-color: #1ab394;
}

.btn-default {
    background-color: #fff;
    border-color: #ddd;
}
</style>
@endpush
