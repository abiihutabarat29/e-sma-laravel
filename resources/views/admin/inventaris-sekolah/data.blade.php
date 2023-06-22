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
                            <a href="javascript:void(0)" id="createNewInventaris" class="btn btn-info btn-xs float-right">
                                <i class="fas fa-plus-circle"></i> Tambah</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th style="width:5%">No</th>
                                        <th>Jenis Inventaris</th>
                                        <th class="text-center" style="width: 5%">D</th>
                                        <th class="text-center" style="width: 5%">A</th>
                                        <th class="text-center" style="width: 5%">K</th>
                                        <th class="text-center" style="width: 5%">L</th>
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
                    <form id="inventarisForm" name="inventarisForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="inventarissekolah_id" id="inventarissekolah_id">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Inventaris<span class="text-danger">*</span></label>
                                <select class="form-control select2bs4" id="inventaris_id" name="inventaris_id"
                                    style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Dibutuhkan<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="dibutuhkan" name="dibutuhkan"
                                    placeholder="example : 10">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Ada<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="ada" name="ada"
                                    placeholder="example : 10">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Kurang<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="kurang" name="kurang"
                                    placeholder="example : 10">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Lebih<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="lebih" name="lebih"
                                    placeholder="example : 10">
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
                        <h6>Apakah anda yakin menghapus Data Inventaris ini ?</h6>
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
                ajax: "{{ route('inventaris-sekolah.index') }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    {
                        data: "inventaris",
                        name: "inventaris",
                    },
                    {
                        data: "dibutuhkan",
                        name: "dibutuhkan",
                    },
                    {
                        data: "ada",
                        name: "ada",
                    },
                    {
                        data: "kurang",
                        name: "kurang",
                    },
                    {
                        data: "lebih",
                        name: "lebih",
                    },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                ],
            });

            $("#createNewInventaris").click(function() {
                $("#saveBtn").val("create-inventaris");
                $("#inventarissekolah_id").val("");
                $("#inventarisForm").trigger("reset");
                $("#modelHeading").html("Tambah Data Inventaris");
                $("#ajaxModel").modal("show");
            });
            $.ajax({
                url: "{{ url('inventaris/get-inventaris') }}",
                type: "POST",
                dataType: 'json',
                success: function(result) {
                    if (result.length == 0) {
                        $('#inventaris_id').html(
                            '<option disable>--Data Inventaris Kosong--.</option>'
                        );
                    } else {
                        $('#inventaris_id').html(
                            '<option value="">--:---</option>');
                    }
                    $.each(result, function(key, value) {
                        $("#inventaris_id").append('<option value="' +
                            value
                            .id + '">' + value.inventaris + '</option>');
                    });
                }
            });
            $("body").on("click", ".editInventaris", function() {
                var inventarissekolah_id = $(this).data("id");
                $.get("{{ route('inventaris-sekolah.index') }}" + "/" + inventarissekolah_id + "/edit",
                    function(
                        data) {
                        $("#modelHeading").html("Edit Data Inventaris");
                        $("#saveBtn").val("edit-inventaris");
                        $("#ajaxModel").modal("show");
                        $("#inventarissekolah_id").val(data.id);
                        $("#inventaris_id").val(data.inventaris_id);
                        $("#dibutuhkan").val(data.dibutuhkan);
                        $("#ada").val(data.ada);
                        $("#kurang").val(data.kurang);
                        $("#lebih").val(data.lebih);
                        $.ajax({
                            url: "{{ url('inventaris/get-inventaris') }}",
                            type: "POST",
                            dataType: 'json',
                            success: function(result) {
                                if (result.length == 0) {
                                    $('#inventaris_id').html(
                                        '<option disable>--Data Inventaris Kosong--.</option>'
                                    );
                                } else {
                                    $('#inventaris_id').html(
                                        '<option value="">--:---</option>');
                                }
                                $.each(result, function(key, value) {
                                    $("#inventaris_id").append('<option value="' +
                                        value
                                        .id + '">' + value.inventaris +
                                        '</option>');
                                });
                                $('#inventaris_id option[value=' +
                                    data.inventaris_id + ']').prop(
                                    'selected', true);
                            }
                        });
                    });
            });

            $("#saveBtn").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
                ).attr('disabled', 'disabled');
                $.ajax({
                    data: $("#inventarisForm").serialize(),
                    url: "{{ route('inventaris-sekolah.store') }}",
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
                            alertSuccess("Data Inventaris saved succesfully.");
                            $("#saveBtn").html("Simpan").removeAttr('disabled');
                            $('#ajaxModel').modal('hide');
                        }
                    },
                });
            });
            $("body").on("click", ".deleteInventaris", function() {
                var inventarissekolah_id = $(this).data("id");
                $("#modelHeadingHps").html("Hapus");
                $("#ajaxModelHps").modal("show");
                $("#hapusBtn").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menghapus...</i></span>"
                    ).attr('disabled', 'disabled');
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('inventaris-sekolah.store') }}" + "/" +
                            inventarissekolah_id,
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
                                    ).removeAttr('disabled');
                                });
                            } else {
                                table.draw();
                                alertSuccess(data.success);
                                $("#hapusBtn").html(
                                    "<i class='fa fa-trash'></i>Hapus").removeAttr(
                                    'disabled');
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
