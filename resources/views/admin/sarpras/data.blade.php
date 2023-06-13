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
                            <a href="javascript:void(0)" id="createNewSarpras" class="btn btn-info btn-xs float-right">
                                <i class="fas fa-plus-circle"></i> Tambah</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th style="width:5%">No</th>
                                        <th>Jenis Sarpras</th>
                                        <th class="text-center" style="width: 5%">Baik</th>
                                        <th class="text-center" style="width: 12%">Rusak Ringan</th>
                                        <th class="text-center" style="width: 12%">Rusak Berat</th>
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
                    <form id="sarprasForm" name="sarprasForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="sarpras_id" id="sarpras_id">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Sarana<span class="text-danger">*</span></label>
                                <select class="form-control select2bs4" id="sarana_id" name="sarana_id"
                                    style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Baik<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="baik" name="baik"
                                    placeholder="example : 10">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Rusak Ringan<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="rusak_ringan" name="rusak_ringan"
                                    placeholder="example : 10">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Rusak Berat<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="rusak_berat" name="rusak_berat"
                                    placeholder="example : 10">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Keterangan<small> (Opsional)</small></label>
                                <textarea id="keterangan" name="keterangan" class="form-control" rows="3"></textarea>
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
                        <h6>Apakah anda yakin menghapus Data Sarpras ini ?</h6>
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
                ajax: "{{ route('sarpras.index') }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    {
                        data: "sarana",
                        name: "sarana",
                    },
                    {
                        data: "baik",
                        name: "baik",
                    },
                    {
                        data: "rusak_ringan",
                        name: "rusak_ringan",
                    },
                    {
                        data: "rusak_berat",
                        name: "rusak_berat",
                    },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                ],
            });

            $("#createNewSarpras").click(function() {
                $("#saveBtn").val("create-sarpras");
                $("#sarpras_id").val("");
                $("#sarprasForm").trigger("reset");
                $("#modelHeading").html("Tambah Data Sarpras");
                $("#ajaxModel").modal("show");
            });

            $.ajax({
                url: "{{ url('sarana/get-sarana') }}",
                type: "POST",
                dataType: 'json',
                success: function(result) {
                    if (result.length == 0) {
                        $('#sarana_id').html(
                            '<option disable>--Data Sarana Kosong--.</option>'
                        );
                    } else {
                        $('#sarana_id').html(
                            '<option value="">--:---</option>');
                    }
                    $.each(result, function(key, value) {
                        $("#sarana_id").append('<option value="' +
                            value
                            .id + '">' + value.sarana + '</option>');
                    });
                }
            });

            $("body").on("click", ".editSarpras", function() {
                var sarpras_id = $(this).data("id");
                $.get("{{ route('sarpras.index') }}" + "/" + sarpras_id + "/edit", function(data) {
                    $("#modelHeading").html("Edit Data Sarpras");
                    $("#saveBtn").val("edit-sarpras");
                    $("#ajaxModel").modal("show");
                    $("#sarpras_id").val(data.id);
                    $("#sarana_id").val(data.sarana_id);
                    $("#baik").val(data.baik);
                    $("#rusak_ringan").val(data.rusak_ringan);
                    $("#rusak_berat").val(data.rusak_berat);
                    $("#keterangan").val(data.keterangan);
                    $.ajax({
                        url: "{{ url('sarana/get-sarana') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(result) {
                            if (result.length == 0) {
                                $('#sarana_id').html(
                                    '<option disable>--Data Sarana Kosong--.</option>'
                                );
                            } else {
                                $('#sarana_id').html(
                                    '<option value="">--:---</option>');
                            }
                            $.each(result, function(key, value) {
                                $("#sarana_id").append('<option value="' +
                                    value
                                    .id + '">' + value.sarana + '</option>');
                            });
                            $('#sarana_id option[value=' +
                                data.sarana_id + ']').prop(
                                'selected', true);
                        }
                    });
                });
            });

            $("#saveBtn").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
                );

                $.ajax({
                    data: $("#sarprasForm").serialize(),
                    url: "{{ route('sarpras.store') }}",
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
                                $("#saveBtn").html("Simpan");
                            });
                        } else {
                            table.draw();
                            alertSuccess("Data Sarpras saved succesfully.");
                            $("#saveBtn").html("Simpan");
                            $('#ajaxModel').modal('hide');
                        }
                    },
                });
            });
            $("body").on("click", ".deleteSarpras", function() {
                var sarpras_id = $(this).data("id");
                $("#modelHeadingHps").html("Hapus");
                $("#ajaxModelHps").modal("show");
                $("#hapusBtn").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menghapus...</i></span>"
                    );
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('sarpras.store') }}" + "/" + sarpras_id,
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
                                    );
                                });
                            } else {
                                table.draw();
                                alertSuccess(data.success);
                                $("#hapusBtn").html(
                                    "<i class='fa fa-trash'></i>Hapus");
                                $('#ajaxModelHps').modal('hide');
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
