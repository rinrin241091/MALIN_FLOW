<link rel="stylesheet" href="{{ asset('backend/css/category.css') }}">
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Quản lý danh mục</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
            <li>
                <a href="{{ route('category.warehouses') }}">Kho lưu trữ</a>
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
                    <h5>Thêm mới kho lưu trữ</h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="{{ route('category.warehouses.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="fond_id">Phông <span class="text-danger">*</span></label>
                            <select name="fond_id" id="fond_id" class="form-control" required>
                                <option value="">Chọn phông</option>
                                @foreach($fonds as $fond)
                                    <option value="{{ $fond->id }}" {{ old('fond_id') == $fond->id ? 'selected' : '' }}>
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
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="location">Vị trí</label>
                            <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}">
                            @error('location')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="capacity">Sức chứa</label>
                            <input type="number" name="capacity" id="capacity" class="form-control" value="{{ old('capacity') }}">
                            @error('capacity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Lưu</button>
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