@extends('admin.layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $menu }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ 'dashboard' }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $menu }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @if ($setting != null)
        <section class="content">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-right">
                                <a href="#" class="btn btn-warning btn-xs text-white" data-toggle="modal"
                                    data-target="#modal-lg{{ $setting->id }}">
                                    <i class="fa fa-edit">
                                    </i></a>
                            </div>
                        </div>
                        <div class=" table-responsive table-hover">
                            <table class="table">
                                <tr>
                                    <td rowspan="4" style="width:4%">
                                        <span class="badge badge-primary btn-sm"> {{ $setting->judul }}</span>
                                        {{-- Validasi GU aktif / nonaktif --}}
                                        @if (date('Y-m-d') < $setting->tgl_mulai && date('H:i:s') < $setting->jam_mulai)
                                            <span class="badge badge-warning btn-sm text-white">sesi belum dimulai</span>
                                        @elseif(date('Y-m-d') == $setting->tgl_mulai && date('H:i:s') < $setting->jam_mulai)
                                            <span class="badge badge-warning btn-sm text-white">sesi belum dimulai</span>
                                        @elseif (date('Y-m-d') == $setting->tgl_mulai ||
                                                (date('Y-m-d') > $setting->tgl_mulai &&
                                                    date('H:i:s') > $setting->jam_mulai &&
                                                    date('Y-m-d') < $setting->tgl_selesai) ||
                                                (date('Y-m-d') == $setting->tgl_selesai && date('H:i:s') < $setting->jam_selesai))
                                            <span class="badge badge-success btn-sm">aktif</span>
                                        @else
                                            <span class="badge badge-danger btn-sm">sesi telah berakhir</span>
                                        @endif
                                        {{-- end --}}
                                    </td>
                                    <td style="width:4%">
                                        Tanggal Mulai
                                    </td>
                                    <td style="width:0%">
                                        :
                                    </td>
                                    <td style="width:20%">
                                        {{ \Carbon\Carbon::parse($setting->tgl_mulai)->translatedFormat('l, d F Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Tanggal Selesai
                                    </td>
                                    <td>
                                        :
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($setting->tgl_selesai)->translatedFormat('l, d F Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Jam Mulai
                                    </td>
                                    <td>
                                        :
                                    </td>
                                    <td>
                                        {{ $setting->jam_mulai }} WIB
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Jam Selesai
                                    </td>
                                    <td>
                                        :
                                    </td>
                                    <td>
                                        {{ $setting->jam_selesai }} WIB
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- Modal Edit --}}
        <div class="modal fade" id="modal-lg{{ $setting->id }}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Jadwal</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h6>Ketentuan :</h6>
                            <small>
                                *Tanggal mulai harus diatas atau sama dengan tanggal sekarang.<br>
                                *Tanggal selesai harus diatas atau sama dengan tanggal mulai.<br>
                                *Penentuan jam mulai dan jam selesai dalam rentang waktu 12 jam.<br>
                                Contoh :
                            </small><br><small class="ml-4">08:00 - 23:59 WIB&nbsp;<i
                                    class="fa fa-check-circle"></i></small><br>
                            <small class="ml-4">08:00 - 01:00 WIB&nbsp;<i class="fa fa-ban"></i></small>
                        </div>
                        <div class="card">
                            <form method="POST" action="{{ route('setting.update', $setting->id) }}">
                                @csrf
                                @method('put')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Judul<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="judul" placeholder="Judul"
                                            autocomplete="off" value="{{ old('judul', $setting->judul) }}">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Mulai</label>
                                                <input type="date" class="form-control" name="tglm"
                                                    value="{{ old('tglm', $setting->tgl_mulai) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Selesai</label>
                                                <input type="date" class="form-control" name="tgls"
                                                    value="{{ old('tgls', $setting->tgl_selesai) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jam Mulai</label>
                                                <input type="time" class="form-control" name="jamm"
                                                    value="{{ old('jamm', $setting->jam_mulai) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jam Selesai</label>
                                                <input type="time" class="form-control" name="jams"
                                                    value="{{ old('jams', $setting->jam_selesai) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="button" class="btn btn-default btn-sm"
                                            data-dismiss="modal">Kembali</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-right">
                            <a href="#" class="btn btn-info btn-xs"data-toggle="modal" data-target="#modal-lg">
                                <i class="fa fa-plus-circle">
                                </i></a>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <h6>Opss, jadwal belum diatur . . .</h6><br>
                        <img class="mb-0" src="{{ url('dist/img/ils/not-found-data.jpg') }}" width="400px">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Jadwal</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h6>Ketentuan :</h6>
                            <small>
                                *Tanggal mulai harus diatas atau sama dengan tanggal sekarang.<br>
                                *Tanggal selesai harus diatas atau sama dengan tanggal mulai.<br>
                                *Penentuan jam mulai dan jam selesai dalam rentang waktu 12 jam.<br>
                                Contoh :
                            </small><br><small class="ml-4">08:00 - 23:59 WIB&nbsp;<i
                                    class="fa fa-check-circle"></i></small><br>
                            <small class="ml-4">08:00 - 01:00 WIB&nbsp;<i class="fa fa-ban"></i></small>
                        </div>
                        <div class="card">
                            <form method="POST" action="{{ route('setting.store') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Judul<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="judul" placeholder="Judul"
                                            autocomplete="off" value="{{ old('judul') }}">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Mulai</label>
                                                <input type="date" class="form-control" name="tglm"
                                                    value="{{ old('tglm') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Selesai</label>
                                                <input type="date" class="form-control" name="tgls"
                                                    value="{{ old('tgls') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jam Mulai</label>
                                                <input type="time" class="form-control" name="jamm"
                                                    value="{{ old('jamm') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jam Selesai</label>
                                                <input type="time" class="form-control" name="jams"
                                                    value="{{ old('jams') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="button" class="btn btn-default btn-sm"
                                            data-dismiss="modal">Kembali</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
