<!DOCTYPE html>
<html>
<header>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</header>
<head>
    
    @include('backend.dashboard.component.head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div id="wrapper">
        @include('backend.dashboard.component.sidebar')
        <div id="page-wrapper" class="gray-bg">
            @include('backend.dashboard.component.nav')
            @include($template)
        @include('backend.dashboard.component.footer')
        </div>
    </div>

    @include('backend.dashboard.component.script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>
</html>
