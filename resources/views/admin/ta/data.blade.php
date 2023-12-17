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
                            <h5 class="float-left">Atur Tahun Pelajaran dan Semester
                            </h5>
                            <button type="button" id="createNewTa" class="btn btn-sm bg-gradient-primary float-right"><i
                                    class="fas fa-plus-circle"></i><span class="d-none d-sm-inline-block ml-1">Tambah Tahun
                                    Pelajaran</span>
                            </button>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <h6>Tahun Pelajaran</h4>
                                            <hr>
                                            <table class="table table-bordered table-striped data-table">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5%">No</th>
                                                        <th>Tahun Pelajaran</th>
                                                        <th class="text-center" style="width:8%">Status</th>
                                                        <th class="text-center" style="width: 25%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <h6>Semester</h4>
                                            <hr>
                                            <table class="table table-bordered table-striped semester-data">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5%">No</th>
                                                        <th>Semester</th>
                                                        <th class="text-center" style="width:8%">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                    </div>
                                </div>
                            </div>
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
                        <input type="hidden" name="taId" id="taId">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Tahun Pelajaran<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="tahun" name="tahun"
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
                        <h6>Apakah anda yakin ingin mengaktifkan <b><span class="text-danger" id="namaTa"></span></b>
                            ini
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
    {{-- Modal Delete --}}
    <div class="modal fade" id="ajaxModelHps">
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
                        <h6>Apakah anda yakin menghapus data TP <b><span class="text-danger" id="deleteTa"></span></b>
                            ini
                            ?<br>
                            Tindakan ini akan membuat data yang berhubungan tidak aktif
                        </h6>
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

            var tableTa = $(".data-table").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 10,
                lengthMenu: [10, 50, 100, 200, 500],
                lengthChange: true,
                autoWidth: false,
                ajax: "{{ route('tahun-pelajaran.index') }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    {
                        data: "tahun",
                        name: "tahun",
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

            var tableSmt = $(".semester-data").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 10,
                lengthMenu: [10, 50, 100, 200, 500],
                lengthChange: true,
                autoWidth: false,
                ajax: "{{ route('semester.data') }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    {
                        data: "semester",
                        name: "semester",
                    },
                    {
                        data: "status",
                        name: "status",
                    },
                ],
            });

            $("#createNewTa").click(function() {
                $("#saveBtn").val("create-ta");
                $("#taId").val("");
                $("#taForm").trigger("reset");
                $("#modelHeading").html("Tambah Tahun Pelajaran");
                $("#ajaxModel").modal("show");
            });

            $("body").on("click", ".editTa", function() {
                var taId = $(this).data("id");
                $.get("{{ route('tahun-pelajaran.index') }}" + "/" + taId + "/edit", function(data) {
                    $("#modelHeading").html("Edit Tahun Pelajaran");
                    $("#saveBtn").val("edit-ta");
                    $("#ajaxModel").modal("show");
                    $("#taId").val(data.id);
                    $("#tahun").val(data.tahun);
                });
            });

            $("#saveBtn").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
                );

                $.ajax({
                    data: $("#taForm").serialize(),
                    url: "{{ route('tahun-pelajaran.store') }}",
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
                            tableTa.draw();
                            alertSuccess(data.success);
                            $("#saveBtn").html("Simpan").removeAttr('disabled');
                            $('#ajaxModel').modal('hide');
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        }
                    },
                });
            });
            $("body").on("click", ".deleteTa", function() {
                var taId = $(this).data("id");
                var tahun = $(this).data('tahun');
                $("#ajaxModelHps").modal("show");
                $("#modelHeadingHps").html("Hapus");
                $('#ajaxModelHps').find('#deleteTa').text(tahun);
                $("#hapusBtn").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menghapus...</i></span>"
                    ).attr('disabled', 'disabled');
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('tahun-pelajaran.store') }}" + "/" + taId,
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
                                        "<i class='fa fa-trash'></i> Hapus"
                                    ).removeAttr('disabled');
                                });
                            } else {
                                tableTa.draw();
                                alertSuccess(data.success);
                                $("#hapusBtn").html(
                                    "<i class='fa fa-trash'></i> Hapus").removeAttr(
                                    'disabled');
                                $('#ajaxModelHps').modal('hide');
                            }
                        },
                    });
                });
            });
            $("body").on("click", ".aktifTa", function(e) {
                var taId = $(this).data("id");
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'></span>"
                ).attr('disabled', 'disabled');
                $.ajax({
                    url: "{{ url('tahun-pelajaran/aktif') }}" + "/" + taId,
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
                            });
                        } else {
                            tableTa.draw();
                            alertSuccess(data.success);
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        }
                    },
                });
            });

            $("body").on("click", ".aktifSmt", function(e) {
                var smtId = $(this).data("id");
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'></span>"
                ).attr('disabled', 'disabled');
                $.ajax({
                    url: "{{ url('semester/aktif') }}" + "/" + smtId,
                    type: "POST",
                    dataType: "json",
                    data: {
                        smtId: smtId
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
                            });
                        } else {
                            tableSmt.draw();
                            alertSuccess(data.success);
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        }
                    },
                });
            });
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
@endsection
