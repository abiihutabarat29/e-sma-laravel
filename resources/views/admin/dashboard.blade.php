@extends('admin.layouts.app')
@section('content')
    <div class="panel-header bg-secondary">
        <div class="page-inner py-4">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4 class="text-white pb-2 fw-bold">Dashboard @if (Auth::user()->level == 1)
                                    Administrator
                                @else
                                    {{ Auth::user()->bagian->nama_bagian }}
                                @endif
                                </h2>
                                <h5 class="text-white op-7 mb-2">{{ $app->nama_aplikasi }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div class="ml-md-auto">
                    @if ($gu != null)
                        @if (date('Y-m-d') < $gu->tgl_mulai && date('H:i:s') < $gu->jam_mulai)
                            <a href="#" class="btn btn-success btn-round btn-xs mr-2 mb-2"><i
                                    class="fa fa-wallet"></i>&nbsp;&nbsp;{{ $gu->judul }} mulai
                                {{ \Carbon\Carbon::parse($gu->tgl_mulai)->translatedFormat('l, d F Y') }}
                                </td> | Pukul : {{ $gu->jam_mulai }} -
                                {{ \Carbon\Carbon::parse($gu->tgl_selesai)->translatedFormat('l, d F Y') }}
                                </td> | Pukul : {{ $gu->jam_selesai }}</a>
                            <a href="#" class="btn btn-warning btn-round btn-xs mb-2 text-white mr-2"><i
                                    class="fas fa-clock"></i>&nbsp;&nbsp;sesi belum dimulai</a>
                        @elseif(date('Y-m-d') == $gu->tgl_mulai && date('H:i:s') < $gu->jam_mulai)
                            <a href="#" class="btn btn-success btn-round btn-xs mr-2 mb-2"><i
                                    class="fa fa-wallet"></i>&nbsp;&nbsp;{{ $gu->judul }} mulai
                                {{ \Carbon\Carbon::parse($gu->tgl_mulai)->translatedFormat('l, d F Y') }}
                                </td> | Pukul : {{ $gu->jam_mulai }} -
                                {{ \Carbon\Carbon::parse($gu->tgl_selesai)->translatedFormat('l, d F Y') }}
                                </td> | Pukul : {{ $gu->jam_selesai }}</a>
                            <a href="#" class="btn btn-warning btn-round btn-xs mb-2 text-white mr-2"><i
                                    class="fas fa-clock"></i>&nbsp;&nbsp;sesi belum dimulai</a>
                        @elseif (date('Y-m-d') > $gu->tgl_mulai ||
                                (date('Y-m-d') == $gu->tgl_mulai && date('Y-m-d') < $gu->tgl_selesai) ||
                                (date('Y-m-d') == $gu->tgl_selesai && date('H:i:s') > $gu->jam_mulai && date('H:i:s') < $gu->jam_selesai))
                            <a href="#" class="btn btn-success btn-round btn-xs mr-2 ml-2">
                                <i class="fa fa-wallet"></i>&nbsp;&nbsp;{{ $gu->judul }} mulai
                                {{ \Carbon\Carbon::parse($gu->tgl_mulai)->translatedFormat('l, d F Y') }}
                                </td> | Pukul : {{ $gu->jam_mulai }} -
                                {{ \Carbon\Carbon::parse($gu->tgl_selesai)->translatedFormat('l, d F Y') }}
                                </td> | Pukul : {{ $gu->jam_selesai }}</a>
                            <a href="#" class="btn btn-danger btn-round btn-xs mr-2 ml-2"><i
                                    class="fas fa-clock"></i>&nbsp;&nbsp;
                                <span id="berakhir"></span></a>
                        @else
                            <a href="#" class="btn btn-success btn-round btn-xs mr-2 ml-2">
                                <i class="fa fa-wallet"></i>&nbsp;&nbsp;{{ $gu->judul }} mulai
                                {{ \Carbon\Carbon::parse($gu->tgl_mulai)->translatedFormat('l, d F Y') }}
                                </td> | Pukul : {{ $gu->jam_mulai }} -
                                {{ \Carbon\Carbon::parse($gu->tgl_selesai)->translatedFormat('l, d F Y') }}
                                </td> | Pukul : {{ $gu->jam_selesai }}</a>
                            <a href="#" class="btn btn-danger btn-round btn-xs mr-2 ml-2"><i
                                    class="fas fa-clock"></i>&nbsp;&nbsp;
                                <span id="berakhir"></span></a>
                        @endif
                    @else
                        <a href="#" class="btn btn-success btn-round btn-xs mr-2 mb-2"><i
                                class="fa fa-wallet"></i>&nbsp;&nbsp;Belum ada GU</a>
                        <a href="#" class="btn btn-danger btn-round btn-xs mb-2 mr-2"><i
                                class="fas fa-clock"></i>&nbsp;&nbsp;<span id="berakhir"></span></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content mt-2">
        <div class="container-fluid">
            @if (Auth::user()->level == 1)
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $bagian }}</h3>
                                <p>Bagian</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-building"></i>
                            </div>
                            <a href="{{ 'bagian' }}" class="small-box-footer">Selengkapnya <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $user }}</h3>
                                <p>Account User</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-user-check"></i>
                            </div>
                            <a href="{{ 'user' }}" class="small-box-footer">Selengkapnya <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $kegiatan_all }}</h3>
                                <p>Kegiatan</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-list"></i>
                            </div>
                            <a href="{{ 'kegiatan' }}" class="small-box-footer">Selengkapnya <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $spj }}</h3>
                                <p>SPJ</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-file"></i>
                            </div>
                            <a href="{{ route('spj.diterima') }}" class="small-box-footer">Selengkapnya <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            @endif
    </section>
    @if (Auth::user()->level == 2)
        <section class="content">
            <div class="col-md-12">
                <div class="card-footer bg-white shadow-sm">
                    <div class="row">
                        {{-- <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <div class="row">
                                    <div class="col-md-4">
                                        @if (Auth::user()->foto == null)
                                            <img src="{{ url('storage/fotouser/blank.png') }}" class="img-circle elevation-2"
                                                width="60px">
                                        @else
                                            <img src="{{ url('storage/fotouser/' . Auth::user()->foto) }}"
                                                class="img-circle elevation-2" width="65px">
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="description-header mt-2">{{ Auth::user()->nama }}</h5>
                                        <span class="description-text">{{ Auth::user()->bagian->nama_bagian }}</span>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <h5 class="description-header mt-4">SPJ Diterima</h5>
                                <span class="description-text text-success">{{ $spj_terima }}</span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <h5 class="description-header mt-4">SPJ Ditolak</h5>
                                <span class="description-text text-danger">{{ $spj_tolak }}</span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <h5 class="description-header mt-4">Anggaran</h5>
                                <span class="description-text">
                                    @if (Auth::user()->level == 2)
                                        <span
                                            class="description-text text-success">{{ 'Rp. ' . number_format($pagu_kegiatan->pagu, 0, ',', '.') }}</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="description-block">
                                <h5 class="description-header mt-4">Sisa</h5>
                                <span class="description-text">
                                    @if (Auth::user()->level == 2)
                                        <span
                                            class="description-text text-danger">{{ 'Rp. ' . number_format($sisa_kegiatan->sisa, 0, ',', '.') }}</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    @endif
@endsection
@section('script')
    <script>
        @if (!$gu == null)
            var countDownDate4 = new Date("{{ $gu->tgl_selesai }} {{ $gu->jam_selesai }}").getTime();
        @else
            var countDownDate4 = new Date().getTime();
        @endif
        var countdownfunction4 = setInterval(function() {
            var now = new Date().getTime();
            var distance4 = countDownDate4 - now;
            var days4 = Math.floor(distance4 / (1000 * 60 * 60 * 24));
            var hours4 = Math.floor(
                (distance4 % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
            );
            var minutes4 = Math.floor((distance4 % (1000 * 60 * 60)) / (1000 * 60));
            var seconds4 = Math.floor((distance4 % (1000 * 60)) / 1000);
            document.getElementById("berakhir").innerHTML = "Berakhir dalam " +
                days4 + " hari " + hours4 + " jam " + minutes4 + " menit " + seconds4 + " detik " +
                "lagi . . .";
            if (distance4 < 0) {
                clearInterval(countdownfunction4);
                document.getElementById("berakhir").innerHTML = "sesi telah berakhir";
            }
        }, 1000);
    </script>
@endsection
