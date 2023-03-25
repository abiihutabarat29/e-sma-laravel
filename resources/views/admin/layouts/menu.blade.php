<li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->segment(1) == 'dashboard' ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>
@if (Auth::user()->level == 1)
    <li
        class="nav-item {{ request()->segment(1) == 'user' ||
        request()->segment(1) == 'bagian' ||
        request()->segment(1) == 'kegiatan' ||
        request()->segment(1) == 'sub-kegiatan' ||
        request()->segment(1) == 'rekening' ||
        request()->segment(1) == 'kartu-kendali' ||
        request()->segment(1) == 'visi-misi'
            ? 'menu-open'
            : '' }}">
        <a href="#"
            class="nav-link {{ request()->segment(1) == 'user' ||
            request()->segment(1) == 'bagian' ||
            request()->segment(1) == 'kegiatan' ||
            request()->segment(1) == 'sub-kegiatan' ||
            request()->segment(1) == 'rekening' ||
            request()->segment(1) == 'kartu-kendali' ||
            request()->segment(1) == 'visi-misi'
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
                <a href="{{ route('user.index') }}"
                    class="nav-link {{ request()->segment(1) == 'user' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>User</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('bagian.index') }}"
                    class="nav-link {{ request()->segment(1) == 'bagian' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Bagian</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kegiatan.index') }}"
                    class="nav-link {{ request()->segment(1) == 'kegiatan' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Anggaran</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kartu.kegiatan') }}"
                    class="nav-link {{ request()->segment(1) == 'kartu-kendali' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kartu Kendali</p>
                </a>
            </li>
        </ul>
    </li>
@endif
@if (Auth::user()->level == 1)
    <li class="nav-item {{ request()->segment(1) == 'spj' ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ request()->segment(1) == 'spj' ? 'active' : '' }}">
            <i class="nav-icon fas fa-layer-group"></i>
            <p>
                SPJ
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('spj.verifikasi') }}"
                    class="nav-link {{ request()->segment(2) == 'verifikasi' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Verifikasi</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('spj.diterima') }}"
                    class="nav-link {{ request()->segment(2) == 'diterima' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Diterima</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('spj.ditolak') }}"
                    class="nav-link {{ request()->segment(2) == 'ditolak' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ditolak</p>
                </a>
            </li>
        </ul>
    </li>
@else
    <li
        class="nav-item {{ request()->segment(1) == 'spj' || request()->segment(2) == 'diterima' || request()->segment(1) == 'ditolak'
            ? 'menu-open'
            : '' }}">
        <a href="#"
            class="nav-link {{ request()->segment(1) == 'spj' || request()->segment(2) == 'diterima' || request()->segment(1) == 'ditolak'
                ? 'active'
                : '' }}">
            <i class="nav-icon fas fa-layer-group"></i>

            <p>
                SPJ
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('spj.index') }}"
                    class="nav-link {{ request()->segment(1) == 'spj' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        Pengajuan SPJ
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('spj.terima') }}"
                    class="nav-link {{ request()->segment(2) == 'terima' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        Pengajuan SPJ Diterima
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('spj.tolak') }}"
                    class="nav-link {{ request()->segment(2) == 'tolak' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        Pengajuan SPJ Ditolak
                    </p>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a href="{{ route('kartukendali.kegiatan') }}"
            class="nav-link {{ request()->segment(1) == 'kartu-kendali-detail' ? 'active' : '' }}">
            <i class="fas fa-credit-card nav-icon"></i>
            <p>
                Kartu Kendali
            </p>
        </a>
    </li>
@endif
@if (Auth::user()->level == 1)
    <li class="nav-item">
        <a href="{{ route('setting.index') }}"
            class="nav-link {{ request()->segment(1) == 'setting' ? 'active' : '' }}">
            <i class="nav-icon fa fa-calendar"></i>
            <p>
                Schedule
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('appsetting.index') }}"
            class="nav-link {{ request()->segment(1) == 'app-setting' ? 'active' : '' }}">
            <i class="nav-icon fa fa-cogs"></i>
            <p>
                Setting Aplikasi
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
