<li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->segment(1) == 'dashboard' ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>
@if (Auth::user()->role == 1)
    <li class="nav-item {{ request()->segment(1) == 'users-sekolah' ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->segment(1) == 'users-sekolah' ? 'active' : '' }}">
            <i class="nav-icon fas fa-layer-group"></i>
            <p>
                Master Data
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('user.index') }}"
                    class="nav-link {{ request()->segment(1) == 'users-sekolah' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>User Sekolah</p>
                </a>
            </li>
        </ul>
    </li>
@endif
<div class="user-panel mt-3">
</div>
<li class="nav-item">
    <a href="{{ route('logout') }}" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>
            Logout
        </p>
    </a>
</li>
