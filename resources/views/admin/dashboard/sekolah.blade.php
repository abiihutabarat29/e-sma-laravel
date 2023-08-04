@extends('admin.layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Selamat Datang
                        @if (Str::length(Auth::guard('admincbd')->user()) > 0)
                            @if (Auth::guard('admincbd')->user()->role == 1)
                                Administrator
                            @endif
                        @elseif (Str::length(Auth::guard('user')->user()) > 0)
                            @if (Auth::guard('user')->user()->role == 2)
                                {{ Auth::guard('user')->user()->sekolah->nama_sekolah }}
                            @endif
                        @endif
                        </h2>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $guru }}</h3>
                            <p>Guru</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $pegawai }}</h3>
                            <p>Pegawai</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning ">
                        <div class="inner">
                            <h3>{{ $siswa }}</h3>
                            <p>Siswa/i</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $alumni }}</h3>
                            <p>Alumni</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
