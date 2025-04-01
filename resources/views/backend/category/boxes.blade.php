<link rel="stylesheet" href="{{ asset('backend/css/category.css') }}">
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Quản lý danh mục</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
            <li class="active">
                <strong>Hộp trên kệ</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Danh sách hộp trên kệ</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12 m-b-xs">
                            <form method="GET" action="{{ route('category.boxes') }}" class="form-inline">
                                <div class="form-group">
                                    <label for="shelf_id">Chọn Kệ</label>
                                    <select name="shelf_id" id="shelf_id" class="form-control m-l-sm">
                                        <option value="">Tất cả</option>
                                        @foreach($shelves as $shelf)
                                            <option value="{{ $shelf->id }}" {{ $shelf_id == $shelf->id ? 'selected' : '' }}>{{ $shelf->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group m-l-sm">
                                    <label for="search">Nhập từ khóa bạn muốn tìm kiếm</label>
                                    <input type="text" name="search" id="search" class="form-control m-l-sm" placeholder="Tìm kiếm theo tên hoặc mã..." value="{{ request('search') }}">
                                </div>
                                <button type="submit" class="btn btn-primary m-l-sm">Tìm kiếm</button>
                                <a href="{{ route('category.boxes.create') }}" class="btn btn-danger m-l-sm">Thêm mới hộp</a>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">STT</th>
                                    <th class="text-center">Kệ</th>
                                    <th class="text-center">Tên hộp</th>
                                    <th class="text-center">Mã định danh</th>
                                    <th class="text-center">Sức chứa</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($boxes) && $boxes->count() > 0)
                                    @foreach($boxes as $key => $box)
                                        <tr>
                                            <td class="text-center">
                                                {{ ($boxes->currentPage() - 1) * $boxes->perPage() + $key + 1 }}
                                            </td>
                                            <td class="text-center">
                                                {{ $box->shelf->name }}
                                            </td>
                                            <td class="text-center">
                                                {{ $box->name }}
                                            </td>
                                            <td class="text-center">
                                                {{ $box->code }}
                                            </td>
                                            <td class="text-center">
                                                {{ $box->capacity ?? 'N/A' }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('category.editBox', $box->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                                <form action="{{ route('category.destroyBox', ['id' => $box->id])}}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa hộp này?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">Không tìm thấy hộp nào.</td>
                                    </tr>    
                                @endif
                            </tbody>
                        </table>
                        @if(isset($boxes) && $boxes->hasPages())
                            {{ $boxes->appends(['search' => request('search'), 'shelf_id' => $shelf_id])->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

