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
                            <h6 class="float-left"><i class="fas fa-info-circle text-danger"></i> Tahun Ajaran (TA) hanya 1
                                yang dapat
                                diaktifkan.
                            </h6>
                            <a href="javascript:void(0)" id="createNewTa" class="btn btn-info btn-xs float-right">
                                <i class="fas fa-plus-circle"></i> Tambah</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th style="width:5%">No</th>
                                        <th>Tahun Ajaran (TA)</th>
                                        <th class="text-center" style="width:8%">Status</th>
                                        <th class="text-center" style="width: 12%">Action</th>
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
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="taForm" name="taForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="ta_id" id="ta_id">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Tahun Ajaran<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    placeholder="contoh : 2023/2024">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="card-footer">
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
    {{-- Modal Aktif --}}
    <div class="modal fade" id="ajaxModelAktif">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modelHeadingAktif">
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
                        <h6>Apakah anda yakin ingin mengaktifkan <b><span class="text-danger" id="namaTa"></span></b> ini
                            ?</h6>
                    </center>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-success btn-sm " id="aktif"><i class="fa fa-check"></i>
                        Aktifkan</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Non-Aktif --}}
    <div class="modal fade" id="ajaxModelnAktif">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modelHeadingnAktif">
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
                        <h6>Apakah anda yakin ingin menonaktifkan <b><span class="text-danger" id="namaTa"></span></b>
                            ini
                            ?</h6>
                    </center>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-danger btn-sm " id="naktif"><i class="fa fa-ban"></i>
                        Nonaktifkan</button>
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
                ajax: "{{ route('tahun-ajaran.index') }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    {
                        data: "nama",
                        name: "nama",
                    },
                    {
                        data: "status",
                        name: "status",
                    },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                ],
            });

            $("#createNewTa").click(function() {
                $("#saveBtn").val("create-ta");
                $("#ta_id").val("");
                $("#taForm").trigger("reset");
                $("#modelHeading").html("Tambah Tahun Ajaran");
                $("#ajaxModel").modal("show");
                $("#deleteTa").modal("show");
            });

            $("body").on("click", ".editTa", function() {
                var ta_id = $(this).data("id");
                $.get("{{ route('tahun-ajaran.index') }}" + "/" + ta_id + "/edit", function(data) {
                    $("#modelHeading").html("Edit Tahun Ajaran");
                    $("#saveBtn").val("edit-ta");
                    $("#ajaxModel").modal("show");
                    $("#ta_id").val(data.id);
                    $("#nama").val(data.nama);
                });
            });

            $("#saveBtn").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
                );

                $.ajax({
                    data: $("#taForm").serialize(),
                    url: "{{ route('tahun-ajaran.store') }}",
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
                                $("#saveBtn").html("Simpan").removeAttr('disabled');
                            });
                        } else {
                            table.draw();
                            alertSuccess("Tahun Ajaran berhasil ditambah");
                            $("#saveBtn").html("Simpan").removeAttr('disabled');
                            $('#ajaxModel').modal('hide');
                        }
                    },
                });
            });
            $("body").on("click", ".aktifTa", function() {
                var taId = $(this).data("id");
                var nama = $(this).data('nama');
                $("#ajaxModelAktif").modal("show");
                $("#modelHeadingAktif").html("Aktifkan");
                $('#ajaxModelAktif').find('#namaTa').text(nama);
                $("#aktif").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> sedang diproses...</i></span>"
                    ).attr('disabled', 'disabled');
                    $.ajax({
                        url: "{{ url('tahun-ajaran/aktif') }}" + "/" + taId,
                        type: "POST",
                        dataType: "json",
                        data: {
                            taId: taId
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
                                    $("#aktif").html(
                                            "<i class='fa fa-fa-check'></i> Aktifkan"
                                        )
                                        .removeAttr("disabled");
                                });
                            } else if (data.warning) {
                                alertWarning(data.warning);
                                $("#aktif").html(
                                        "<i class='fa fa-fa-check'></i> Aktifkan")
                                    .removeAttr('disabled');
                                $('#ajaxModelAktif').modal('hide');
                            } else {
                                table.draw();
                                alertSuccess(data.success);
                                $("#aktif").html(
                                        "<i class='fa fa-check'></i> Aktifkan")
                                    .removeAttr(
                                        'disabled');
                                $('#ajaxModelAktif').modal('hide');
                            }
                        },
                    });
                });
            });
            $("body").on("click", ".nonaktifTa", function() {
                var taId = $(this).data("id");
                var nama = $(this).data('nama');
                $("#ajaxModelnAktif").modal("show");
                $("#modelHeadingnAktif").html("Nonaktifkan");
                $('#ajaxModelnAktif').find('#namaTa').text(nama);
                $("#naktif").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> sedang diproses...</i></span>"
                    ).attr('disabled', 'disabled');
                    $.ajax({
                        url: "{{ url('tahun-ajaran/naktif') }}" + "/" + taId,
                        type: "POST",
                        dataType: "json",
                        data: {
                            taId: taId
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
                                    $("#naktif").html(
                                            "<i class='fa fa-fa-ban'></i> Nonaktifkan"
                                        )
                                        .removeAttr("disabled");
                                });
                            } else {
                                table.draw();
                                alertSuccess(data.success);
                                $("#naktif").html(
                                        "<i class='fa fa-ban'></i> Nonaktifkan")
                                    .removeAttr(
                                        'disabled');
                                $('#ajaxModelnAktif').modal('hide');
                            }
                        },
                    });
                });
            });
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
@endsection
