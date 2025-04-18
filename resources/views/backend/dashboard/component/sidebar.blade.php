<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="avatar"> 
                    @if(auth()->check() && auth()->user()->image)
                        <img alt="{{ auth()->user()->name }}" class="img-circle" src="{{ asset(ltrim(auth()->user()->image, '/')) }}" width="60" height="60"/>
                    @else
                        <img alt="Default Logo" class="img-circle" src="{{ asset('LOGO/LOGO.png') }}" width="60" height="60"/>
                    @endif
                </div>
                <div class="logo-element">
                    MALIN FLOW
                </div>
            </li>
            <li>
                <a href="{{ route('backend.home') }}"><i class="fa fa-home"></i> <span class="nav-label">HOMEPAGE</span></a>
            </li>
            <li class="{{ request()->routeIs('user.*') ? 'active' : '' }}">
                <a href="javascript:void(0)"><i class="fa fa-users"></i> <span class="nav-label">Quản lý thành viên</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse {{ request()->routeIs('user.*') ? 'in' : '' }}">
                    <li><a href="index.html">Quản lý nhóm thành viên</a></li>
                    <li class="{{ request()->routeIs('user.index') ? 'active' : '' }}">
                        <a href="{{ route('user.index') }}">Quản lý thành viên</a>
                    </li>
                </ul>
            </li>
            <li class="{{ request()->routeIs('category.*') ? 'active' : '' }}">
                <a href="javascript:void(0)"><i class="fa fa-list"></i> <span class="nav-label">Quản lý danh mục</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse {{ request()->routeIs('category.*') ? 'in' : '' }}">
                    <li class="{{ request()->routeIs('category.fonds') ? 'active' : '' }}">
                        <a href="{{ route('category.fonds') }}">Phông chỉnh lý</a>
                    </li>
                    <li class="{{ request()->routeIs('category.warehouses') ? 'active' : '' }}">
                        <a href="{{ route('category.warehouses') }}">Kho</a>
                    </li>
                    <li class="{{ request()->routeIs('category.shelves') ? 'active' : '' }}">
                        <a href="{{ route('category.shelves') }}">Kệ</a>
                    </li>
                    <li class="{{ request()->routeIs('category.boxes') ? 'active' : '' }}">
                        <a href="{{ route('category.boxes') }}">Hộp</a>
                    </li>
                    <li class="{{ request()->routeIs('category.categories') ? 'active' : '' }}">
                        <a href="{{ route('category.categories') }}">Danh mục tài liệu</a>
                    </li>   
                </ul>
            </li>
            <li class="{{ request()->routeIs('documents.*') ? 'active' : '' }}">
                <a href="javascript:void(0)"><i class="fa fa-file-text"></i> <span class="nav-label">Quản lý tài liệu</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse {{ request()->routeIs('documents.*') ? 'in' : '' }}">
                    <li class="{{ request()->routeIs('documents.index') ? 'active' : '' }}">
                        <a href="{{ route('documents.index') }}">Danh sách tài liệu</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

