<head>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Thêm CSS cho toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
                <!-- Hiển thị thông tin tổng số bản ghi -->
                <div class="summary">
                    Hiển thị {{ $users->firstItem() }} - {{ $users->lastItem() }} trong tổng số {{ $users->total() }} thành viên.
                </div>
                <!-- Hiển thị phân trang -->
                <div class="pagination">
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Thêm script cho toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>