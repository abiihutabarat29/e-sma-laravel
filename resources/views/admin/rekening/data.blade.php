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
                            <div class="col-2">
                                <div>Kegiatan</div>
                            </div>
                            <div class="col-10">
                                <div>: {{ $subkegiatan->kegiatan->kode_kegiatan ?? 'None' }}
                                    {{ $subkegiatan->kegiatan->nama_kegiatan ?? 'None' }}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <div>Sub Kegiatan</div>
                            </div>
                            <div class="col-10">
                                <div>: {{ $subkegiatan->kode_sub ?? 'None' }} {{ $subkegiatan->nama_sub ?? 'None' }}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <div>Bagian</div>
                            </div>
                            <div class="col-10">
                                <div>: {{ $subkegiatan->kegiatan->bagian->nama_bagian ?? 'None' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="javascript:void(0)" id="createNewRekening" class="btn btn-info btn-xs">
                                <i class="fas fa-plus-circle"></i> Tambah
                            </a>
                            <a href="{{ route('subkegiatan.index', Crypt::encryptString($subkegiatan->kegiatan->id)) ?? 'None' }}"
                                id="createNewSubkeg" class="btn btn-warning btn-xs float-right">
                                <i class="fas fa-reply"></i> Kembali
                            </a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="data-table" class="table table-bordered table-striped ">
                                <thead>
                                    <tr>
                                        <th style="width:3%">No</th>
                                        <th style="width:15%">Kode Rekening</th>
                                        <th>Nama Rekening</th>
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
                    <form id="rekeningForm" name="rekeningForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" id="kegiatan_id" name="kegiatan_id"
                            value="{{ $subkegiatan->kegiatan->id ?? 'None' }}">
                        <input type="hidden" id="subkegiatan_id" name="subkegiatan_id"
                            value="{{ $subkegiatan->id ?? 'None' }}">
                        <input type="hidden" name="rekening_id" id="rekening_id">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Kegiatan</label>
                                    <input type="text" class="form-control"
                                        placeholder="{{ $subkegiatan->kegiatan->kode_kegiatan ?? 'None' }} {{ $subkegiatan->kegiatan->nama_kegiatan ?? 'None' }}"
                                        disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Sub Kegiatan</label>
                                    <input type="text" class="form-control"
                                        placeholder="{{ $subkegiatan->kode_sub ?? 'None' }} {{ $subkegiatan->nama_sub ?? 'None' }}"
                                        disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Kode Rekening<span class="text-danger">
                                            *</span></label>
                                    <input type="text" class="form-control" id="kode_rekening" name="kode_rekening"
                                        placeholder="Kode Rekening">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nama Rekening<span class="text-danger">
                                            *</span></label>
                                    <input type="text" class="form-control" id="nama_rekening" name="nama_rekening"
                                        placeholder="Nama Rekening">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Pagu Rekening<span class="text-danger">
                                            *</span></label>
                                    <input type="text" class="form-control rupiah" id="pagu_rekening"
                                        name="pagu_rekening" placeholder="Pagu Rekening">
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
                        <h6>Apakah anda yakin menghapus Rekening ini ?</h6>
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
        var rupiah = document.getElementById("pagu_rekening");
        rupiah.addEventListener("keyup", function(e) {
            rupiah.value = formatRupiah(this.value, "Rp. ");
        });


        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
        }

        $(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            var table = $("#data-table").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                dom: 'Bfrtip',
                buttons: ["excel", "pdf", "print", "colvis"],
                ajax: "{{ route('rekening.index', $id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'kode_rekening',
                        name: 'kode_rekening'
                    },
                    {
                        data: 'nama_rekening',
                        name: 'nama_rekening'
                    },
                    {
                        data: 'pagu_rekening',
                        name: 'pagu_rekening'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            })


            $("#createNewRekening").click(function() {
                $("#saveBtn").val("create-rekening");
                $("#rekening_id").val("");
                $("#rekeningForm").trigger("reset");
                $("#modelHeading").html("Tambah Rekening");
                $("#ajaxModel").modal("show");
                $("#deleteRekening").modal("show");
            });

            $("body").on("click", ".editRekening", function() {
                var rekening_id = $(this).data("id");
                $.get("{{ route('rekening.index', $rekening->subkegiatan->id ?? 'None') }}" + "/" +
                    rekening_id + "/edit",
                    function(data) {
                        $("#modelHeading").html("Edit Rekening");
                        $("#saveBtn").val("edit-rekening");
                        $("#ajaxModel").modal("show");
                        $("#kegiatan_id").val(data.kegiatan_id);
                        $("#subkegiatan_id").val(data.subkegiatan_id);
                        $("#rekening_id").val(data.id);
                        $("#kode_rekening").val(data.kode_rekening);
                        $("#nama_rekening").val(data.nama_rekening);
                        $("#pagu_rekening").val(data.pagu_rekening);
                    });
            });

            $("#saveBtn").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
                );
                var rekening_id = $("#rekening_id").val();
                if (rekening_id == '') {
                    $.ajax({
                        data: $("#rekeningForm").serialize(),
                        url: "{{ route('rekening.store') }}",
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
                                    // $('#rekeningForm').trigger("reset");
                                });
                            } else {
                                table.draw();
                                alertSuccess(data.success);
                                $('#rekeningForm').trigger("reset");
                                $("#saveBtn").html("Simpan");
                                $('#ajaxModel').modal('hide');
                            }
                        },
                    });
                } else {
                    var rekening_id = $("#rekening_id").val();
                    $.ajax({
                        data: $("#rekeningForm").serialize(),
                        url: "{{ route('rekening.store') }}" + "/" + rekening_id + "/update",
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
                                    // $('#rekeningForm').trigger("reset");
                                });
                            } else {
                                table.draw();
                                alertSuccess(data.success);
                                $('#rekeningForm').trigger("reset");
                                $("#saveBtn").html("Simpan");
                                $('#ajaxModel').modal('hide');
                            }
                        },
                    });
                }
            });
            $("body").on("click", ".deleteRekening", function() {
                var rekening_id = $(this).data("id");
                $("#modelHeadingHps").html("Hapus");
                $("#ajaxModelHps").modal("show");
                $("#hapusBtn").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menghapus...</i></span>"
                    );
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('rekening.store') }}" + "/" + rekening_id +
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
