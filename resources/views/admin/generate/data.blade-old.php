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
                            <button class="btn btn-primary btn-block" id="generateBtn">
                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                                <b>Generate</b>
                            </button>
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
                // Menampilkan spinner saat tombol diklik
                $(this).prop('disabled', true);
                $(this).find('.spinner-border').removeClass('d-none');

                // Mengirim permintaan AJAX untuk ekspor Excel
                $.ajax({
                    url: "{{ route('generate.labul') }}",
                    type: "GET",
                    success: function(response) {
                        // Menghilangkan spinner setelah permintaan selesai
                        $('#generateBtn').prop('disabled', false);
                        $('#generateBtn').find('.spinner-border').addClass('d-none');

                        // Menunda penanganan hasil ekspor dengan setTimeout
                        setTimeout(function() {
                            // Membuat tautan untuk mengunduh file Excel
                            var downloadLink = document.createElement('a');
                            downloadLink.href = response.filepath;
                            downloadLink.download = response.filename;
                            document.body.appendChild(downloadLink);
                            downloadLink.click();
                            document.body.removeChild(downloadLink);
                        }, 500); // Penundaan selama 500ms (0,5 detik)
                    }
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
