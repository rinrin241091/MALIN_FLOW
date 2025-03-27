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
                                    <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="Avatar" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
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

    <!-- Hero Section -->
    <section class="hero-section text-center py-5">
        <div class="container">
            <h1 class="display-4 fw-bold">Quản lý tài liệu thông minh với MALIN FLOW</h1>
            <p class="lead my-4">Số hóa và tự động hóa quy trình chỉnh lý tài liệu, giúp tiết kiệm thời gian, chi phí và nâng cao hiệu quả quản lý.</p>
            @guest
                <a href="{{ route('auth.login') }}" class="btn btn-primary">Dùng thử ngay</a>
            @endguest
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Tính năng nổi bật</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-users fa-3x mb-3 text-primary"></i>
                            <h5 class="card-title">Quản lý người dùng và bảo mật</h5>
                            <p class="card-text">Phân quyền linh hoạt, bảo mật đa lớp với mã hóa MD5.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-tags fa-3x mb-3 text-primary"></i>
                            <h5 class="card-title">Quản lý danh mục</h5>
                            <p class="card-text">Tự động gán mã định danh theo quy định Bộ Nội Vụ.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-box fa-3x mb-3 text-primary"></i>
                            <h5 class="card-title">Quản lý kho lưu trữ</h5>
                            <p class="card-text">Quản lý tập trung giá, kệ, hộp lưu trữ, tối ưu không gian.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-search fa-3x mb-3 text-primary"></i>
                            <h5 class="card-title">Tìm kiếm thông minh</h5>
                            <p class="card-text">Tìm kiếm nhanh chóng, chính xác với nhiều tiêu chí lọc.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-file-import fa-3x mb-3 text-primary"></i>
                            <h5 class="card-title">Biên mục và nhập liệu</h5>
                            <p class="card-text">Nhập liệu từ Excel, biên mục trực quan, dễ sử dụng.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-chart-bar fa-3x mb-3 text-primary"></i>
                            <h5 class="card-title">Báo cáo và thống kê</h5>
                            <p class="card-text">Dashboard trực quan, báo cáo đa dạng, cảnh báo hết hạn.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Lợi ích khi sử dụng MALIN FLOW</h2>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-check-circle fa-2x text-primary me-3"></i>
                        <div>
                            <h5>Nâng cao hiệu quả công việc</h5>
                            <p>Tự động hóa quy trình chỉnh lý, giảm thời gian và công sức.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-check-circle fa-2x text-primary me-3"></i>
                        <div>
                            <h5>Tiết kiệm chi phí</h5>
                            <p>Giảm chi phí nhân công, in ấn và lưu trữ tài liệu.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-check-circle fa-2x text-primary me-3"></i>
                        <div>
                            <h5>Đảm bảo an toàn thông tin</h5>
                            <p>Bảo mật đa lớp, lưu trữ tập trung, sao lưu định kỳ.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-check-circle fa-2x text-primary me-3"></i>
                        <div>
                            <h5>Tối ưu hóa quy trình</h5>
                            <p>Quản lý tài liệu khoa học, tra cứu nhanh chóng.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section text-center py-5 bg-primary text-white">
        <div class="container">
            @guest
                <h2 class="mb-4">Sẵn sàng số hóa tài liệu của bạn?</h2>
                <p class="lead mb-4">Dùng thử MALIN FLOW ngay hôm nay để trải nghiệm giải pháp quản lý tài liệu tối ưu!</p>
                <a href="/register" class="btn btn-light btn-lg">Dùng thử miễn phí</a>
            @endguest
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>MALIN FLOW</h5>
                    <p>Giải pháp quản lý tài liệu thông minh cho doanh nghiệp hiện đại.</p>
                    <p>Email: tudangm10@gmail.com</p>
                    <p>Phone: 0347259766</p>
                </div>
                <div class="col-md-4">
                    <h5>Liên kết nhanh</h5>
                    <ul class="list-unstyled">
                        <li><a href="#features" class="text-white">Tính năng</a></li>
                        <li><a href="#benefits" class="text-white">Lợi ích</a></li>
                        <li><a href="#" class="text-white">Liên hệ</a></li>
                        <li><a href="#" class="text-white">Chính sách bảo mật</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Kết nối với chúng tôi</h5>
                    <a href="https://www.facebook.com/tu.ang.282472/" class="text-white me-2"><i class="fab fa-facebook fa-2x"></i></a>
                    <a href="#" class="text-white me-2"><i class="fab fa-linkedin fa-2x"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-twitter fa-2x"></i></a>
                </div>
            </div>
            <div class="text-center mt-4">
                <p>© 2025 MALIN FLOW. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="resoures/js/scripts.js"></script>
</body>
</html>