<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        @if(auth()->check() && auth()->user()->image)
            <img src="{{ asset(auth()->user()->image) }}" class="img-circle elevation-2" alt="{{ auth()->user()->name }}" style="width: 30px; height: 30px;">
        @else
            <img src="{{ asset('LOGO/LOGO.png') }}" class="img-circle elevation-2" alt="Default Logo" style="width: 30px; height: 30px;">
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <!-- ... existing code ... -->
    </div>
</li> 