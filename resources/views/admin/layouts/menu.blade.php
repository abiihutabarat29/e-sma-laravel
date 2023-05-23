<li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->segment(1) == '/dashboard' ? 'active' : '' }}">
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
        request()->segment(1) == 'inventaris' ||
        request()->segment(1) == 'golongan'
            ? 'menu-open'
            : '' }}">
        <a href="#"
            class="nav-link {{ request()->segment(1) == 'kabupaten' ||
            request()->segment(1) == 'sekolah' ||
            request()->segment(1) == 'users-sekolah' ||
            request()->segment(1) == 'mata-pelajaran' ||
            request()->segment(1) == 'sarana' ||
            request()->segment(1) == 'inventaris' ||
            request()->segment(1) == 'golongan'
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
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('golongan.index') }}"
                    class="nav-link {{ request()->segment(1) == 'golongan' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Golongan</p>
                </a>
            </li>
        </ul>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('jurusan.index') }}"
                    class="nav-link {{ request()->segment(1) == 'jurusan' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Jurusan</p>
                </a>
            </li>
        </ul>
    </li>
@else
    <li class="nav-item">
        <a href="{{ route('guru.index') }}" class="nav-link {{ request()->segment(1) == 'guru' ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-tie"></i>
            <p>
                Entry Guru
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('pegawai.index') }}"
            class="nav-link {{ request()->segment(1) == 'pegawai' ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-tie"></i>
            <p>
                Entry Pegawai
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('siswa.index') }}" class="nav-link {{ request()->segment(1) == 'siswa' ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-tie"></i>
            <p>
                Entry Siswa
            </p>
        </a>
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
<div class="user-panel">
</div>
<li class="nav-header">MANUAL BOOK</li>
<li class="nav-item">
    <a href="{{ route('download') }}" class="nav-link">
        <i class="nav-icon fas fa-download"></i>
        <p>
            Download
        </p>
    </a>
</li>
