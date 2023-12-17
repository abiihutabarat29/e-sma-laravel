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
                    {{-- Kelompok dan Sub Kelompok --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Kelompok Utama
                                        <a href="javascript:void(0)" id="createKelompok"
                                            class="btn bg-gradient-primary btn-xs float-right">
                                            <i class="fas fa-plus-circle"></i> Tambah</a>
                                        </h4>
                                        <hr>
                                        <table class="table table-bordered table-striped data-table-kelompok">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 20%">Kategori</th>
                                                    <th class="text-center" style="width: 5%">Kode</th>
                                                    <th>Nama</th>
                                                    <th class="text-center" style="width: 15%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                </div>
                                <div class="col-md-6">
                                    <h6>Sub Kelompok
                                        <a href="javascript:void(0)" id="createSubKelompok"
                                            class="btn bg-gradient-primary btn-xs float-right">
                                            <i class="fas fa-plus-circle"></i> Tambah</a>
                                        </h4>
                                        <hr>
                                        <table class="table table-bordered table-striped data-table-subkelompok">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 5%">Kode</th>
                                                    <th>Nama</th>
                                                    <th class="text-center" style="width: 25%">Kel. Utama</th>
                                                    <th class="text-center" style="width: 15%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Mapel --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="float-left">Daftar Mata Pelajaran
                            </h5>
                            <a href="javascript:void(0)" id="createNewMapel"
                                class="btn bg-gradient-primary btn-xs float-right">
                                <i class="fas fa-plus-circle"></i> Tambah</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th style="width:5%">No</th>
                                        <th>Mata Pelajaran</th>
                                        <th class="text-center" style="width: 10%">Action</th>
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
@endsection
@section('modal')
    {{-- Modal Kelompok --}}
    <div class="modal fade" id="ajaxModelKel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeadingKel"></h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="kelompokForm" name="kelompokForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="kelompokId" id="kelompokId">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Kategori<span class="text-danger">*</span></label>
                                <select class="browser-default custom-select select2bs4" name="kategori_id"
                                    id="kategori_id">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Kode<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="kode" name="kode">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Nama<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm" id="saveBtnKel"
                                    value="create">Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal SubKelompok --}}
    <div class="modal fade" id="ajaxModelSubKel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeadingSubKel"></h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="subkelompokForm" name="subkelompokForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="subkelompokId" id="subkelompokId">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Kel. Utama<span class="text-danger">*</span></label>
                                <select class="browser-default custom-select select2bs4" name="kelompok_id"
                                    id="kelompok_id">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Kode<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="kodeSub" name="kodeSub">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Nama<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="namaSub" name="namaSub">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm" id="saveBtnSubKel"
                                    value="create">Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Mapel --}}
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
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
                    <form id="mapelForm" name="mapelForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="mapel_id" id="mapel_id">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Mata Pelajaran<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="mapel" name="mapel"
                                    placeholder="Mata Pelajaran">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm" id="saveBtn"
                                    value="create">Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Delete Mapel --}}
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
                        <h6>Apakah anda yakin menghapus Mata Pelajaran ini ?</h6>
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
    {{-- Modal Delete Kelompok --}}
    <div class="modal fade" id="ajaxModelHpsKel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modelHeadingHpsKel">
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
                        <h6>Apakah anda yakin menghapus Kelompok <b><span class="text-danger" id="deleteKel"></span></b>
                            ini ?</h6>
                    </center>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-danger btn-sm " id="hapusBtnKel"><i class="fa fa-trash"></i>
                        Hapus</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Delete Sub Kelompok --}}
    <div class="modal fade" id="ajaxModelHpsSubKel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modelHeadingHpsSubKel">
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
                        <h6>Apakah anda yakin menghapus Sub Kelompok <b><span class="text-danger"
                                    id="deleteSubKel"></span></b>
                            ini ?</h6>
                    </center>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-danger btn-sm " id="hapusBtnSubKel"><i
                            class="fa fa-trash"></i>
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

            var tableKel = $(".data-table-kelompok").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 10,
                lengthMenu: [10, 50, 100, 200, 500],
                lengthChange: true,
                autoWidth: false,
                ajax: "{{ route('kelompok.data') }}",
                columns: [{
                        data: "kategori",
                        name: "kategori",
                    },
                    {
                        data: "kode",
                        name: "kode",
                    },
                    {
                        data: "nama_kelompok",
                        name: "nama_kelompok",
                    },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                ],
            });
            var tableSubKel = $(".data-table-subkelompok").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 10,
                lengthMenu: [10, 50, 100, 200, 500],
                lengthChange: true,
                autoWidth: false,
                ajax: "{{ route('subkelompok.data') }}",
                columns: [{
                        data: "kode",
                        name: "kode",
                    },
                    {
                        data: "nama_subkel",
                        name: "nama_subkel",
                    },
                    {
                        data: "kelompok",
                        name: "kelompok",
                    },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                ],
            });
            var table = $(".data-table").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 10,
                lengthMenu: [10, 50, 100, 200, 500],
                lengthChange: true,
                autoWidth: false,
                ajax: "{{ route('mata-pelajaran.index') }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    {
                        data: "mapel",
                        name: "mapel",
                    },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                ],
            });

            $("#createKelompok").click(function() {
                $("#saveBtn").val("create-kelompok");
                $("#kelompok_id").val("");
                $("#kelompokForm").trigger("reset");
                $("#modelHeadingKel").html("Tambah Kelompok");
                $("#ajaxModelKel").modal("show");
                $.ajax({
                    url: "{{ url('kategori/get-kategori-mapel') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(result) {
                        $('#kategori_id').html(
                            '<option value="">:::Pilih Kategori:::</option>');
                        $.each(result, function(key, value) {
                            $("#kategori_id").append('<option value="' + value
                                .id + '">' + value.kategori + '</option>');
                        });
                    }
                });
            });
            $("body").on("click", ".editKel", function() {
                var kelompokId = $(this).data("id");
                $.get("{{ route('kelompok.store') }}" + "/" + kelompokId + "/edit", function(data) {
                    $("#modelHeadingKel").html("Edit kelompok Mapel");
                    $("#saveBtnKel").val("edit-kelompok-mapel");
                    $("#ajaxModelKel").modal("show");
                    $("#kelompokId").val(data.id);
                    $.ajax({
                        url: "{{ url('kategori/get-kategori-mapel') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(result) {
                            $('#kategori_id').html(
                                '<option value="">:::Pilih Kategori:::</option>');
                            $.each(result, function(key, value) {
                                $("#kategori_id").append('<option value="' +
                                    value.id + '">' + value.kategori +
                                    '</option>');
                                $('#kategori_id option[value=' +
                                    data.kategori_id + ']').prop(
                                    'selected', true);
                            });
                        }
                    });
                    $("#kode").val(data.kode);
                    $("#nama").val(data.nama_kelompok);
                });
            });

            $("#saveBtnKel").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
                ).attr('disabled', 'disabled');
                $.ajax({
                    data: $("#kelompokForm").serialize(),
                    url: "{{ route('kelompok.store') }}",
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
                                $("#saveBtnKel").html("Simpan").removeAttr('disabled');
                            });
                        } else {
                            tableKel.draw();
                            alertSuccess(data.success);
                            $("#saveBtnKel").html("Simpan").removeAttr('disabled');
                            $('#ajaxModelKel').modal('hide');
                        }
                    },
                });
            });

            $("body").on("click", ".deleteKel", function() {
                var kelompokId = $(this).data("id");
                var nama = $(this).data('kelompok');
                $("#ajaxModelHpsKel").modal("show");
                $("#modelHeadingHpsKel").html("Hapus");
                $('#ajaxModelHpsKel').find('#deleteKel').text(nama);
                $("#hapusBtnKel").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menghapus...</i></span>"
                    ).attr('disabled', 'disabled');
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('kelompok.store') }}" + "/" + kelompokId +
                            "/destroy",
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
                                    $("#hapusBtnKel").html(
                                        "<i class='fa fa-trash'></i> Hapus"
                                    ).removeAttr('disabled');
                                });
                            } else {
                                tableKel.draw();
                                alertSuccess(data.success);
                                $("#hapusBtnKel").html(
                                    "<i class='fa fa-trash'></i> Hapus").removeAttr(
                                    'disabled');
                                $('#ajaxModelHpsKel').modal('hide');
                            }
                        },
                    });
                });
            });

            $("#createSubKelompok").click(function() {
                $("#saveBtnSubKel").val("create-subkelompok");
                $("#subkelompok_id").val("");
                $("#subkelompokForm").trigger("reset");
                $("#modelHeadingSubKel").html("Tambah Sub Kelompok");
                $("#ajaxModelSubKel").modal("show");
                $.ajax({
                    url: "{{ url('kelompok/get-kelompok-mapel') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(result) {
                        $('#kelompok_id').html(
                            '<option value="">:::Pilih Kelompok Utama:::</option>');
                        $.each(result, function(key, value) {
                            $("#kelompok_id").append('<option value="' + value
                                .id + '">' + value.nama_kelompok + '</option>');
                        });
                    }
                });
            });

            $("body").on("click", ".editSubKel", function() {
                var subkelompokId = $(this).data("id");
                $.get("{{ route('subkelompok.store') }}" + "/" + subkelompokId + "/edit", function(data) {
                    $("#modelHeadingSubKel").html("Edit Sub Kelompok Mapel");
                    $("#saveBtnSubKel").val("edit-subkelompok-mapel");
                    $("#ajaxModelSubKel").modal("show");
                    $("#subkelompokId").val(data.id);
                    $.ajax({
                        url: "{{ url('kelompok/get-kelompok-mapel') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(result) {
                            $('#kelompok_id').html(
                                '<option value="">:::Pilih Kelompok Utama:::</option>'
                            );
                            $.each(result, function(key, value) {
                                $("#kelompok_id").append('<option value="' +
                                    value.id + '">' + value.nama_kelompok +
                                    '</option>');
                                $('#kelompok_id option[value=' +
                                    data.kelompok_id + ']').prop(
                                    'selected', true);
                            });
                        }
                    });
                    $("#kodeSub").val(data.kode);
                    $("#namaSub").val(data.nama_subkelompok);
                });
            });

            $("#saveBtnSubKel").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
                ).attr('disabled', 'disabled');
                $.ajax({
                    data: $("#subkelompokForm").serialize(),
                    url: "{{ route('subkelompok.store') }}",
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
                                $("#saveBtnSubKel").html("Simpan").removeAttr(
                                    'disabled');
                            });
                        } else {
                            tableSubKel.draw();
                            alertSuccess(data.success);
                            $("#saveBtnSubKel").html("Simpan").removeAttr('disabled');
                            $('#ajaxModelSubKel').modal('hide');
                        }
                    },
                });
            });

            $("body").on("click", ".deleteSubKel", function() {
                var subkelompokId = $(this).data("id");
                var nama = $(this).data('subkelompok');
                $("#ajaxModelHpsSubKel").modal("show");
                $("#modelHeadingHpsSubKel").html("Hapus");
                $('#ajaxModelHpsSubKel').find('#deleteSubKel').text(nama);
                $("#hapusBtnSubKel").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menghapus...</i></span>"
                    ).attr('disabled', 'disabled');
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('subkelompok.store') }}" + "/" + kelompokId +
                            "/destroy",
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
                                    $("#hapusBtnSubKel").html(
                                        "<i class='fa fa-trash'></i> Hapus"
                                    ).removeAttr('disabled');
                                });
                            } else {
                                tableSubKel.draw();
                                alertSuccess(data.success);
                                $("#hapusBtnSubKel").html(
                                    "<i class='fa fa-trash'></i> Hapus").removeAttr(
                                    'disabled');
                                $('#ajaxModelHpsSubKel').modal('hide');
                            }
                        },
                    });
                });
            });

            $("#createNewMapel").click(function() {
                $("#saveBtn").val("create-mapel");
                $("#mapel_id").val("");
                $("#mapelForm").trigger("reset");
                $("#modelHeading").html("Tambah Mata Pelajaran");
                $("#ajaxModel").modal("show");
            });

            $("body").on("click", ".editMapel", function() {
                var mapel_id = $(this).data("id");
                $.get("{{ route('mata-pelajaran.index') }}" + "/" + mapel_id + "/edit", function(data) {
                    $("#modelHeading").html("Edit Mata Pelajaran");
                    $("#saveBtn").val("edit-mapel");
                    $("#ajaxModel").modal("show");
                    $("#mapel_id").val(data.id);
                    $("#mapel").val(data.mapel);
                });
            });

            $("#saveBtn").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
                ).attr('disabled', 'disabled');
                $.ajax({
                    data: $("#mapelForm").serialize(),
                    url: "{{ route('mata-pelajaran.store') }}",
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
                            alertSuccess("Mata Pelajaran berhasil ditambah");
                            $("#saveBtn").html("Simpan").removeAttr('disabled');
                            $('#ajaxModel').modal('hide');
                        }
                    },
                });
            });
            $("body").on("click", ".deleteMapel", function() {
                var mapel_id = $(this).data("id");
                $("#modelHeadingHps").html("Hapus");
                $("#ajaxModelHps").modal("show");
                $("#hapusBtn").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menghapus...</i></span>"
                    ).attr('disabled', 'disabled');
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('mata-pelajaran.store') }}" + "/" + mapel_id,
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
