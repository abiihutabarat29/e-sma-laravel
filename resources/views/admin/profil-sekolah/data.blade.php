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
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        @if ($profil == null)
                            <div class="card card-danger card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center p-5">
                                        <span class="text-danger"><i>* profil kepala sekolah tidak ada</i></span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card card-info card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        @if ($profil->foto_kepsek == null)
                                            <img class="profile-user-img img-fluid img-circle"
                                                src="{{ url('storage/foto-kepsek/blank.png') }}" alt="User profile picture">
                                        @else
                                            <img src="{{ url('storage/foto-kepsek/' . $profil->foto_kepsek) }}"
                                                class="profile-user-img img-fluid img-circle" alt="User Image">
                                        @endif
                                    </div>

                                    <h3 class="profile-username text-center">Nina Mcintire</h3>

                                    <p class="text-muted text-center">Software Engineer</p>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Followers</b> <a class="float-right">1,322</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Following</b> <a class="float-right">543</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Friends</b> <a class="float-right">13,287</a>
                                        </li>
                                    </ul>
                                    <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <div class="invoice p-3 mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <h6>
                                        <i class="fas fa-home"></i> Profil Sekolah
                                        <div class="float-right">
                                            @if ($profil == null)
                                                <a href="javascript:void(0)" class="btn btn-info btn-xs addProfile"
                                                    title="Update Profil Sekolah">
                                                    <i class="fa fa-plus-circle">
                                                    </i>
                                                </a>
                                            @else
                                                <a href="javascript:void(0)" class="btn btn-warning btn-xs text-white"
                                                    title="Ubah Profil Sekolah">
                                                    <i class="fa fa-edit">
                                                    </i>
                                                </a>
                                            @endif
                                        </div>
                                    </h6>
                                </div>
                            </div>
                            @if ($profil == null)
                                <div class="col-sm-12 invoice-col mt-5" style="height: 400px">
                                    <div class="text-center p-5">
                                        <span class="text-danger"><i>* profil sekolah tidak ada</i></span>
                                    </div>
                                </div>
                            @else
                                <div class="col-sm-4 invoice-col mt-4">
                                    <h6><b>Nama Sekolah</b></h6>
                                    <span>{{ Auth::user()->sekolah->nama_sekolah }}</span>
                                    <h6 class="mt-2"><b>NPSN</b></h6>
                                    <span>{{ Auth::user()->sekolah->npsn }}</span>
                                    {{-- <h6 class="mt-2"><b>Email</b></h6>
                            <span>{{ $profil->email }}</span>
                            <h6 class="mt-2"><b>Nomor Handphone</b></h6>
                            <span>{{ $profil->nohp }}</span>
                            <h6 class="mt-2"><b>Jenis Kelamin</b></h6>
                            @if ($profil->profile->gender == null)
                                <span class="text-danger"><i>* tidak ada</i></span>
                            @else
                                @if ($profil->profile->gender == 'L')
                                    Laki-laki
                                @else
                                    Perempuan
                                @endif
                            @endif
                            <h6 class="mt-2"><b>Tempat Lahir</b></h6>
                            @if ($profil->profile->tempat_lahir == null)
                                <span class="text-danger"><i>* tidak ada</i></span>
                            @else
                                {{ $profil->profile->tempat_lahir }}
                            @endif
                            <h6 class="mt-2"><b>Tanggal Lahir</b></h6>
                            @if ($profil->profile->tgl_lahir == null)
                                <span class="text-danger"><i>* tidak ada</i></span>
                            @else
                                {{ \Carbon\Carbon::parse($profil->profile->tgl_lahir)->translatedFormat('l, d F Y') }}
                            @endif
                            <h6 class="mt-2"><b>Alamat</b></h6>
                            @if ($profil->profile->alamat == null)
                                <span class="text-danger"><i>* tidak ada</i></span>
                            @else
                                {{ $profil->profile->alamat }}
                            @endif --}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        function previewImg() {
            const foto = document.querySelector('#foto');
            const img = document.querySelector('.img-preview');

            const fileFoto = new FileReader();
            fileFoto.readAsDataURL(foto.files[0]);

            fileFoto.onload = function(e) {
                img.src = e.target.result;
            }
        }
        $(function() {
            bsCustomFileInput.init();
        });
        $("body").on("click", ".addProfile", function() {
            var url = "{{ route('profile-sekolah.create') }}"
            window.location = url;
        });
    </script>
@endsection
