<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('backend/css/category.css') }}">
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Quản lý danh mục</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
            <li>
                <a href="{{ route('category.fonds') }}">Phông chỉnh lý</a>
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
                    <h5>Thêm mới phông chỉnh lý</h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="{{ route('category.fonds.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên phông <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name')
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
                            <label for="province_id">Tỉnh/Thành phố</label>
                            <select name="province_id" id="province_id" class="form-control">
                                <option value="">Chọn tỉnh/thành phố</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->province_id }}" {{ old('province_id') == $province->province_id ? 'selected' : '' }}>
                                        {{ $province->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('province_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="form-group">
                            <label for="district_id">Quận/Huyện</label>
                            <select name="district_id" id="district_id" class="form-control">
                                <option value="">Chọn quận/huyện</option>
                            </select>
                            @error('district_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="form-group">
                            <label for="wards_id">Phường/Xã</label>
                            <select name="wards_id" id="wards_id" class="form-control">
                                <option value="">Chọn phường/xã</option>
                            </select>
                            @error('wards_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">Địa chỉ chi tiết</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                            <a href="{{ route('category.fonds') }}" class="btn btn-default">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Thêm style cho active menu item */
.nav-item.active,
.nav-item:hover {
    background-color: #1ab394;
}

.nav-item.active a,
.nav-item:hover a {
    color: white !important;
}

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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Thêm CSRF token vào tất cả AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Xử lý khi chọn tỉnh/thành phố
    $('#province_id').on('change', function() {
        var provinceId = $(this).val();
        console.log('Selected province:', provinceId);
        
        if(provinceId) {
            $.ajax({
                url: '/category/districts/' + provinceId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if(data && data.length > 0) {
                        let html = '<option value="">Chọn quận/huyện</option>';
                        data.forEach(function(district) {
                            html += `<option value="${district.district_id}">${district.name}</option>`;
                        });
                        $('#district_id').html(html).prop('disabled', false);
                    } else {
                        $('#district_id').html('<option value="">Không có quận/huyện</option>').prop('disabled', true);
                    }
                    // Reset wards dropdown
                    $('#wards_id').html('<option value="">Chọn phường/xã</option>').prop('disabled', true);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading districts:', error);
                    alert('Có lỗi xảy ra khi tải danh sách quận/huyện');
                }
            });
        } else {
            $('#district_id').html('<option value="">Chọn quận/huyện</option>').prop('disabled', true);
            $('#wards_id').html('<option value="">Chọn phường/xã</option>').prop('disabled', true);
        }
    });

    // Xử lý khi chọn quận/huyện
    $('#district_id').on('change', function() {
        var districtId = $(this).val();
        console.log('Selected district:', districtId);
        
        if(districtId) {
            $.ajax({
                url: '/category/wards/' + districtId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if(data && data.length > 0) {
                        let html = '<option value="">Chọn phường/xã</option>';
                        data.forEach(function(ward) {
                            html += `<option value="${ward.wards_id}">${ward.name}</option>`;
                        });
                        $('#wards_id').html(html).prop('disabled', false);
                    } else {
                        $('#wards_id').html('<option value="">Không có phường/xã</option>').prop('disabled', true);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading wards:', error);
                    alert('Có lỗi xảy ra khi tải danh sách phường/xã');
                }
            });
        } else {
            $('#wards_id').html('<option value="">Chọn phường/xã</option>').prop('disabled', true);
        }
    });
});
</script>
@endpush