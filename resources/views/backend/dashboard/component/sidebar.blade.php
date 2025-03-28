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
            <li class="nav-item"><a class="nav-link" href="{{ route('backend.home') }}">HOMEPAGE</a></li>
            <li class="active">
                <a href="{{ route('dashboard.index') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Quản lý thành viên</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="index.html">Quản lý nhóm thành viên</a></li>
                    <li><a href="{{ route('user.index') }}">Quản lý thành viên</a></li>
                </ul>
            </li>
            <li class="{{ request()->routeIs('category.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.index') }}"><i class="fa fa-list"></i> <span class="nav-label">Quản lý danh mục</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse {{ request()->routeIs('category.*') ? 'in' : '' }}">
                    <li class="{{ request()->routeIs('category.fonds') ? 'active' : '' }}">
                        <a href="{{ route('category.fonds') }}">Phông chỉnh lý</a>
                    </li>
                    <li class="{{ request()->routeIs('category.categories') ? 'active' : '' }}">
                        <a href="{{ route('category.categories') }}">Danh mục tài liệu</a>
                    </li>
                    <li class="{{ request()->routeIs('category.warehouses') ? 'active' : '' }}">
                        <a href="{{ route('category.warehouses') }}">Kho lưu trữ</a>
                    </li>
                    <li class="{{ request()->routeIs('category.shelves') ? 'active' : '' }}">
                        <a href="{{ route('category.shelves') }}">Kệ trong kho</a>
                    </li>
                    
                </ul>
            </li>
            
        </ul>

    </div>
</nav>

