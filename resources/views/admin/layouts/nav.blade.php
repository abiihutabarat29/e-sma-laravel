@php
    $tahunAjaranAktif = \App\Models\TahunPelajaran::where('status', 1)->first();
    $smtAktif = \App\Models\Semester::where('status', 1)->first();
@endphp

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    @if ($tahunAjaranAktif && $smtAktif)
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><span class="text-dark"> TP :
                    {{ $tahunAjaranAktif->tahun }} SEMESTER : {{ $smtAktif->nama_smt }} </span>
            </li>
        </ul>
    @else
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#"><span class="btn btn-danger btn-sm">Tahun Pelajaran & Semester belum
                        aktif</span></a>
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
