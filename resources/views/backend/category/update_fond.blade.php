<link rel="stylesheet" href="{{ asset('backend/css/category.css') }}">
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Quản lý danh mục</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
            <li>
                <a href="{{ route('category.fonds') }}">Danh sách Phông</a>
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
                    <h5>Chỉnh sửa Phông chỉnh lý</h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="{{ route('category.updateFond', $fond->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Tên Phông <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $fond->name) }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="code">Mã Phông <span class="text-danger">*</span></label>
                            <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $fond->code) }}" required>
                            @error('code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $fond->description) }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="province_id">Tỉnh/Thành phố</label>
                            <select class="form-control" id="province_id" name="province_id">
                                <option value="">Chọn tỉnh/thành phố</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->province_id }}" 
                                        {{ old('province_id', $fond->province_id) == $province->province_id ? 'selected' : '' }}>
                                        {{ $province->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="district_id">Quận/Huyện</label>
                            <select class="form-control" id="district_id" name="district_id">
                                <option value="">Chọn quận/huyện</option>
                                @if($fond->district_id)
                                    @foreach($districts as $district)
                                        <option value="{{ $district->district_id }}" 
                                            {{ old('district_id', $fond->district_id) == $district->district_id ? 'selected' : '' }}>
                                            {{ $district->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="wards_id">Phường/Xã</label>
                            <select class="form-control" id="wards_id" name="wards_id">
                                <option value="">Chọn phường/xã</option>
                                @if($fond->wards_id)
                                    @foreach($wards as $ward)
                                        <option value="{{ $ward->wards_id }}" 
                                            {{ old('wards_id', $fond->wards_id) == $ward->wards_id ? 'selected' : '' }}>
                                            {{ $ward->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="address">Địa chỉ chi tiết</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $fond->address) }}">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
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

/* Style cho các trường disabled */
input:disabled, 
select:disabled, 
textarea:disabled {
    background-color: #e9ecef !important;
    cursor: not-allowed;
}

button:disabled {
    cursor: not-allowed;
    opacity: 0.65;
}

/* Style cho label có dấu sao (*) */
.required-field {
    position: relative;
}

.required-field::after {
    content: '*';
    color: red;
    margin-left: 4px;
}

.select2-container--default.select2-container--disabled .select2-selection--single {
    background-color: #e9ecef !important;
    cursor: not-allowed;
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/category-validation.js') }}"></script>
<script>
$(document).ready(function() {
    // Xử lý khi chọn tỉnh/thành phố
    $('#province_id').change(function() {
        var provinceId = $(this).val();
        if(provinceId) {
            $.get('{{ url("/api/district") }}/' + provinceId, function(data) {
                var html = '<option value="">Chọn quận/huyện</option>';
                data.forEach(function(district) {
                    html += `<option value="${district.district_id}">${district.name}</option>`;
                });
                $('#district_id').html(html);
                $('#wards_id').html('<option value="">Chọn phường/xã</option>');
            });
        } else {
            $('#district_id').html('<option value="">Chọn quận/huyện</option>');
            $('#wards_id').html('<option value="">Chọn phường/xã</option>');
        }
    });

    // Xử lý khi chọn quận/huyện
    $('#district_id').change(function() {
        var districtId = $(this).val();
        if(districtId) {
            $.get('{{ url("/api/ward") }}/' + districtId, function(data) {
                var html = '<option value="">Chọn phường/xã</option>';
                data.forEach(function(ward) {
                    html += `<option value="${ward.wards_id}">${ward.name}</option>`;
                });
                $('#wards_id').html(html);
            });
        } else {
            $('#wards_id').html('<option value="">Chọn phường/xã</option>');
        }
    });
});
</script>
@endpush