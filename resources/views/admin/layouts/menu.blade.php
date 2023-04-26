<li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->segment(1) == 'dashboard' ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>
@if (Auth::user()->role == 1)
    <li
        class="nav-item {{ request()->segment(1) == 'kabupaten' ||
        request()->segment(1) == 'sekolah' ||
        request()->segment(1) == 'users-sekolah' ||
        request()->segment(1) == 'mata-pelajaran' ||
        request()->segment(1) == 'sarana' ||
        request()->segment(1) == 'inventaris'
            ? 'menu-open'
            : '' }}">
        <a href="#"
            class="nav-link {{ request()->segment(1) == 'kabupaten' ||
            request()->segment(1) == 'sekolah' ||
            request()->segment(1) == 'users-sekolah' ||
            request()->segment(1) == 'mata-pelajaran' ||
            request()->segment(1) == 'sarana' ||
            request()->segment(1) == 'inventaris'
                ? 'active'
                : '' }}">
            <i class="nav-icon fas fa-layer-group"></i>
            <p>
                Master Data
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('kabupaten.index') }}"
                    class="nav-link {{ request()->segment(1) == 'kabupaten' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kabupaten</p>
                </a>
            </li>
        </ul>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('sekolah.index') }}"
                    class="nav-link {{ request()->segment(1) == 'sekolah' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Sekolah</p>
                </a>
            </li>
        </ul>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('user.index') }}"
                    class="nav-link {{ request()->segment(1) == 'users-sekolah' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Users Sekolah</p>
                </a>
            </li>
        </ul>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('mata-pelajaran.index') }}"
                    class="nav-link {{ request()->segment(1) == 'mata-pelajaran' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Mata Pelajaran</p>
                </a>
            </li>
        </ul>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('sarana.index') }}"
                    class="nav-link {{ request()->segment(1) == 'sarana' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Sarana</p>
                </a>
            </li>
        </ul>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('inventaris.index') }}"
                    class="nav-link {{ request()->segment(1) == 'inventaris' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Inventaris</p>
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
