<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="avatar"> 
                    <img alt="image" class="img-circle" src="{{ asset('/LOGO/LOGO.png') }}" width="60" height="60"/>
                </div>
                <div class="logo-element">
                    MALIN FLOW
                </div>
            </li>
            <li class="active">
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Quản lý thành viên</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="index.html">Quản lý nhóm thành viên</a></li>
                    <li><a href="{{ route('user.index') }}">Quản lý thành viên</a></li>
                </ul>
            </li>
        </ul>

    </div>
</nav>