<link rel="stylesheet" href="{{ asset('backend/css/category.css') }}">
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Quản lý danh mục</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
            <li class="active">
                <strong>Kệ trong kho</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Danh sách kệ trong kho</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12 m-b-xs">
                            <form method="GET" action="{{ route('category.shelves') }}" class="form-inline">
                                <div class="form-group">
                                    <label for="warehouse_id">Chọn kho</label>
                                    <select name="warehouse_id" id="warehouse_id" class="form-control m-l-sm">
                                        <option value="">Tất cả</option>
                                        @foreach($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}" {{ $warehouse_id == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group m-l-sm">
                                    <label for="search">Nhập từ khóa bạn muốn tìm kiếm</label>
                                    <input type="text" name="search" id="search" class="form-control m-l-sm" placeholder="Tìm kiếm theo tên hoặc mã..." value="{{ request('search') }}">
                                </div>
                                <button type="submit" class="btn btn-primary m-l-sm">Tìm kiếm</button>
                                <a href="{{ route('category.shelves.create') }}" class="btn btn-danger m-l-sm">Thêm mới kệ</a>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">STT</th>
                                    <th class="text-center">Kho</th>
                                    <th class="text-center">Tên kệ</th>
                                    <th class="text-center">Mã định danh</th>
                                    <th class="text-center">Sức chứa</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($shelves) && $shelves->count() > 0)
                                    @foreach($shelves as $key => $shelf)
                                        <tr>
                                            <td class="text-center">
                                                {{ ($shelves->currentPage() - 1) * $shelves->perPage() + $key + 1 }}
                                            </td>
                                            <td class="text-center">
                                                {{ $shelf->warehouse->name }}
                                            </td>
                                            <td class="text-center">
                                                {{ $shelf->name }}
                                            </td>
                                            <td class="text-center">
                                                {{ $shelf->code }}
                                            </td>
                                            <td class="text-center">
                                                {{ $shelf->capacity ?? 'N/A' }}
                                            </td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                                <form action="#" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa kệ này?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">Không tìm thấy kệ nào.</td>
                                    </tr>    
                                @endif
                            </tbody>
                        </table>
                        @if(isset($shelves) && $shelves->hasPages())
                            {{ $shelves->appends(['search' => request('search'), 'warehouse_id' => $warehouse_id])->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>