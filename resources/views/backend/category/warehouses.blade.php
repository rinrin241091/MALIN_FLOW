<link rel="stylesheet" href="{{ asset('backend/css/category.css') }}">
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Quản lý danh mục</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
            <li class="active">
                <strong>Kho lưu trữ</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Danh sách kho lưu trữ</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12 m-b-xs">
                            <form method="GET" action="{{ route('category.warehouses') }}" class="form-inline">
                                <div class="form-group">
                                    <label for="fond_id">Chọn phông</label>
                                    <select name="fond_id" id="fond_id" class="form-control m-l-sm">
                                        <option value="">Tất cả</option>
                                        @foreach($fonds as $fond)
                                            <option value="{{ $fond->id }}" {{ $fond_id == $fond->id ? 'selected' : '' }}>{{ $fond->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group m-l-sm">
                                    <label for="search">Nhập từ khóa bạn muốn tìm kiếm</label>
                                    <input type="text" name="search" id="search" class="form-control m-l-sm" placeholder="Tìm kiếm theo tên hoặc mã..." value="{{ request('search') }}">
                                </div>
                                <button type="submit" class="btn btn-primary m-l-sm">Tìm kiếm</button>
                                <a href="{{ route('category.warehouses.create') }}" class="btn btn-danger m-l-sm">Thêm mới kho</a>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">STT</th>
                                    <th class="text-center">Phông</th>
                                    <th class="text-center">Tên kho</th>
                                    <th class="text-center">Mã định danh</th>
                                    <th class="text-center">Vị trí</th>
                                    <th class="text-center">Sức chứa</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($warehouses) && $warehouses->count() > 0)
                                    @foreach($warehouses as $key => $warehouse)
                                        <tr>
                                            <td class="text-center">
                                                {{ ($warehouses->currentPage() - 1) * $warehouses->perPage() + $key + 1 }}
                                            </td>
                                            <td class="text-center">
                                                {{ $warehouse->fond->name }}
                                            </td>
                                            <td class="text-center">
                                                {{ $warehouse->name }}
                                            </td>
                                            <td class="text-center">
                                                {{ $warehouse->code }}
                                            </td>
                                            <td class="text-center">
                                                {{ $warehouse->location ?? 'N/A' }}
                                            </td>
                                            <td class="text-center">
                                                {{ $warehouse->capacity ?? 'N/A' }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('category.editWarehouse', $warehouse->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                                <form action="{{ route('category.destroyWarehouse', ['id' => $warehouse->id])}}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa kho này?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">Không tìm thấy kho nào.</td>
                                    </tr>    
                                @endif
                            </tbody>
                        </table>
                        @if(isset($warehouses) && $warehouses->hasPages())
                            {{ $warehouses->appends(['search' => request('search'), 'fond_id' => $fond_id])->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>