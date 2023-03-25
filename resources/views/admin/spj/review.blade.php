@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $menu }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $menu }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                    <div class="row">
                        <div class="col-12">
                            <div class="post">
                                <div class="user-block">
                                    @if ($user->foto != null)
                                        <img src="{{ url('storage/fotouser/' . $user->foto) }}"
                                            class="img-circle img-bordered-sm" alt="User Image">
                                    @else
                                        <img src="{{ url('storage/fotouser/blank.png') }}"
                                            class="img-circle img-bordered-sm" alt="User Image">
                                    @endif
                                    <span class="username">
                                        <a href="#">{{ $user->nama }}</a>
                                    </span>
                                    <span class="description">{{ $spj->bagian->nama_bagian }}</span>
                                    <span class="description">upload pada - <span
                                            class="badge badge-info">{{ \Carbon\Carbon::parse($spj->created_at)->translatedFormat('l, d F Y') }}</span>
                                </div>
                                <div class="col-md-12">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <hr>
                                            <h5>
                                                Detail Kegiatan
                                            </h5>
                                            <table>
                                                <tr>
                                                    <td rowspan="5" style="width:4%">
                                                        @if ($spj->jenis_spm == 1)
                                                            <span class="badge badge-primary btn-sm">GU</span>
                                                        @elseif($spj->jenis_spm == 2)
                                                            <span class="badge badge-primary btn-sm">TU</span>
                                                        @elseif($spj->jenis_spm == 3)
                                                            <span class="badge badge-primary btn-sm">LS</span>
                                                        @elseif($spj->jenis_spm == 4)
                                                            <span class="badge badge-primary btn-sm">UP</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 4%">
                                                        Kode Kegiatan
                                                    </td>
                                                    <td style="width: 1%">
                                                        :
                                                    </td>
                                                    <td style="width: 20%">
                                                        {{ $spj->kegiatan->kode_kegiatan }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 4%">
                                                        Kegiatan
                                                    </td>
                                                    <td style="width: 1%">
                                                        :
                                                    </td>
                                                    <td style="width: 20%">
                                                        {{ $spj->kegiatan->nama_kegiatan }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 4%">
                                                        Kode Sub Kegiatan
                                                    </td>
                                                    <td style="width: 1%">
                                                        :
                                                    </td>
                                                    <td style="width: 20%">
                                                        {{ $spj->subkegiatan->kode_sub }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 4%">
                                                        Sub Kegiatan
                                                    </td>
                                                    <td style="width: 1%">
                                                        :
                                                    </td>
                                                    <td style="width: 20%">
                                                        {{ $spj->subkegiatan->nama_sub }}
                                                    </td>
                                                </tr>
                                            </table>
                                            <hr>
                                            <h5>
                                                Detail Penerima
                                            </h5>
                                            <table>
                                                <tr>
                                                    <td rowspan="5" style="width:4%">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 4%">
                                                        Uraian
                                                    </td>
                                                    <td style="width: 1%">
                                                        :
                                                    </td>
                                                    <td style="width: 20%">
                                                        {{ $spj->uraian }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 4%">
                                                        Nama Penerima
                                                    </td>
                                                    <td style="width: 1%">
                                                        :
                                                    </td>
                                                    <td style="width: 20%">
                                                        {{ $spj->nama_penerima }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 4%">
                                                        Alamat Penerima
                                                    </td>
                                                    <td style="width: 1%">
                                                        :
                                                    </td>
                                                    <td style="width: 20%">
                                                        {{ $spj->alamat_penerima }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 4%">
                                                        Nilai Kwitansi
                                                    </td>
                                                    <td style="width: 1%">
                                                        :
                                                    </td>
                                                    <td style="width: 20%">
                                                        <span
                                                            class="badge badge-danger">{{ 'Rp. ' . number_format($spj->kwitansi, 0, ',', '.') }}</span>
                                                    </td>
                                                </tr>
                                            </table>
                                            <hr>
                                            <h5>
                                                Berkas
                                            </h5>
                                            <a href="{{ url('storage/file/', $spj->file) }}" target="blank"
                                                class="link-blue text-sm"><i class="fas fa-link mr-1"></i>
                                                File Berkas</a>
                                            <hr>
                                            <h5>
                                                Status
                                            </h5>
                                            @if ($spj->status == 3)
                                                <span class="badge badge-success badge-xs text-white">Diterima</span>
                                            @elseif($spj->status == 4)
                                                <span class="badge badge-danger badge-xs text-white">Ditolak</span>
                                            @elseif($spj->status == 5)
                                                <span class="badge badge-warning badge-xs text-white">Dikembalikan</span>
                                            @endif
                                            <br>
                                            @if ($spj->alasan != null)
                                                <h6>Alasan : <br><i
                                                        class="fas fa-headset"></i>&nbsp;:&nbsp;<i>{{ $spj->alasan }}</i>
                                                </h6>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
