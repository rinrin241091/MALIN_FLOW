@extends('backend.dashboard.layout')

@section('title', 'Quản lý danh mục - Phông chỉnh lý')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Quản lý danh mục</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
            <li class="active">
                <strong>Phông chỉnh lý</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Danh sách phông chỉnh lý</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12 m-b-xs">
                            <form method="GET" action="{{ route('category.fonds') }}" class="form-inline">
                                <div class="form-group m-l-sm">
                                    <label for="search">Nhập từ khóa bạn muốn tìm kiếm</label>
                                    <input type="text" name="search" id="search" class="form-control m-l-sm" placeholder="Tìm kiếm theo tên hoặc mã..." value="{{ request('search') }}">
                                </div>
                                <button type="submit" class="btn btn-primary m-l-sm">Tìm kiếm</button>
                                <a href="{{ route('category.fonds.create') }}" class="btn btn-danger m-l-sm">Thêm mới phông</a>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">STT</th>
                                    <th class="text-center">Tên phông</th>
                                    <th class="text-center">Mã định danh</th>
                                    <th class="text-center">Mô tả</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($fonds) && $fonds->count() > 0)
                                    @foreach($fonds as $key => $fond)
                                        <tr>
                                            <td class="text-center">
                                                {{ ($fonds->currentPage() - 1) * $fonds->perPage() + $key + 1 }}
                                            </td>
                                            <td class="text-center">
                                                {{ $fond->name }}
                                            </td>
                                            <td class="text-center">
                                                {{ $fond->code }}
                                            </td>
                                            <td class="text-center">
                                                {{ $fond->description ?? 'N/A' }}
                                            </td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                                <form action="#" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa phông này?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">Không tìm thấy phông nào.</td>
                                    </tr>    
                                @endif
                            </tbody>
                        </table>
                        @if(isset($fonds) && $fonds->hasPages())
                            {{ $fonds->appends(['search' => request('search')])->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection