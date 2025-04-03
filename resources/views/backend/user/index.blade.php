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
                    
                    @include('backend.user.component.tables.tableDashboard')
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