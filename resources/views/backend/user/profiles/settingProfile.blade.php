<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Cài đặt') }} - MALIN FLOW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container mt-5">
        <h1>{{ __('Cài đặt') }}</h1>

        <!-- Thông báo -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            <!-- Tabs -->
            <div class="col-md-3">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('settings') && !request()->has('tab') ? 'active' : '' }}" href="{{ route('settings') }}">{{ __('Chỉnh sửa hồ sơ') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->get('tab') == 'password' ? 'active' : '' }}" href="{{ route('settings', ['tab' => 'password']) }}">{{ __('Đổi mật khẩu') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->get('tab') == 'language' ? 'active' : '' }}" href="{{ route('settings', ['tab' => 'language']) }}">{{ __('Ngôn ngữ') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->get('tab') == 'privacy' ? 'active' : '' }}" href="{{ route('settings', ['tab' => 'privacy']) }}">{{ __('Quyền riêng tư') }}</a>
                    </li>
                </ul>
            </div>

            <!-- Nội dung của tab -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        @if (!request()->has('tab') || request()->get('tab') == 'profile')
                            <!-- Tab: Chỉnh sửa hồ sơ -->
                            <h3>{{ __('Chỉnh sửa hồ sơ') }}</h3>
                            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ __('Tên') }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('Email') }}</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">{{ __('Ảnh đại diện') }}</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                                    @if ($user->image)
                                        <img src="{{ asset('storage/' . $user->image) }}" alt="Avatar" class="mt-2 rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                    @endif
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>
                            </form>
                        @elseif (request()->get('tab') == 'password')
                            <!-- Tab: Đổi mật khẩu -->
                            <h3>{{ __('Đổi mật khẩu') }}</h3>
                            <form action="{{ route('settings.password') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">{{ __('Mật khẩu hiện tại') }}</label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">{{ __('Mật khẩu mới') }}</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">{{ __('Xác nhận mật khẩu mới') }}</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>
                            </form>
                        @elseif (request()->get('tab') == 'language')
                            <!-- Tab: Ngôn ngữ -->
                            <h3>{{ __('Ngôn ngữ') }}</h3>
                            <form action="{{ route('settings.language') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="language" class="form-label">{{ __('Chọn ngôn ngữ') }}</label>
                                    <select class="form-select" id="language" name="language">
                                        <option value="vi" {{ app()->getLocale() == 'vi' ? 'selected' : '' }}>{{ __('Tiếng Việt') }}</option>
                                        <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>{{ __('Tiếng Anh') }}</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>
                            </form>
                        @elseif (request()->get('tab') == 'privacy')
                            <!-- Tab: Quyền riêng tư -->
                            <h3>{{ __('Quyền riêng tư') }}</h3>
                            <form action="{{ route('settings.privacy') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="receive_emails" name="receive_emails" {{ $user->receive_emails ? 'checked' : '' }}>
                                        <label class="form-check-label" for="receive_emails">
                                            {{ __('Nhận thông báo qua email') }}
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route('backend.home') }}" class="btn btn-secondary mt-3">{{ __('Quay lại') }}</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>