<link rel="stylesheet" href="{{ asset('backend/css/category.css') }}">
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Quản lý danh mục</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
            <li>
                <a href="{{ route('category.boxes') }}">Hộp trên kệ</a>
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
                    <h5>Thêm mới hộp trên kệ</h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="{{ route('category.boxes.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="shelf_id">Kệ trên kho <span class="text-danger">*</span></label>
                            <select name="shelf_id" id="shelf_id" class="form-control" required>
                                <option value="">Chọn kệ</option>
                                @foreach($shelves as $shelf)
                                    <option value="{{ $shelf->id }}" {{ old('shelf_id') == $shelf->id ? 'selected' : '' }}>
                                        {{ $shelf->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('shelf_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Tên hộp <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name')
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
                            <a href="{{ route('category.boxes') }}" class="btn btn-default">Hủy</a>
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
/* CSS cho disabled elements */
.disabled-input {
    background-color: #e9ecef !important;
    cursor: not-allowed;
    opacity: 0.65;
}

.disabled-button {
    opacity: 0.65;
    cursor: not-allowed;
}

/* CSS cho select phông khi chưa chọn */
select[required]:invalid {
    color: #999;
}

select[required] option[value=""] {
    color: #999;
}

select[required] option {
    color: #333;
}
</style>
@endpush

@push('scripts')
<!-- Thêm jQuery nếu chưa có -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Thêm Toastr nếu chưa có -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- File validation của chúng ta -->
<script src="{{ asset('backend/js/category-form-validation.js') }}"></script>
@endpush
