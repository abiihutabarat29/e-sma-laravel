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
                            <a href="javascript:void(0)" id="createNewMutasiK"class="btn btn-info btn-xs float-right">
                                <i class="fas fa-plus-circle"></i> Tambah</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th style="width:5%">No</th>
                                        <th style="width:12%">No Surat</th>
                                        <th style="width:10%">NISN</th>
                                        <th>Nama</th>
                                        <th style="width:8%">Kelas</th>
                                        <th style="width:20%">Asal</th>
                                        <th class="text-center" style="width: 5%">Action</th>
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
    <div class="modal fade" id="ajaxModel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="mutasikForm" name="mutasikForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="mutasi_id" id="mutasi_id">
                        <h6><i class="fa fa-info-circle text-danger"></i> Siswa yang telah dikeluarkan, data terkait
                            siswa tersebut akan terhapus.</h6>
                        <hr>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Siswa<span class="text-danger">*</span></label>
                                <select class="browser-default custom-select select2bs4" name="siswa_id" id="siswa_id">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">NISN</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nisn" name="nisn" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Nama</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nama" name="nama" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="kelas_id" name="kelas_id">
                            <input type="hidden" class="form-control" id="alamat" name="alamat">
                            <input type="hidden" class="form-control" id="tempat_lahir" name="tempat_lahir">
                            <input type="hidden" class="form-control" id="tgl_lahir" name="tgl_lahir">
                            <input type="hidden" class="form-control" id="gender" name="gender">
                            <input type="hidden" class="form-control" id="agama" name="agama">
                            <input type="hidden" class="form-control" id="nohp" name="nohp">
                            <input type="hidden" class="form-control" id="email" name="email">
                            <input type="hidden" class="form-control" id="tahun_masuk" name="tahun_masuk">
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nomor Surat<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('no_surat') is-invalid @enderror"
                                    id="no_surat" name="no_surat" placeholder="Nomor Surat" autocomplete="off"
                                    value="{{ old('no_surat') }}">
                                @error('no_surat')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Sekolah Tujuan<span class="text-danger">*</span></label>
                                <textarea id="sekolah_tujuan" name="sekolah_tujuan"
                                    class="form-control  @error('sekolah_tujuan') is-invalid @enderror" rows="3">{{ old('sekolah_tujuan') }}</textarea>
                                @error('sekolah_tujuan')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Keterangan<small> (Opsional)</small></label>
                                <textarea id="keterangan" name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm" id="saveBtn"
                                    value="create">Proses Mutasi
                                </button>
                            </div>
                        </div>
                    </form>
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
                        <h6>Apakah anda yakin menghapus Data ini ?</h6>
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
                ajax: "{{ route('mutasi-keluar.index') }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    {
                        data: "no_surat",
                        name: "no_surat",
                    },
                    {
                        data: "nisn",
                        name: "nisn",
                    },
                    {
                        data: "nama",
                        name: "nama",
                    },
                    {
                        data: "kelas",
                        name: "kelas",
                    },
                    {
                        data: "sekolah_tujuan",
                        name: "sekolah_tujuan",
                    },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                ],
            });
            $("#createNewMutasiK").click(function() {
                $("#saveBtn").val("create-mutasik");
                $("#mutasi_id").val("");
                $("#mutasikForm").trigger("reset");
                $("#modelHeading").html("Mutasi Keluar");
                $("#ajaxModel").modal("show");
                $.ajax({
                    url: "{{ url('siswa/get-siswa') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(result) {
                        if (result == "") {
                            $('#siswa_id').html(
                                '<option disable>::Data Siswa Tidak Tersedia::</option>'
                            );
                        } else {
                            $('#siswa_id').html(
                                '<option value="">--:---</option>');
                        }
                        $.each(result, function(key, value) {
                            $("#siswa_id").append('<option value="' +
                                value
                                .id + '">' + '(' + value.nisn + ')' + ' ' + value
                                .nama +
                                ' </option>');
                        });
                    }
                });
                $("#saveBtn").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> sedang memproses...</i></span>"
                    );

                    $.ajax({
                        data: $("#mutasikForm").serialize(),
                        url: "{{ route('mutasi-keluar.store') }}",
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
                            } else if (data.warning) {
                                alertWarning(data.warning);
                                $("#saveBtn").html("Simpan")
                                    .removeAttr("disabled");
                                $('#ajaxModel').modal('hide');
                            } else {
                                table.draw();
                                alertSuccess("Siswa dropout successfully.");
                                $("#saveBtn").html("Proses Mutasi");
                                $('#ajaxModel').modal('hide');
                            }
                        },
                    });
                });
                $('#siswa_id').on('change', function() {
                    var idSiswa = this.value;
                    console.log(idSiswa);
                    $("#nisn_id").html('');
                    $.get("{{ url('siswa') }}" + "/" + idSiswa + "/get-siswa-data", function(
                        data) {
                        $("#nisn").val(data.nisn);
                        $("#nama").val(data.nama);
                        $("#kelas_id").val(data.kelas_id);
                        $("#alamat").val(data.alamat);
                        $("#tempat_lahir").val(data.tempat_lahir);
                        $("#tgl_lahir").val(data.tgl_lahir);
                        $("#gender").val(data.gender);
                        $("#agama").val(data.agama);
                        $("#nohp").val(data.nohp);
                        $("#email").val(data.email);
                        $("#tahun_masuk").val(data.tahun_masuk);
                    });
                });
            });
            $("body").on("click", ".deleteMutasiK", function() {
                var mutasi_id = $(this).data("id");
                $("#modelHeadingHps").html("Hapus");
                $("#ajaxModelHps").modal("show");
                $("#hapusBtn").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menghapus...</i></span>"
                    ).attr('disabled', 'disabled');
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('mutasi-keluar.store') }}" + "/" + mutasi_id +
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
                                        "<i class='fa fa-info-circle'></i> Hapus"
                                    ).removeAttr('disabled');
                                });
                            } else {
                                table.draw();
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
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
@endsection
