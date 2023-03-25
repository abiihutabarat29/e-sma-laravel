@extends('admin.layouts.app')


@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $menu }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ '/dashboard' }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $menu }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    @if ($appsetting != null)
        <section class="content">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-right">
                                <a href="{{ route('appsetting.edit', Crypt::encryptString($appsetting->id)) }}"
                                    class="btn btn-warning btn-xs text-white">
                                    <i class="fa fa-edit">
                                    </i></a>
                            </div>
                        </div>
                        <div class=" table-responsive">
                            <table class="table">
                                <tr>
                                    <td style="width:4%">
                                        Nama Aplikasi
                                    </td>
                                    <td style="width:0%">
                                        :
                                    </td>
                                    <td style="width:20%">
                                        {{ $appsetting->nama_aplikasi }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Keterangan Aplikasi
                                    </td>
                                    <td>
                                        :
                                    </td>
                                    <td>
                                        {{ $appsetting->keterangan_aplikasi }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Visi
                                    </td>
                                    <td>
                                        :
                                    </td>
                                    <td>
                                        {!! $appsetting->visi !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Misi
                                    </td>
                                    <td>
                                        :
                                    </td>
                                    <td>
                                        {!! $appsetting->misi !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Logo Aplikasi
                                    </td>
                                    <td>
                                        :
                                    </td>
                                    <td>
                                        <img class="profile-user-img img-fluid"
                                            src="{{ url('storage/logo/' . $appsetting->gambar) }}"
                                            alt="User profile picture">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-right">
                            <a href="{{ route('appsetting.create') }}" class="btn btn-info btn-xs">
                                <i class="fa fa-plus-circle">
                                </i></a>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <h6>Opss, profil aplikasi belum diatur . . .</h6><br>
                        <img class="mb-5 mt-5" src="{{ url('dist/img/ils/set.png') }}" width="150px">
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
