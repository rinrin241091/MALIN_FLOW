<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MALIN FLOW - Phần mềm thi công chỉnh lý tài liệu</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<link rel="stylesheet" href="{{ asset('backend/css/category.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<!-- Thêm CSS cho toastr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<body>
    <!-- Header -->
<header class="bg-light shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-light container">
        <a class="navbar-brand" href="#"><strong>MALIN FLOW</strong></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('backend.home') }}">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="#features">Tính năng</a></li>
                <li class="nav-item"><a class="nav-link" href="#benefits">Lợi ích</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Báo giá</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Liên hệ</a></li>
                @auth
                    @can('view dashboard')
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard.index') }}">DashBoard</a></li>
                    @endcan
                    @can('view users')
                        <li class="nav-item"><a class="nav-link" href="{{ route('user.index')}}">Quản lý người dùng</a></li>
                    @endcan
                @endauth
            </ul>
            <div class="d-flex align-items-center">
                @guest
                <a href="{{ route('auth.admin') }}" class="btn btn-outline-primary me-2">Đăng nhập</a>
                @else
                    <!-- Dropdown menu cho người dùng đã đăng nhập -->
                    <div class="dropdown">
                        <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (Auth::user()->image)
                                <img src="{{ asset('avatars/' . Auth::user()->image) }}" alt="Avatar" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('settings') }}">{{ __('Cài đặt') }}</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('auth.logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Đăng xuất') }}
                                </a>
                                <form id="logout-form" action="{{ route('auth.logout') }}"  style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </nav>
</header>
</body>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3>Danh sách mục lục</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12 m-b-xs">
                            <form method="GET" action="{{ route('categories.user-list') }}" class="form-inline">
                                <div class="form-group m-l-sm">
                                    <input type="text" name="search" id="search" class="form-control m-l-sm" 
                                           placeholder="Tìm kiếm theo tên hoặc mã..." value="{{ request('search') }}">
                                </div>
                                <button type="submit" class="btn btn-primary m-l-sm">Tìm kiếm</button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">STT</th>
                                    <th class="text-center">Tên phông</th>
                                    <th class="text-center">Tên mục lục</th>
                                    <th class="text-center">Mã</th>
                                    <th class="text-center">Mô tả</th>
                                    <th class="text-center">Ngày tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($categories) && $categories->count() > 0)
                                    @foreach($categories as $key => $category)
                                        <tr>
                                            <td class="text-center">
                                                {{ ($categories->currentPage() - 1) * $categories->perPage() + $key + 1 }}
                                            </td>
                                            <td class="text-center">
                                                {{ $category->fond->name ?? 'N/A' }}
                                            </td>
                                            <td class="text-center">
                                                {{ $category->name }}
                                            </td>
                                            <td class="text-center">
                                                {{ $category->code }}
                                            </td>
                                            <td class="text-center">
                                                {{ $category->description ?? 'N/A' }}
                                            </td>
                                            <td class="text-center">
                                                {{ $category->created_at->format('d/m/Y H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">Không có dữ liệu</td>
                                    </tr>    
                                @endif
                            </tbody>
                        </table>
                        @if(isset($categories) && $categories->hasPages())
                            {{ $categories->appends(['search' => request('search')])->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  
<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<!-- Custom JS -->
<script src="resoures/js/scripts.js"></script>
@push('styles')
<style>
    .breadcrumb {
        background-color: #f8f9fa;
        padding: 0.75rem 1rem;
        border-radius: 0.25rem;
    }
    .table th {
        background-color: #f8f9fa;
    }
    .pagination {
        margin-bottom: 0;
    }
</style>
@endpush