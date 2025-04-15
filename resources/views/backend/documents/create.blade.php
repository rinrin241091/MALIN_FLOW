<!DOCTYPE html>
<html>
<head>
    @include('backend.dashboard.component.head')
    <link rel="stylesheet" href="{{ asset('backend/css/category.css') }}">
</head>
<body>
    <div id="wrapper">
        @include('backend.dashboard.component.nav')
        @include('backend.dashboard.component.sidebar')

        <div id="page-wrapper" class="gray-bg">
            @include('backend.dashboard.component.header')

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Quản lý tài liệu</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ route('dashboard.index') }}">Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('documents.index') }}">Danh sách tài liệu</a>
                        </li>
                        <li class="active">
                            <strong>Thêm mới tài liệu</strong>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>THÊM MỚI TÀI LIỆU</h5>
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
                                            @if($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            <form method="POST" action="{{ route('documents.store') }}" class="form-horizontal">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Mã định danh <span class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="doc_code" class="form-control" required maxlength="25" value="{{ old('doc_code') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Mã hồ sơ <span class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="file_code" class="form-control" required maxlength="13" value="{{ old('file_code') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Mã cơ quan <span class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="identifier" class="form-control" required maxlength="13" value="{{ old('identifier') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Mã phòng <span class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="organ_id" class="form-control" required maxlength="13" value="{{ old('organ_id') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Mục lục số <span class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="number" name="file_catalog" class="form-control" required value="{{ old('file_catalog') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Ký hiệu hồ sơ <span class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="file_notation" class="form-control" required maxlength="20" value="{{ old('file_notation') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">STT văn bản <span class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="number" name="doc_ordinal" class="form-control" required value="{{ old('doc_ordinal') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Loại văn bản <span class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="type_name" class="form-control" required maxlength="100" value="{{ old('type_name') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Số văn bản <span class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="code_number" class="form-control" required maxlength="11" value="{{ old('code_number') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Ký hiệu <span class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="code_notation" class="form-control" required maxlength="30" value="{{ old('code_notation') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Ngày văn bản <span class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="date" name="issued_date" class="form-control" required value="{{ old('issued_date') }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Cơ quan ban hành <span class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="organ_name" class="form-control" required maxlength="200" value="{{ old('organ_name') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Trích yếu <span class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <textarea name="subject" class="form-control" required maxlength="500" rows="3">{{ old('subject') }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Ngôn ngữ <span class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="language" class="form-control" required maxlength="100" value="{{ old('language', 'Tiếng Việt') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Số trang <span class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="number" name="page_amount" class="form-control" required value="{{ old('page_amount') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Ghi chú</label>
                                                            <div class="col-sm-9">
                                                                <textarea name="description" class="form-control" maxlength="500" rows="2">{{ old('description') }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Ký hiệu thông tin <span class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="infor_sign" class="form-control" required maxlength="30" value="{{ old('infor_sign') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Từ khóa <span class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="keyword" class="form-control" required maxlength="100" value="{{ old('keyword') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Chế độ sử dụng <span class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="mode" class="form-control" required maxlength="20" value="{{ old('mode') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Mức độ tin cậy <span class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="confidence_level" class="form-control" required maxlength="30" value="{{ old('confidence_level') }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Bút tích <span class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <textarea name="autograph" class="form-control" required maxlength="2000" rows="3">{{ old('autograph') }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Tình trạng vật lý <span class="text-danger">*</span></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="format" class="form-control" required maxlength="50" value="{{ old('format') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-sm-4 col-sm-offset-2">
                                                        <button class="btn btn-primary" type="submit">Lưu lại</button>
                                                        <a class="btn btn-white" href="{{ route('documents.index') }}">Hủy</a>
                                                    </div>
                                                </div>
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
                                                    <li>doc_code (Mã định danh) - Bắt buộc</li>
                                                    <li>file_code (Mã hồ sơ) - Bắt buộc</li>
                                                    <li>identifier (Mã cơ quan) - Bắt buộc</li>
                                                    <li>organ_id (Mã phòng) - Bắt buộc</li>
                                                    <li>file_catalog (Mục lục số) - Bắt buộc</li>
                                                    <li>file_notation (Ký hiệu hồ sơ) - Bắt buộc</li>
                                                    <li>doc_ordinal (STT văn bản) - Bắt buộc</li>
                                                    <li>type_name (Loại văn bản) - Bắt buộc</li>
                                                    <li>code_number (Số văn bản) - Bắt buộc</li>
                                                    <li>code_notation (Ký hiệu) - Bắt buộc</li>
                                                    <li>issued_date (Ngày văn bản) - Bắt buộc</li>
                                                    <li>organ_name (Cơ quan ban hành) - Bắt buộc</li>
                                                    <li>subject (Trích yếu) - Bắt buộc</li>
                                                    <li>language (Ngôn ngữ) - Bắt buộc</li>
                                                    <li>page_amount (Số trang) - Bắt buộc</li>
                                                    <li>description (Ghi chú)</li>
                                                    <li>infor_sign (Ký hiệu thông tin) - Bắt buộc</li>
                                                    <li>keyword (Từ khóa) - Bắt buộc</li>
                                                    <li>mode (Chế độ sử dụng) - Bắt buộc</li>
                                                    <li>confidence_level (Mức độ tin cậy) - Bắt buộc</li>
                                                    <li>autograph (Bút tích) - Bắt buộc</li>
                                                    <li>format (Tình trạng vật lý) - Bắt buộc</li>
                                                </ul>
                                            </div>

                                            <form action="{{ route('documents.import') }}" method="POST" enctype="multipart/form-data">
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

            @include('backend.dashboard.component.footer')
        </div>
    </div>

    @include('backend.dashboard.component.script')
</body>
</html>

@push('styles')
<style>
.form-horizontal .control-label {
    text-align: left;
}

.nav-tabs {
    margin-bottom: 20px;
}

.tab-content {
    padding: 20px 0;
}

.alert-info {
    background-color: #f3f6ff;
    border-color: #d1deff;
}

.alert-info ul {
    margin-bottom: 0;
    padding-left: 20px;
}

.form-control-file {
    padding: 10px 0;
}
</style>
@endpush 