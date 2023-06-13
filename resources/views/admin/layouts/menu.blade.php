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
                <a href="{{ route('kecamatan.index') }}"
                    class="nav-link {{ request()->segment(1) == 'kecamatan' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kecamatan</p>
                </a>
            </li>
        </ul>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('desa.index') }}"
                    class="nav-link {{ request()->segment(1) == 'desa' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Desa/Kelurahan</p>
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
    <li
        class="nav-item {{ request()->segment(1) == 'profile-sekolah' ||
        request()->segment(1) == 'wilayah-sekolah' ||
        request()->segment(1) == 'rombel-sekolah' ||
        request()->segment(1) == 'kelas-sekolah' ||
        request()->segment(1) == 'jurusan-sekolah' ||
        request()->segment(1) == 'dakl' ||
        request()->segment(1) == 'sarpras' ||
        request()->segment(1) == 'inventaris'
            ? 'menu-open'
            : '' }}">
        <a href="#"
            class="nav-link {{ request()->segment(1) == 'profile-sekolah' ||
            request()->segment(1) == 'wilayah-sekolah' ||
            request()->segment(1) == 'rombel-sekolah' ||
            request()->segment(1) == 'kelas-sekolah' ||
            request()->segment(1) == 'jurusan-sekolah' ||
            request()->segment(1) == 'dakl' ||
            request()->segment(1) == 'sarpras' ||
            request()->segment(1) == 'inventaris'
                ? 'active'
                : '' }}">
            <i class="nav-icon fas fa-layer-group"></i>
            <p>
                Master Sekolah
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('profile-sekolah.index') }}"
                    class="nav-link {{ request()->segment(1) == 'profile-sekolah' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Profil Sekolah</p>
                </a>
            </li>
        </ul>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('wilayah-sekolah.index') }}"
                    class="nav-link {{ request()->segment(1) == 'wilayah-sekolah' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Wilayah Sekolah</p>
                </a>
            </li>
        </ul>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('rombel-sekolah.index') }}"
                    class="nav-link {{ request()->segment(1) == 'rombel-sekolah' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Entry Kelas/Rombel</p>
                </a>
            </li>
        </ul>
        {{-- <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link {{ request()->segment(1) == 'kelas-sekolah' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Entry Kelas</p>
                </a>
            </li>
        </ul>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link {{ request()->segment(1) == 'jurusan-sekolah' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Entry Jurusan</p>
                </a>
            </li>
        </ul> --}}
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('dakl.index') }}"
                    class="nav-link {{ request()->segment(1) == 'dakl' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Entry DAKL Guru</p>
                </a>
            </li>
        </ul>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('sarpras.index') }}"
                    class="nav-link {{ request()->segment(1) == 'sarpras' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Entry Sarpras</p>
                </a>
            </li>
        </ul>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link {{ request()->segment(1) == 'inventaris' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Entry Inventaris</p>
                </a>
            </li>
        </ul>
    </li>
    <li
        class="nav-item {{ request()->segment(1) == 'mutasi-masuk' ||
        request()->segment(1) == 'mutasi-keluar' ||
        request()->segment(1) == 'kelulusan'
            ? 'menu-open'
            : '' }}">
        <a href="#"
            class="nav-link {{ request()->segment(1) == 'mutasi-masuk' ||
            request()->segment(1) == 'mutasi-keluar' ||
            request()->segment(1) == 'kelulusan'
                ? 'active'
                : '' }}">
            <i class="nav-icon fas fa-layer-group"></i>
            <p>
                Master Akademik
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link {{ request()->segment(1) == 'mutasi-masuk' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Mutasi Masuk</p>
                </a>
            </li>
        </ul>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link {{ request()->segment(1) == 'mutasi-keluar' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Mutasi Keluar</p>
                </a>
            </li>
        </ul>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link {{ request()->segment(1) == 'kelulusan' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kelulusan</p>
                </a>
            </li>
        </ul>
    </li>
    <li
        class="nav-item {{ request()->segment(1) == 'buku-induk' || request()->segment(1) == 'cetak-data' ? 'menu-open' : '' }}">
        <a href="#"
            class="nav-link {{ request()->segment(1) == 'buku-induk' || request()->segment(1) == 'cetak-data' ? 'active' : '' }}">
            <i class="nav-icon fas fa-layer-group"></i>
            <p>
                Master Administrasi
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link {{ request()->segment(1) == 'buku-induk' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Buku Induk</p>
                </a>
            </li>
        </ul>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link {{ request()->segment(1) == 'cetak-data' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Cetak Data</p>
                </a>
            </li>
        </ul>
    </li>
    <li
        class="nav-item {{ request()->segment(1) == 'generate-labul' || request()->segment(1) == 'arsip-labul' ? 'menu-open' : '' }}">
        <a href="#"
            class="nav-link {{ request()->segment(1) == 'generate-labul' || request()->segment(1) == 'arsip-labul' ? 'active' : '' }}">
            <i class="nav-icon fas fa-layer-group"></i>
            <p>
                Master Laporan
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link {{ request()->segment(1) == 'generate-labul' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Generate Labul</p>
                </a>
            </li>
        </ul>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link {{ request()->segment(1) == 'arsip-labul' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Arsip Labul</p>
                </a>
            </li>
        </ul>
    </li>
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
        <a href="{{ route('siswa.index') }}"
            class="nav-link {{ request()->segment(1) == 'siswa' ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-tie"></i>
            <p>
                Entry Siswa/i
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
