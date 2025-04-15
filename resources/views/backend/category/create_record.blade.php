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
                    <h5>BIÊN MỤC TÀI LIỆU CHO PHÔNG: {{ $fond->name }}</h5>
                </div>
                <div class="ibox-content">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#manual" role="tab">Nhập thủ công</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#excel" role="tab">Nhập từ Excel</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- Tab Nhập thủ công -->
                        <div class="tab-pane active" id="manual" role="tabpanel">
                            <div class="mt-4">
                                <form action="{{ route('category.records.store', $fond->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="title">Tiêu đề <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="author">Tác giả</label>
                                        <input type="text" class="form-control" id="author" name="author">
                                    </div>

                                    <div class="form-group">
                                        <label for="created_date">Ngày tạo</label>
                                        <input type="date" class="form-control" id="created_date" name="created_date">
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Mô tả</label>
                                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                    <button type="reset" class="btn btn-secondary">Hủy</button>
                                </form>
                            </div>
                        </div>

                        <!-- Tab Nhập từ Excel -->
                        <div class="tab-pane" id="excel" role="tabpanel">
                            <div class="mt-4">
                                <div class="alert alert-info">
                                    <h5><i class="icon fas fa-info"></i> Hướng dẫn:</h5>
                                    <p>File Excel cần có các cột sau:</p>
                                    <ul>
                                        <li>title (Tiêu đề) - Bắt buộc</li>
                                        <li>author (Tác giả)</li>
                                        <li>created_date (Ngày tạo)</li>
                                        <li>description (Mô tả)</li>
                                    </ul>
                                </div>

                                <form action="{{ route('category.records.import', $fond->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="excel_file">Chọn file Excel</label>
                                        <input type="file" class="form-control-file" id="excel_file" name="excel_file" accept=".xlsx,.xls" required>
                                    </div>

                                    <button type="submit" class="btn btn-success">Nhập dữ liệu</button>
                                    <button type="reset" class="btn btn-secondary">Hủy</button>
                                </form>
                            </div>
                        </div>
                    </div>
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