<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MALIN FLOW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">MALIN FLOW</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">{{ __('messages.home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ __('messages.features') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ __('messages.benefits') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ __('messages.pricing') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ __('messages.contact') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ __('messages.dashboard') }}</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="Avatar" class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">
                    <div class="dropdown">
                        <button class="btn btn-link text-dark text-decoration-none dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                            {{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('settings') }}">{{ __('messages.settings') }}</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('auth.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container my-5">
        <h1 class="text-center mb-4">{{ __('messages.smart_document_management') }}</h1>
        <p class="text-center lead">{{ __('messages.smart_document_management_desc') }}</p>
    </div>

    <!-- Features Section -->
    <div class="container my-5">
        <h2 class="text-center mb-4">{{ __('messages.featured_functions') }}</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-people-fill fs-1 text-primary mb-3"></i>
                        <h5 class="card-title">{{ __('messages.user_management') }}</h5>
                        <p class="card-text">{{ __('messages.user_management_desc') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-folder-fill fs-1 text-primary mb-3"></i>
                        <h5 class="card-title">{{ __('messages.category_management') }}</h5>
                        <p class="card-text">{{ __('messages.category_management_desc') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam-fill fs-1 text-primary mb-3"></i>
                        <h5 class="card-title">{{ __('messages.warehouse_management') }}</h5>
                        <p class="card-text">{{ __('messages.warehouse_management_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html> 