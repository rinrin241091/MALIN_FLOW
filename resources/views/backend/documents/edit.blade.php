<!DOCTYPE html>
<html>
<head>
    @include('backend.dashboard.component.head')
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
                            <strong>Chỉnh sửa tài liệu</strong>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Chỉnh sửa tài liệu</h5>
                            </div>
                            <div class="ibox-content">
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('documents.update', $document->id) }}" class="form-horizontal">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Mã định danh <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="doc_code" class="form-control" required maxlength="25" value="{{ old('doc_code', $document->doc_code) }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Mã hồ sơ <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="file_code" class="form-control" required maxlength="13" value="{{ old('file_code', $document->file_code) }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Mã cơ quan <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="identifier" class="form-control" required maxlength="13" value="{{ old('identifier', $document->identifier) }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Mã phòng <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="organ_id" class="form-control" required maxlength="13" value="{{ old('organ_id', $document->organ_id) }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Mục lục số <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="number" name="file_catalog" class="form-control" required value="{{ old('file_catalog', $document->file_catalog) }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Ký hiệu hồ sơ <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="file_notation" class="form-control" required maxlength="20" value="{{ old('file_notation', $document->file_notation) }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">STT văn bản <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="number" name="doc_ordinal" class="form-control" required value="{{ old('doc_ordinal', $document->doc_ordinal) }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Loại văn bản <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="type_name" class="form-control" required maxlength="100" value="{{ old('type_name', $document->type_name) }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Số văn bản <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="code_number" class="form-control" required maxlength="11" value="{{ old('code_number', $document->code_number) }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Ký hiệu <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="code_notation" class="form-control" required maxlength="30" value="{{ old('code_notation', $document->code_notation) }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Ngày văn bản <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="date" name="issued_date" class="form-control" required value="{{ old('issued_date', $document->issued_date->format('Y-m-d')) }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Cơ quan ban hành <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="organ_name" class="form-control" required maxlength="200" value="{{ old('organ_name', $document->organ_name) }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Trích yếu <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <textarea name="subject" class="form-control" required maxlength="500" rows="3">{{ old('subject', $document->subject) }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Ngôn ngữ <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="language" class="form-control" required maxlength="100" value="{{ old('language', $document->language) }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Số trang <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="number" name="page_amount" class="form-control" required value="{{ old('page_amount', $document->page_amount) }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Ghi chú</label>
                                                <div class="col-sm-9">
                                                    <textarea name="description" class="form-control" maxlength="500" rows="2">{{ old('description', $document->description) }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Ký hiệu thông tin <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="infor_sign" class="form-control" required maxlength="30" value="{{ old('infor_sign', $document->infor_sign) }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Từ khóa <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="keyword" class="form-control" required maxlength="100" value="{{ old('keyword', $document->keyword) }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Chế độ sử dụng <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="mode" class="form-control" required maxlength="20" value="{{ old('mode', $document->mode) }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Mức độ tin cậy <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="confidence_level" class="form-control" required maxlength="30" value="{{ old('confidence_level', $document->confidence_level) }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Bút tích <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <textarea name="autograph" class="form-control" required maxlength="2000" rows="3">{{ old('autograph', $document->autograph) }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Tình trạng vật lý <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="format" class="form-control" required maxlength="50" value="{{ old('format', $document->format) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-2">
                                            <button class="btn btn-primary" type="submit">Cập nhật</button>
                                            <a class="btn btn-white" href="{{ route('documents.index') }}">Hủy</a>
                                        </div>
                                    </div>
                                </form>
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
</style>
@endpush