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
            <div class="row">
                <div class="col-md-4 mt-3">
                    <div class="card">
                        <div class="card-body box-profile">
                            <h3 class="profile-username text-center">Hello, {{ Auth::user()->profile->nama }}</h3>
                            <hr>
                            <p class="text-muted">Data yang dibutuhkan untuk melakukan generate :
                            </p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Profil Sekolah</b>
                                    @if ($profil == null)
                                        <a href="{{ route('profile-sekolah.index') }}"
                                            class="float-right text-danger"><i>*kosong</i></a>
                                    @else
                                        <i class="float-right fa fa-check-circle text-success"></i>
                                    @endif
                                </li>
                                <li class="list-group-item">
                                    <b>Wilayah/Bangunan Sekolah</b>
                                    @if ($wilayah == null)
                                        <a href="{{ route('wilayah-sekolah.index') }}"
                                            class="float-right text-danger"><i>*kosong</i></a>
                                    @else
                                        <i class="float-right fa fa-check-circle text-success"></i>
                                    @endif
                                </li>
                                <li class="list-group-item">
                                    <b>Kelas/Rombel</b> <a href="{{ route('rombel-sekolah.index') }}"
                                        class="float-right">{{ $rombel }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>DAKL Kebutuhan Guru</b> <a href="{{ route('dakl.index') }}"
                                        class="float-right">{{ $dakl }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Sarpras</b> <a href="{{ route('sarpras.index') }}"
                                        class="float-right">{{ $sarpras }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Inventaris</b> <a href="{{ route('inventaris-sekolah.index') }}"
                                        class="float-right">{{ $inventaris_sekolah }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Guru</b>
                                    @if ($guru == 0)
                                        <a href="{{ route('guru.index') }}"
                                            class="float-right text-danger">{{ $guru }}</a>
                                    @else
                                        <a href="{{ route('guru.index') }}" class="float-right">{{ $guru }}</a>
                                    @endif
                                </li>
                                <li class="list-group-item">
                                    <b>Pegawai</b>
                                    @if ($pegawai == 0)
                                        <a href="{{ route('pegawai.index') }}"
                                            class="float-right text-danger">{{ $pegawai }}</a>
                                    @else
                                        <a href="{{ route('pegawai.index') }}" class="float-right">{{ $pegawai }}</a>
                                    @endif
                                </li>
                                <li class="list-group-item">
                                    <b>Siswa/i</b>
                                    @if ($siswa == 0)
                                        <a href="{{ route('siswa.index') }}"
                                            class="float-right text-danger">{{ $siswa }}</a>
                                    @else
                                        <a href="{{ route('siswa.index') }}" class="float-right">{{ $siswa }}</a>
                                    @endif
                                </li>
                            </ul>
                            <button class="btn btn-primary btn-block" id="generateBtn"><b>Generate</b>
                            </button>
                            {{-- <form action="{{ route('generate.labul') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-block"><b>Generate</b>
                                </button>
                            </form> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-8 mt-3">
                    <div class="card">
                        <div class="card-body box-profile">
                            <h6><i class="fa fa-info-circle"></i> Informasi
                            </h6>
                            <hr>
                            <p class="text-muted">1. Sebelum melakukan <b>"Generate"</b> diharapkan untuk membaca informasi.
                            </p>
                            <p class="text-muted">2. Seluruh data yang dibutuhkan sudah ter-input.
                            </p>
                            <p class="text-muted">4. Jika masih ada data yang masing kosong, makan tombol <b>"Generate"</b>
                                tidak akan aktif .
                            </p>
                            <p class="text-muted">5. Jika masih ada data yang belum lengkap maka hasil export tidak akan
                                sesuai dengan permintaan.
                            </p>
                            <p class="text-muted">6. Generate Laporan Bulanan hanya dapat dilakukan 1x dalam sebulan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#generateBtn').click(function() {
                var button = $(this);
                $.ajax({
                    url: "{{ route('generate.labul') }}",
                    method: 'GET',
                    xhrFields: {
                        responseType: 'blob'
                    },
                    beforeSend: function() {
                        button.attr("disabled", true);
                        button.html(
                            '<span class="spinner-border spinner-border-sm"></span><i> sedang menggenerate...</i>'
                        );
                    },
                    success: function(response, status, xhr) {
                        setTimeout(function() {
                            // Mengubah class tombol saat proses selesai
                            $('#generateBtn').removeClass('btn-primary').addClass(
                                'btn-success');
                            // Mengubah teks tombol saat proses selesai
                            $('#generateBtn').html(
                                "<i class='fa fa-check'></i> Berhasil");
                            setTimeout(function() {
                                $('#generateBtn').removeClass('btn-success')
                                    .addClass('btn-primary');
                                button.html('Generate');
                                button.attr("disabled", false);
                                const blob = new Blob([response], {
                                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                                });
                                const url = URL.createObjectURL(blob);
                                const a = document.createElement('a');
                                a.href = url;
                                // Dapatkan nilai sekolah dari header X-Sekolah dalam respons
                                const sekolah = xhr.getResponseHeader(
                                    'X-Sekolah');
                                // Dapatkan waktu saat ini menggunakan JavaScript
                                const currentTime = new Date();
                                const currentMonth = currentTime.toLocaleString(
                                    'id-ID', {
                                        month: 'long'
                                    });
                                const currentYear = currentTime.getFullYear();
                                const waktu = currentTime.toLocaleTimeString(
                                    'id-ID');
                                a.download = 'Laporan Bulanan_' + currentMonth +
                                    '_' + currentYear + '_' + sekolah + '_' +
                                    waktu + '.xlsx';
                                a.click();
                                URL.revokeObjectURL(url);
                            }, 2000);
                        }, 3000);
                    },
                });
            });
        });
        //validasi data
        document.addEventListener('DOMContentLoaded', function() {
            var generateButton = document.getElementById('generateBtn');
            // Cek apakah data ada atau tidak ada
            @if (
                $profilValid == null ||
                    $wilayahValid == null ||
                    $rombelValid->isEmpty() ||
                    $daklValid->isEmpty() ||
                    $sarprasValid->isEmpty() ||
                    $inventaris_sekolahValid->isEmpty() ||
                    $pegawaiValid->isEmpty() ||
                    $guruValid->isEmpty() ||
                    $pegawaiValid->isEmpty() ||
                    $siswaValid->isEmpty())
                generateButton.disabled = true;
                generateButton.setAttribute('title', 'Pastikan data yang dibutuhkan tersedia.');
            @else
                generateButton.disabled = false;
                generateButton.removeAttribute('title');
            @endif
        });
    </script>
@endsection
