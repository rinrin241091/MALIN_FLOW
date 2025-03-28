<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>MALIN FLOW| Login</title>

    <link href="{{asset('backend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('backend/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('backend/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('backend/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('backend/css/custom.css')}}" rel="stylesheet">


</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">BPO</h1>

            </div>
            <h3>Hệ thống quản lý chỉnh lý tài liệu</h3>
            
            <h4>ĐĂNG NHẬP HỆ THỐNG</h4>

            <!-- Hiển thị thông báo lỗi từ session -->
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Hiển thị thông báo thành công từ session -->
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <form  method="post" class="m-t" role="form" action="{{route('auth.login')}}">
                @csrf
                <div class="form-group">
                    <input 
                        name="email" 
                        type="text" 
                        class="form-control" 
                        placeholder="Email người dùng" 
                        value="{{old('email')}}" 
                    >
                    @if ($errors->has('email'))
                        <p class="error-mess">
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                   
                </div>
               
                <div class="form-group">
                    <input 
                        name="password" 
                        type="password" 
                        class="form-control" 
                        placeholder="Mật khẩu" 
                    >
                    @if ($errors->has('password'))
                        <p class="error-mess">
                            {{ $errors->first('password') }}
                        </p>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Đăng nhập</button>

                <a href="#"><small>Quên mật khẩu?</small></a>
            </form>
            <p class="m-t"> <small>Bản quyền thuộc công ty BPO&copy; 2025</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
