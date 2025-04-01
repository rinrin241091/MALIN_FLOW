<!DOCTYPE html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @include('backend.dashboard.component.head')
</head>
<body>
    <div id="wrapper">
        @include('backend.dashboard.component.sidebar')
        <div id="page-wrapper" class="gray-bg">
            @include('backend.dashboard.component.nav')
            @include($template)
            @yield('content')
            @include('backend.dashboard.component.footer')
        </div>
    </div>
    @include('backend.dashboard.component.script')
</body>
</html>
