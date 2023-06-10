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
                            <div class="card">
                                <div class="card-body box-profile">
                                    <div class="text-center p-5">
                                        <span class="text-danger"><i>* profil kepala sekolah tidak ada</i></span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card">
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
                                    <h6 class="text-muted text-center mt-1">Kepala Sekolah</h6>
                                    <h3 class="profile-username text-center">{{ $profil->kepsek }}</h3>
                                    <h6 class="profile-username text-center">NIP :
                                        @if ($profil->nip == null)
                                            -
                                        @else
                                            {{ $profil->nip }}
                                        @endif
                                    </h6>
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b>Guru</b> <a class="float-right">{{ $guru }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Pegawai</b> <a class="float-right">{{ $pegawai }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Siswa</b> <a class="float-right">{{ $siswa }}</a>
                                        </li>
                                    </ul>
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
                                                    title="Lengkapi Profil">Lengkapi Profil
                                                </a>
                                            @else
                                                <a href="javascript:void(0)" class="btn btn-secondary btn-xs"
                                                    title="Perbaharui Profil">Perbaharui Profil
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
                                    <h6 class="mt-2"><b>NSS</b></h6>
                                    <span>{{ $profil->nss }}</span>
                                    <h6 class="mt-2"><b>NDS</b></h6>
                                    <span>{{ $profil->nds }}</span>
                                    <h6 class="mt-2"><b>Status</b></h6>
                                    <span>{{ Auth::user()->sekolah->status }}</span>
                                    <h6 class="mt-2"><b>Akreditas</b></h6>
                                    <span>{{ $profil->akreditas }}</span>
                                    <h6 class="mt-2"><b>Alamat</b></h6>
                                    <span>{{ $profil->alamat }}</span>
                                    <h6 class="mt-2"><b>Kabupaten</b></h6>
                                    <span>{{ $profil->kabupaten->kabupaten }}</span>
                                    <h6 class="mt-2"><b>Kecamatan</b></h6>
                                    <span>{{ $profil->kecamatan->kecamatan }}</span>
                                    <h6 class="mt-2"><b>Desa/Kelurahan</b></h6>
                                    <span>{{ $profil->desa->desa }}</span>
                                    <h6 class="mt-2"><b>Kode Pos</b></h6>
                                    <span>{{ $profil->kodepos }}</span>
                                    <h6 class="mt-2"><b>Telp/No HP/No WhatsApp</b></h6>
                                    <span>{{ $profil->telp }}</span>
                                    <h6 class="mt-2"><b>Email</b></h6>
                                    <span>{{ $profil->email }}</span>
                                    <h6 class="mt-2"><b>Website</b></h6>
                                    @if ($profil->website == null)
                                        <span class="text-danger"><i>* tidak ada</i></span>
                                    @else
                                        {{ $profil->website }}
                                    @endif
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
