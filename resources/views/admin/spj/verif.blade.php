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
                                            </p>
                                        </div>
                                        <div class="card-footer">
                                            <button id="konfirmasi" type="button" data-toggle="modal"
                                                class="btn btn-success btn-xs text-white"><i class="fa fa-check"></i>
                                                Terima</button>
                                            <button id="kembalikan" type="button" data-toggle="modal"
                                                class="btn btn-warning btn-xs text-white"><i class="fa fa-exchange-alt"></i>
                                                Kembalikan</button>
                                            <button id="tolak" type="button" data-toggle="modal"
                                                class="btn btn-danger btn-xs"><i class="fa fa-ban"></i> Tolak</button>
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
@section('modal')
    {{-- Modal Tolak --}}
    <div class="modal fade" id="ajaxModel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modelHeading">
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                </div>
                <form id="tolakForm" name="tolakForm" class="form-horizontal">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"
                            style="display: none;">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <center>
                            <h6 class="text-muted">::KEPUTUSAN INI TIDAK DAPAT DIUBAH KEMBALI::</h6>
                            <br>
                        </center>
                        <h6>Apakah anda yakin untuk menolak SPJ dari {{ $spj->bagian->nama_bagian }} ?</h6>
                        <input type="hidden" id="spj_id" name="spj_id" value="{{ $spj->id }}">
                        <div class="form-group">
                            <label>Berikan Alasan<span class="text-danger">*</span></label>
                            <textarea name="alasan" id="alasan" class="form-control" rows="3" placeholder="Alasan . . ."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-danger btn-sm " id="tolakBtn"><i class="fa fa-ban"></i>
                            Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal Kembalikan --}}
    <div class="modal fade" id="ajaxModelback">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modelHeadingBack">
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                </div>
                <form id="kembaliForm" name="kembaliForm" class="form-horizontal">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"
                            style="display: none;">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <center>
                            <h6 class="text-muted">::KEPUTUSAN INI TIDAK DAPAT DIUBAH KEMBALI::</h6>
                            <br>
                        </center>
                        <h6>Apakah anda yakin untuk mengembalikan SPJ dari {{ $spj->bagian->nama_bagian }} ?</h6>
                        <input type="hidden" id="spj_id" name="spj_id" value="{{ $spj->id }}">
                        <div class="form-group">
                            <label>Berikan Alasan<span class="text-danger">*</span></label>
                            <textarea name="alasan" id="alasan" class="form-control" rows="3" placeholder="Alasan . . ."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-warning btn-sm text-white" id="kembaliBtn"><i
                                class="fa fa-exchange-alt"></i>
                            Kembalikan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal Terima --}}
    <div class="modal fade" id="ajaxModelkonfirm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modelHeadingKonfirm">
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                </div>
                <form id="konfirmForm" name="konfirmForm" class="form-horizontal">
                    @csrf
                    <div class="modal-body">
                        <center>
                            <h6 class="text-muted">::KEPUTUSAN INI TIDAK DAPAT DIUBAH KEMBALI::</h6>
                            <br>
                        </center>
                        <center>
                            <h6>Apakah SPJ dari {{ $spj->bagian->nama_bagian }} sudah sesuai dengan ketentuan ?</h6>
                        </center>
                        <input type="hidden" id="spj_id" name="spj_id" value="{{ $spj->id }}">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-success btn-sm text-white" id="konfirmBtn"><i
                                class="fa fa-check"></i>
                            Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            $("#konfirmasi").click(function() {
                $("#konfirmForm").trigger("reset");
                $("#modelHeadingKonfirm").html("Konfirmasi");
                $("#ajaxModelkonfirm").modal("show");
            });
            $("#konfirmBtn").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> memproses...</i></span>"
                );
                var spj_id = $("#spj_id").val();
                $.ajax({
                    data: $("#konfirmForm").serialize(),
                    url: "{{ url('spj/terima') }}" + "/" + spj_id,
                    type: "POST",
                    dataType: "json",
                    success: function(data) {
                        if (data.errors) {
                            $('.alert-danger').html('');
                            $.each(data.errors, function(key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<strong><li>' +
                                    value +
                                    '</li></strong>');
                                $(".alert-danger").fadeOut(5000);
                                $("#konfirmBtn").html(
                                    "<i class='fa fa-check'></i> Konfirmasi");
                            });
                        } else {
                            alertSuccess(data.success);
                            $("#konfirmBtn").html(
                                "<i class='fa fa-check'></i> Konfirmasi");
                            $('#ajaxModelkonfirm').modal('hide');
                            window.location.href = "{{ url('spj/verifikasi') }}"
                        }
                    },
                });
            });
            $("#kembalikan").click(function() {
                $("#kembaliForm").trigger("reset");
                $("#modelHeadingBack").html("Konfirmasi");
                $("#ajaxModelback").modal("show");
            });
            $("#kembaliBtn").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> memproses...</i></span>"
                );
                var spj_id = $("#spj_id").val();
                $.ajax({
                    data: $("#kembaliForm").serialize(),
                    url: "{{ url('spj/kembalikan') }}" + "/" + spj_id,
                    type: "POST",
                    dataType: "json",
                    success: function(data) {
                        if (data.errors) {
                            $('.alert-danger').html('');
                            $.each(data.errors, function(key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<strong><li>' +
                                    value +
                                    '</li></strong>');
                                $(".alert-danger").fadeOut(5000);
                                $("#kembaliBtn").html(
                                    "<i class='fa fa-exchange-alt'></i> Kembalikan");
                            });
                        } else {
                            alertSuccess(data.success);
                            $("#kembaliBtn").html(
                                "<i class='fa fa-exchange-alt'></i> Kembalikan");
                            $('#ajaxModelback').modal('hide');
                            window.location.href = "{{ url('spj/verifikasi') }}"
                        }
                    },
                });
            });
            $("#tolak").click(function() {
                $("#tolakForm").trigger("reset");
                $("#modelHeading").html("Konfirmasi");
                $("#ajaxModel").modal("show");
            });
            $("#tolakBtn").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> memproses...</i></span>"
                );
                var spj_id = $("#spj_id").val();
                $.ajax({
                    data: $("#tolakForm").serialize(),
                    url: "{{ url('spj/decline') }}" + "/" + spj_id,
                    type: "POST",
                    dataType: "json",
                    success: function(data) {
                        if (data.errors) {
                            $('.alert-danger').html('');
                            $.each(data.errors, function(key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<strong><li>' +
                                    value +
                                    '</li></strong>');
                                $(".alert-danger").fadeOut(5000);
                                $("#tolakBtn").html("<i class='fa fa-ban'></i> Tolak");
                                // $('#tolakForm').trigger("reset");
                            });
                        } else {
                            alertSuccess(data.success);
                            $("#tolakBtn").html("<i class='fa fa-ban'></i> Tolak");
                            $('#ajaxModel').modal('hide');
                            window.location.href = "{{ url('spj/verifikasi') }}"
                        }
                    },
                });
            });
        });
    </script>
@endsection
