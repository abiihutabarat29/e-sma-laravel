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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="javascript:void(0)" id="createNewArsip" class="btn btn-info btn-sm">
                                <i class="fas fa-plus-circle"></i> Tambah Arsip</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th style="width:5%">No</th>
                                        <th>Nama Laporan Bulanan</th>
                                        <th class="text-center" style="width: 10%">Bulan</th>
                                        <th class="text-center" style="width: 8%">Tahun</th>
                                        <th class="text-center" style="width: 8%">Unduh</th>
                                        <th class="text-center" style="width: 8%">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="ajaxModelArsip" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <h6><i class="fa fa-info-circle text-danger"></i> Mohon Perhatian</h6>
                    <hr>
                    <p style="text-align: justify"><b>Arsip Laporan Bulanan</b> hanya bisa dilakukan 1x dalam sebulan, untuk
                        itu diharapkan ketika selesai
                        <b>Generate Laporan Bulanan</b>, Laporan hasil Generate langsung diarsipkan agar tidak melewati
                        batas bulan pada saat <b>Laporan Bulanan</b> tergenerate sistem.
                    </p>
                    <hr>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="arsipForm" name="arsipForm" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="arsip_id" id="arsip_id">
                        <input type="hidden" name="validfile" id="validfile"
                            value="{{ Auth::user()->sekolah->npsn . \Carbon\Carbon::now()->format('m') . \Carbon\Carbon::now()->year }}">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Nama Laporan<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_labul" name="nama_labul"
                                    placeholder="Nama Laporan">
                                <small><i>*contoh : Laporan Bulanan Januari.</i></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>File Laporan Bulanan<span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="file" name="file">
                            </div>
                            <small><i>*file maksimal 1MB dan berekstensi xls, xlsx.</i></small>
                        </div>
                        <div class="form-group">
                            <div class="card-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary btn-sm" id="saveBtn" value="create">Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
    {{-- Modal Delete --}}
    <div class="modal fade" id="ajaxModelHpsArsip">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modelHeadingHps">
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <center>
                        <h6 class="text-muted">::KEPUTUSAN INI TIDAK DAPAT DIUBAH KEMBALI::</h6>
                    </center>
                    <center>
                        <h6>Apakah anda yakin menghapus Arsip Laporan Bulanan ini ?</h6>
                    </center>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-danger btn-sm " id="hapusBtn"><i class="fa fa-trash"></i>
                        Hapus</button>
                </div>
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

            var table = $(".data-table").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 10,
                lengthMenu: [10, 50, 100, 200, 500],
                lengthChange: true,
                autoWidth: false,
                ajax: "{{ route('arsip-labul.index') }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    {
                        data: "nama_labul",
                        name: "nama_labul",
                    },
                    {
                        data: "bulan",
                        name: "bulan",
                    },
                    {
                        data: "tahun",
                        name: "tahun",
                    },
                    {
                        data: "unduh",
                        name: "unduh",
                    },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                ],
            });

            $("#createNewArsip").click(function() {
                $("#saveBtn").val("create-arsip");
                $("#arsip_id").val("");
                $("#arsipForm").trigger("reset");
                $("#modelHeading").html("Tambah Arsip");
                $("#ajaxModelArsip").modal("show");
            });

            $("#saveBtn").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
                ).attr('disabled', 'disabled');
                var formData = new FormData($('#arsipForm')[0]);
                $.ajax({
                    url: "{{ route('arsip-labul.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.errors) {
                            $('.alert-danger').html('');
                            $.each(data.errors, function(key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<strong><li>' +
                                    value +
                                    '</li></strong>');
                                $(".alert-danger").fadeOut(5000);
                                $("#saveBtn").html("Simpan").removeAttr(
                                    'disabled');
                            });
                        } else {
                            table.draw();
                            alertSuccess("Arsip saved succesfully.");
                            $("#saveBtn").html("Simpan").removeAttr(
                                'disabled');
                            $('#ajaxModelArsip').modal('hide');
                        }
                    },
                });
            });
            $("body").on("click", ".deleteArsip", function() {
                var arsip_id = $(this).data("id");
                $("#modelHeadingHps").html("Hapus");
                $("#ajaxModelHpsArsip").modal("show");
                $("#hapusBtn").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menghapus...</i></span>"
                    ).attr('disabled', 'disabled');
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('arsip-labul.store') }}" + "/" + arsip_id,
                        data: {
                            _token: "{!! csrf_token() !!}",
                        },
                        success: function(data) {
                            if (data.errors) {
                                $('.alert-danger').html('');
                                $.each(data.errors, function(key, value) {
                                    $('.alert-danger').show();
                                    $('.alert-danger').append('<strong><li>' +
                                        value +
                                        '</li></strong>');
                                    $(".alert-danger").fadeOut(5000);
                                    $("#hapusBtn").html(
                                        "<i class='fa fa-trash'></i>Hapus"
                                    ).removeAttr(
                                        'disabled');
                                });
                            } else {
                                table.draw();
                                alertSuccess(data.success);
                                $("#hapusBtn").html(
                                    "<i class='fa fa-trash'></i>Hapus").removeAttr(
                                    'disabled');
                                $('#ajaxModelHpsArsip').modal('hide');
                            }
                        },
                    });
                });
            });
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
            $(function() {
                bsCustomFileInput.init();
            });
        });
    </script>
@endsection
