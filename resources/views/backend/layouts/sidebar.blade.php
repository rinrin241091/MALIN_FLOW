<!-- Category Management -->
<li class="nav-item">
    @if(auth()->user()->hasRole('admin'))
    <a href="{{ route('category.index') }}" class="nav-link {{ request()->routeIs('category.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-list"></i>
        <p>{{ __('messages.category_management') }}</p>
    </a>
    @else
    <a href="{{ route('categories.user-list') }}" class="nav-link {{ request()->routeIs('categories.user-list') ? 'active' : '' }}">
        <i class="nav-icon fas fa-list"></i>
        <p>{{ __('messages.category_list') }}</p>
    </a>
    @endif
</li> 