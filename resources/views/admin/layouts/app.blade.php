<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('admin.layouts.head')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('admin.layouts.nav')
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ '/dashboard' }}" class="brand-link">
                <img src="{{ url('dist/login/images/logo-sekolah.svg') }}" alt="Logo Batu Bara" class="brand-image">
                <span class="brand-text font-weight-light"><b>E-SEKOLAH</b></span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-1 d-flex">
                    <div class="image mt-2">
                        @if (Auth::user()->profile->foto == null)
                            <img src="{{ url('storage/foto-user/blank.png') }}" class="img-circle elevation-2"
                                alt="User Image">
                        @else
                            <img src="{{ url('storage/foto-user/' . Auth::user()->profile->foto) }}"
                                class="img-circle elevation-2" alt="User Image">
                        @endif
                        {{-- fetch foto with guard user --}}
                        {{-- ================================================================================== --}}
                        {{-- @if (Str::length(Auth::guard('admincbd')->user()) > 0)
                            @if (Auth::guard('admincbd')->user()->profile->foto == null)
                                <img src="{{ url('storage/foto-user/blank.png') }}" class="img-circle elevation-2"
                                    alt="User Image">
                            @else
                                <img src="{{ url('storage/foto-user/' . Auth::user()->profile->foto) }}"
                                    class="img-circle elevation-2" alt="User Image">
                            @endif
                        @elseif (Str::length(Auth::guard('user')->user()) > 0)
                            @if (Auth::guard('user')->user()->profile->foto == null)
                                <img src="{{ url('storage/foto-user/blank.png') }}" class="img-circle elevation-2"
                                    alt="User Image">
                            @else
                                <img src="{{ url('storage/foto-user/' . Auth::user()->profile->foto) }}"
                                    class="img-circle elevation-2" alt="User Image">
                            @endif
                        @endif --}}
                        {{-- ================================================================================== --}}
                    </div>
                    <div class="info">
                        <a href="{{ route('profil.index') }}" class="d-block">{{ Auth::user()->profile->nama }}</a>
                        <small class="text-muted">
                            @if (Auth::user()->role == 1)
                                administrator
                            @else
                                user
                            @endif
                        </small>
                    </div>
                </div>
                <center>
                    <small class="text-white badge badge-success mb-2">
                        {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }} |
                        <span id="jam"></span></small>
                </center>
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Cari"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        @include('admin.layouts.menu')
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="content-wrapper">
            <div id="alerts"></div>
            @yield('content')
            @yield('modal')
        </div>
    </div>
    @include('sweetalert::alert')
    @php
        $tahunAjaranAktif = \App\Models\TahunAjaran::where('status', 1)->first();
    @endphp
    <div class="scrolling-text">
        <marquee class="scrolling-text" behavior="scroll" direction="left">
            JIKA TAHUN AJARAN (TA) TIDAK AKTIF SEGERA HUBUNGI ADMINISTRATOR CABDIS. TAHUN AJARAN AKTIF SEKRANG :
            {{ $tahunAjaranAktif ? $tahunAjaranAktif->nama : 'TA belum diaktifkan oleh administrator' }}
        </marquee>
    </div>
    @include('admin.layouts.footer')
