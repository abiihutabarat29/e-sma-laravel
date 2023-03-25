@extends('admin.layouts.app')
@section('content')
    <div class="panel-header bg-secondary">
        <div class="page-inner py-4">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4 class="text-white pb-2 fw-bold">Dashboard
                                </h2>
                                <h5 class="text-white op-7 mb-2">Aplikasi Manajemen Data Sekolah</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content mt-2">
        <div class="container-fluid">
            @if (Auth::User()->role == 1)
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>#</h3>
                                <p>Bagian</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-building"></i>
                            </div>
                            <a href="#" class="small-box-footer">Selengkapnya <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>#</h3>
                                <p>Account User</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-user-check"></i>
                            </div>
                            <a href="#" class="small-box-footer">Selengkapnya <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>#</h3>
                                <p>Kegiatan</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-list"></i>
                            </div>
                            <a href="#" class="small-box-footer">Selengkapnya <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>#</h3>
                                <p>SPJ</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-file"></i>
                            </div>
                            <a href="#" class="small-box-footer">Selengkapnya <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            @endif
    </section>
    @if (Auth::User()->role == 2)
        <section class="content">
            <div class="col-md-12">
                <div class="card-footer bg-white shadow-sm">
                    <div class="row">
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <h5 class="description-header mt-4">SPJ Diterima</h5>
                                <span class="description-text text-success">#</span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <h5 class="description-header mt-4">SPJ Ditolak</h5>
                                <span class="description-text text-danger">#</span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <h5 class="description-header mt-4">Anggaran</h5>
                                <span class="description-text">
                                    #
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="description-block">
                                <h5 class="description-header mt-4">Sisa</h5>
                                <span class="description-text">
                                    #
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    @endif
@endsection
