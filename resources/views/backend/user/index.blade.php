<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Thêm CSS cho toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<!-- Hiển thị thông báo toastr -->
@if (session('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
@endif

@if (session('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
@endif

<body>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>{{ config('apps.user.title') }}</h2>
            <ol class="breadcrumb" style="margin-bottom:10px;">
                <li> 
                    <a href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="active"><strong>{{ config('apps.user.title') }}</strong></li>
            </ol>
        </div>
    </div>

    <div class="row mt20">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{ config('apps.user.tableHeading') }}</h5>
                    @include('backend.user.component.toolboxes.toolboxDashboard')
                </div>
                <div class="ibox-content">
                    @include('backend.user.component.filters.filterDashboard')
                    
                    <!-- Form cho bulk actions -->
                    <form id="bulk-action-form" action="{{ route('user.bulkDelete') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="checkAll">
                                        </th>
                                        <th>STT</th>
                                        <th>Họ tên</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $key => $user)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="checkBoxItem" value="{{ $user->id }}">
                                        </td>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>
                                            @if($user->status)
                                                <span class="label label-primary">Hoạt động</span>
                                            @else
                                                <span class="label label-danger">Khóa</span>
                                            @endif
                                        </td>
                                        <td>
                                            @can('edit user')
                                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-xs">
                                                <i class="fa fa-edit"></i> Sửa
                                            </a>
                                            @endcan
                                            @can('delete user')
                                            <button type="button" class="btn btn-danger btn-xs delete-user" data-id="{{ $user->id }}">
                                                <i class="fa fa-trash"></i> Xóa
                                            </button>
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <span id="selected-count">Đã chọn: 0 thành viên</span>
                            </div>
                            <div class="col-md-6 text-right">
                                @can('delete user')
                                <button type="submit" id="bulk-delete-btn" class="btn btn-danger" disabled>
                                    <i class="fa fa-trash"></i> Xóa đã chọn
                                </button>
                                @endcan
                            </div>
                        </div>
                    </form>

                    <div class="summary">
                        Hiển thị {{ $users->firstItem() }} - {{ $users->lastItem() }} trong tổng số {{ $users->total() }} thành viên.
                    </div>
                    <div class="pagination">
                        {{ $users->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>