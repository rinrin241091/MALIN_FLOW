<link rel="stylesheet" href="{{ asset('backend/css/category.css') }}">
<!-- Sử dụng jQuery local, thử phiên bản 1.12.4 -->
<script src="{{ asset('js/jquery-1.12.4.min.js') }}"></script>

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
                            <label for="province_id">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                            <select name="province_id" id="province_id" class="form-control" required>
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
                            <label for="district_id">Quận/Huyện <span class="text-danger">*</span></label>
                            <select name="district_id" id="district_id" class="form-control" required>
                                <option value="">Chọn quận/huyện</option>
                            </select>
                            @error('district_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="form-group">
                            <label for="ward_id">Phường/Xã <span class="text-danger">*</span></label>
                            <select name="ward_id" id="ward_id" class="form-control" required>
                                <option value="">Chọn phường/xã</option>
                            </select>
                            @error('ward_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">Địa chỉ chi tiết</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Lưu</button>
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
<script>
console.log('[DEBUG] Script is loaded!');
console.log('[DEBUG] jQuery version:', typeof jQuery !== 'undefined' ? jQuery.fn.jquery : 'jQuery not loaded');

// Sử dụng jQuery.noConflict() để tránh xung đột
var $j = jQuery.noConflict();
$j(document).ready(function() {
    console.log('[DEBUG] jQuery is loaded and ready! Version:', $j.fn.jquery);

    // Khi chọn tỉnh/thành phố
    $j('#province_id').on('change', function() {
        var provinceId = $j(this).val();
        console.log('[DEBUG] Province ID changed to:', provinceId);

        if(provinceId) {
            var districtUrl = '{{ url("/api/district") }}/' + provinceId;
            console.log('[DEBUG] Making AJAX call to fetch districts. URL:', districtUrl);

            $j.ajax({
                url: districtUrl,
                type: 'GET',
                success: function(data) {
                    console.log('[DEBUG] Received districts data:', data);

                    $j('#district_id').empty();
                    $j('#district_id').append('<option value="">Chọn quận/huyện</option>');

                    if (Array.isArray(data)) {
                        console.log('[DEBUG] Data is an array. Total districts:', data.length);
                        $j.each(data, function(key, value) {
                            console.log('[DEBUG] Adding district - ID:', value.district_id, 'Name:', value.name);
                            $j('#district_id').append('<option value="' + value.district_id + '">' + value.name + '</option>');
                        });
                    } else {
                        console.error('[ERROR] Districts data is not an array:', data);
                    }

                    $j('#ward_id').empty();
                    $j('#ward_id').append('<option value="">Chọn phường/xã</option>');
                    console.log('[DEBUG] Cleared wards dropdown');
                },
                error: function(xhr, status, error) {
                    console.error('[ERROR] Error fetching districts. Status:', status, 'Error:', error);
                    console.error('[ERROR] Response:', xhr.responseText);
                    console.error('[ERROR] Status Code:', xhr.status);
                }
            });
        } else {
            $j('#district_id').empty();
            $j('#district_id').append('<option value="">Chọn quận/huyện</option>');
            $j('#ward_id').empty();
            $j('#ward_id').append('<option value="">Chọn phường/xã</option>');
            console.log('[DEBUG] Province ID is empty. Reset districts and wards dropdowns');
        }
    });

    // Khi chọn quận/huyện
    $j('#district_id').on('change', function() {
        var districtId = $j(this).val();
        console.log('[DEBUG] District ID changed to:', districtId);

        if(districtId) {
            var wardUrl = '{{ url("/api/ward") }}/' + districtId;
            console.log('[DEBUG] Making AJAX call to fetch wards. URL:', wardUrl);

            $j.ajax({
                url: wardUrl,
                type: 'GET',
                success: function(data) {
                    console.log('[DEBUG] Received wards data:', data);

                    $j('#ward_id').empty();
                    $j('#ward_id').append('<option value="">Chọn phường/xã</option>');

                    if (Array.isArray(data)) {
                        console.log('[DEBUG] Wards data is an array. Total wards:', data.length);
                        $j.each(data, function(key, value) {
                            console.log('[DEBUG] Adding ward - ID:', value.wards_id, 'Name:', value.name);
                            $j('#ward_id').append('<option value="' + value.wards_id + '">' + value.name + '</option>');
                        });
                    } else {
                        console.error('[ERROR] Wards data is not an array:', data);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('[ERROR] Error fetching wards. Status:', status, 'Error:', error);
                    console.error('[ERROR] Response:', xhr.responseText);
                    console.error('[ERROR] Status Code:', xhr.status);
                }
            });
        } else {
            $j('#ward_id').empty();
            $j('#ward_id').append('<option value="">Chọn phường/xã</option>');
            console.log('[DEBUG] District ID is empty. Reset wards dropdown');
        }
    });
});
</script>
@endpush