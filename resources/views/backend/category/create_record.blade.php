<link rel="stylesheet" href="{{ asset('backend/css/category.css') }}">
<script src="{{ asset('js/jquery-1.12.4.min.js') }}"></script>

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
                <strong>Biên mục tài liệu</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Biên mục tài liệu cho phông: {{ $fond->name }}</h5>
                </div>
                <div class="ibox-content">
                    <!-- Form nhập liệu thủ công -->
                    <h3>Nhập liệu thủ công</h3>
                    <form method="POST" action="{{ route('category.records.store', $fond->id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="title">Tiêu đề <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="author">Tác giả</label>
                            <input type="text" name="author" id="author" class="form-control" value="{{ old('author') }}">
                            @error('author')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="created_date">Ngày tạo</label>
                            <input type="date" name="created_date" id="created_date" class="form-control" value="{{ old('created_date') }}">
                            @error('created_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea name="description" id="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                            <a href="{{ route('category.fonds') }}" class="btn btn-default">Hủy</a>
                        </div>
                    </form>

                    <!-- Form nhập liệu từ Excel -->
                    <h3>Nhập liệu từ Excel</h3>
                    <form method="POST" action="{{ route('category.records.import', $fond->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="excel_file">Chọn file Excel <span class="text-danger">*</span></label>
                            <input type="file" name="excel_file" id="excel_file" class="form-control" accept=".xlsx, .xls" required>
                            @error('excel_file')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Nhập dữ liệu</button>
                            <a href="{{ route('category.fonds') }}" class="btn btn-default">Hủy</a>
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