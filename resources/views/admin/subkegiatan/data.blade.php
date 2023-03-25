@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card mt-4">
                <div class="card-header">
                    <span class="text-bold">{{ $menu }}</span>
                </div>
                <div class="card-body">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-1">
                                <div>Kegiatan</div>
                            </div>
                            <div class="col-8">
                                <div>: {{ $kegiatan->kode_kegiatan ?? 'None' }}
                                    {{ $kegiatan->nama_kegiatan ?? 'None' }}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-1">
                                <div>Bagian</div>
                            </div>
                            <div class="col-8">
                                <div>: {{ $kegiatan->bagian->nama_bagian ?? 'None' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="javascript:void(0)" id="createNewSubkeg" class="btn btn-info btn-xs">
                                <i class="fas fa-plus-circle"></i> Tambah
                            </a>
                            <a href="{{ route('kegiatan.index') }}" id="createNewSubkeg"
                                class="btn btn-warning btn-xs float-right">
                                <i class="fas fa-reply"></i> Kembali
                            </a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th style="width:3%">No</th>
                                        <th style="width:15%">Kode Sub Kegiatan</th>
                                        <th>Nama Sub Kegiatan</th>
                                        <th style="width:13%">Jumlah</th>
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
                    <form id="subkegForm" name="subkegForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" id="kegiatan_id" name="kegiatan_id" value="{{ $kegiatan->id ?? 'None' }}">
                        <input type="hidden" id="subkeg_id" name="subkeg_id">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Kegiatan</label>
                                    <input type="text" class="form-control"
                                        placeholder="{{ $kegiatan->kode_kegiatan ?? 'None' }} {{ $kegiatan->nama_kegiatan ?? 'None' }}"
                                        disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Kode Sub Kegiatan<span class="text-danger">
                                            *</span></label>
                                    <input type="text" class="form-control" id="kode_sub" name="kode_sub"
                                        placeholder="Kode Sub">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nama Sub Kegiatan<span class="text-danger">
                                            *</span></label>
                                    <input type="text" class="form-control" id="nama_sub" name="nama_sub"
                                        placeholder="Nama Sub">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm" id="saveBtn" value="create">Simpan
                            </button>
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
                        <h6>Apakah anda yakin menghapus Sub Kegiatan ini ?</h6>
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
                lengthChange: false,
                autoWidth: false,
                dom: 'Bfrtip',
                buttons: ["excel", "pdf", "print", "colvis"],
                ajax: "{{ route('subkegiatan.index', $id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'kode_subkeg',
                        name: 'kode_subkeg'
                    },
                    {
                        data: 'nama_subkeg',
                        name: 'nama_subkeg'
                    },
                    {
                        data: 'pagu_sub',
                        name: 'pagu_sub'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $("#createNewSubkeg").click(function() {
                $("#saveBtn").val("create-subkeg");
                $("#subkeg_id").val("");
                $("#subkegForm").trigger("reset");
                $("#modelHeading").html("Tambah Sub Kegiatan");
                $("#ajaxModel").modal("show");
                $("#deleteSubkeg").modal("show");
            });

            $("body").on("click", ".editSubkeg", function() {
                var subkeg_id = $(this).data("id");
                $.get("{{ route('subkegiatan.index', $subkegiatan->kegiatan->id ?? 'None') }}" + "/" +
                    subkeg_id +
                    "/edit",
                    function(data) {
                        $("#modelHeading").html("Edit Sub Kegiatan");
                        $("#saveBtn").val("edit-subkeg");
                        $("#ajaxModel").modal("show");
                        $("#subkeg_id").val(data.id);
                        $("#kegiatan_id").val(data.kegiatan_id);
                        $("#kode_sub").val(data.kode_sub);
                        $("#nama_sub").val(data.nama_sub);
                    });
            });

            $("#saveBtn").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
                );

                $.ajax({
                    data: $("#subkegForm").serialize(),
                    url: "{{ route('subkegiatan.store') }}",
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
                            alertSuccess(data.success);
                            $('#subkegForm').trigger("reset");
                            $("#saveBtn").html("Simpan");
                            $('#ajaxModel').modal('hide');
                        }
                    },
                });
            });
            $("body").on("click", ".deleteSubkeg", function() {
                var subkeg_id = $(this).data("id");
                $("#modelHeadingHps").html("Hapus");
                $("#ajaxModelHps").modal("show");
                $("#hapusBtn").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menghapus...</i></span>"
                    );
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('subkegiatan.store') }}" + "/" + subkeg_id +
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
                                    $("#hapusBtn").html(
                                        "<i class='fa fa-trash'></i>"
                                    );
                                });
                            } else {
                                table.draw();
                                alertSuccess(data.success);
                                $("#hapusBtn").html(
                                    "<i class='fa fa-trash'></i>");
                                $('#ajaxModelHps').modal('hide');
                            }
                        },
                    });
                });
            });
        });
    </script>
@endsection
