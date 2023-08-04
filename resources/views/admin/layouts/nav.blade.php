@php
    $tahunAjaranAktif = \App\Models\TahunAjaran::where('status', 1)->first();
@endphp

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    @if ($tahunAjaranAktif)
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#"><span class="btn btn-primary btn-sm">TA :
                        {{ $tahunAjaranAktif->nama }} Aktif</span></a>
            </li>
        </ul>
    @else
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#"><span class="btn btn-danger btn-sm">TA belum diaktifkan
                        administrator</span></a>
            </li>
        </ul>
    @endif
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
