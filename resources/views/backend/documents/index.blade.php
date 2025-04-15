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
                        <li class="active">
                            <strong>Danh sách tài liệu</strong>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Danh sách tài liệu</h5>
                                
                            </div>
                            <div class="ibox-content">
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissable">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissable">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-sm-12 m-b-xs">
                                        <form method="GET" action="{{ route('documents.index') }}" class="form-inline">
                                            <div class="form-group m-l-sm">
                                                <label for="search">Nhập từ khóa bạn muốn tìm kiếm</label>
                                                <input type="text" name="search" id="search" class="form-control m-l-sm" placeholder="Tìm kiếm theo tên hoặc mã..." value="{{ request('search') }}">
                                            </div>
                                            <button type="submit" class="btn btn-primary m-l-sm">Tìm kiếm</button>
                                            <a href="{{ route('documents.create') }}" class="btn btn-danger m-l-sm">Thêm mới tài liệu</a>
                                        </form>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Mã định danh</th>
                                                <th>Tiêu đề</th>
                                                <th>Ngày văn bản</th>
                                                <th>Số văn bản</th>
                                                <th>Cơ quan ban hành</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($documents as $key => $document)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $document->doc_code }}</td>
                                                <td>{{ $document->subject }}</td>
                                                <td>{{ $document->issued_date->format('d/m/Y') }}</td>
                                                <td>{{ $document->code_number }}</td>
                                                <td>{{ $document->organ_name }}</td>
                                                <td>
                                                    <a href="{{ route('documents.edit', $document->id) }}" class="btn btn-success">
                                                        <i class="fa fa-edit"></i> 
                                                    </a>
                                                    <form action="{{ route('documents.destroy', $document->id) }}" method="POST" style="display: inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa tài liệu này?')">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        {{ $documents->links() }}
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
.table > thead > tr > th {
    text-align: center;
    vertical-align: middle;
}
.btn-xs {
    margin: 2px;
}
</style>
@endpush 