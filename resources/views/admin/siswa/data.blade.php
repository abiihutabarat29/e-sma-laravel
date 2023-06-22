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
                            <a href="{{ route('siswa.create') }}" class="btn btn-info btn-sm float-left mr-2"
                                title="Tambah Siswa/i Baru">
                                <i class="fas fa-plus-circle"></i> Tambah</a>
                            <button id="nonAktif" class="btn btn-warning btn-sm float-left mr-2 text-white"
                                title="Nonaktifkan Siswa/i Baru" disabled>
                                <i class="fas fa-ban"></i> Nonaktif</button>
                            <button id="deleteAll" class="btn btn-danger btn-sm float-left" title="Hapus Siswa Pilihan"
                                disabled>
                                <i class="fas fa-trash"></i> Hapus</button>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%"><input type="checkbox" id="selectAll">
                                        </th>
                                        <th style="width:5%">No</th>
                                        <th style="width:10%">NISN</th>
                                        <th>Nama</th>
                                        <th style="width:8%">Kelas</th>
                                        <th style="width:8%">Status</th>
                                        <th style="width:8%">Foto</th>
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
                        <h6>Apakah anda yakin menghapus data <b><span class="text-danger" id="deleteNama"></span></b> ini ?
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
    {{-- Modal Delete Multiple --}}
    <div class="modal fade" id="ajaxModelHpsAll">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modelHeadingHpsAll">
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
                        <h6>Apakah anda yakin menghapus <b><span class="text-danger" id="deleteCount"></span></b> siswa ini
                            ?</h6>
                    </center>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-danger btn-sm " id="hapusAll"><i class="fa fa-trash"></i>
                        Hapus</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Nonaktif --}}
    <div class="modal fade" id="ajaxModelHpsNon">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modelHeadingHpsNon">
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
                        <h6>Apakah anda yakin menonaktifkan <b><span class="text-danger" id="deleteCount"></span></b>
                            siswa
                            ini
                            ?</h6>
                    </center>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-warning btn-sm text-white" id="nonAktifkan"><i
                            class="fa fa-ban"></i>
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
                ajax: "{{ route('siswa.index') }}",
                columns: [{
                        data: "checkbox",
                        name: "checkbox",
                        orderable: false,
                        searchable: false,
                    }, {
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
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
                        data: "sts_siswa",
                        name: "sts_siswa",
                    },
                    {
                        data: "foto",
                        name: "foto",
                    },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                ],
            });

            $("body").on("click", ".deleteSiswa", function() {
                var siswa_id = $(this).data("id");
                var nama = $(this).data('nama');
                $("#ajaxModelHps").modal("show");
                $("#modelHeadingHps").html("Hapus");
                $('#ajaxModelHps').find('#deleteNama').text(nama);
                $("#hapusBtn").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menghapus...</i></span>"
                    ).attr('disabled', 'disabled');
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('siswa.store') }}" + "/" + siswa_id + "/destroy",
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
                                    ).removeAttr(
                                        'disabled');
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
            $("body").on("click", "#nonAktif", function() {
                var SiswaId = [];
                var count = 0;
                // Dapatkan nilai checkbox yang dipilih
                $('input[name="siswaCheck[]"]:checked').each(function() {
                    SiswaId.push($(this).val());
                    count++;
                });
                $("#ajaxModelHpsNon").modal("show");
                $("#modelHeadingHpsNon").html("Nonaktifkan Siswa/i");
                $('#ajaxModelHpsNon').data('count', count);
                $("#ajaxModelHpsNon").find("#deleteCount").text(count);
                $("#nonAktifkan").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menonaktifkan...</i></span>"
                    ).attr('disabled', 'disabled');
                    $.ajax({
                        url: "{{ route('siswa.nonaktif') }}",
                        type: "POST",
                        dataType: "json",
                        data: {
                            SiswaId: SiswaId
                        },
                        success: function(data) {
                            $('#selectAll').prop('checked', false);
                            $('#deleteAll').prop('disabled', true);
                            $('#nonAktif').prop('disabled', true);
                            console.log(data.errors);
                            if (data.errors) {
                                $('.alert-danger').html('');
                                $.each(data.errors, function(key, value) {
                                    $('.alert-danger').show();
                                    $('.alert-danger').append('<strong><li>' +
                                        value +
                                        '</li></strong>');
                                    $(".alert-danger").fadeOut(5000);
                                    $("#nonAktifkan").html(
                                        "<i class='fa fa-ban'></i> Nonaktifkan"
                                    ).removeAttr('disabled');
                                });
                            } else {
                                table.draw();
                                alertSuccess(data.success);
                                $("#nonAktifkan").html(
                                        "<i class='fa fa-ban'></i> Nonaktifkan")
                                    .removeAttr(
                                        'disabled');
                                $('#ajaxModelHpsNon').modal('hide');
                            }
                        },
                    });
                });
            });
            $("body").on("click", "#deleteAll", function() {
                var SiswaId = [];
                var count = 0;
                // Dapatkan nilai checkbox yang dipilih
                $('input[name="siswaCheck[]"]:checked').each(function() {
                    SiswaId.push($(this).val());
                    count++;
                });
                $("#ajaxModelHpsAll").modal("show");
                $("#modelHeadingHpsAll").html("Hapus");
                $('#ajaxModelHpsAll').data('count', count);
                $("#ajaxModelHpsAll").find("#deleteCount").text(count);
                $("#hapusAll").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menghapus...</i></span>"
                    ).attr('disabled', 'disabled');
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('siswa.delete.multiple') }}",
                        data: {
                            SiswaId: SiswaId
                        },
                        success: function(data) {
                            $('#selectAll').prop('checked', false);
                            $('#deleteAll').prop('disabled', true);
                            $('#nonAktif').prop('disabled', true);
                            console.log(data.errors);
                            if (data.errors) {
                                $('.alert-danger').html('');
                                $.each(data.errors, function(key, value) {
                                    $('.alert-danger').show();
                                    $('.alert-danger').append('<strong><li>' +
                                        value +
                                        '</li></strong>');
                                    $(".alert-danger").fadeOut(5000);
                                    $("#hapusAll").html(
                                        "<i class='fa fa-trash'></i> Hapus"
                                    ).removeAttr('disabled');
                                });
                            } else {
                                table.draw();
                                alertSuccess(data.success);
                                $("#hapusAll").html(
                                    "<i class='fa fa-trash'></i> Hapus").removeAttr(
                                    'disabled');
                                $('#ajaxModelHpsAll').modal('hide');
                            }
                        },
                    });
                });
            });
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
        //select all
        $(document).ready(function() {
            // Checkbox "Pilih Semua"
            $('#selectAll').click(function() {
                $('.row-checkbox').prop('checked', $(this).prop('checked'));
            });
            // Periksa apakah checkbox "Pilih Semua" harus dicentang
            $('.row-checkbox').click(function() {
                if ($('.row-checkbox:checked').length === $('.row-checkbox').length) {
                    $('#selectAll').prop('checked', true);
                } else {
                    $('#selectAll').prop('checked', false);
                }
            });
        });
        // Ketika checkbox dipilih atau tidak dipilih
        $(document).on('change', '.row-checkbox', function() {
            var selected = $('.row-checkbox:checked');
            var selectedAll = $('#selectAll');

            if (selected.length > 0 || (selectedAll.length > 0 && selectedAll.is(':checked'))) {
                // Jika ada checkbox yang dipilih atau selectAll terpilih, aktifkan button
                $('#deleteAll').prop('disabled', false);
                $('#nonAktif').prop('disabled', false);
            } else {
                // Jika tidak ada checkbox yang dipilih, nonaktifkan button
                $('#deleteAll').prop('disabled', true);
                $('#nonAktif').prop('disabled', true);
            }
        });

        // Ketika selectAll checkbox di klik
        $(document).on('change', '#selectAll', function() {
            var checkboxes = $('.row-checkbox');

            checkboxes.prop('checked', $(this).is(':checked'));

            if ($(this).is(':checked')) {
                // Jika selectAll terpilih, aktifkan button
                $('#deleteAll').prop('disabled', false);
                $('#nonAktif').prop('disabled', false);
            } else {
                // Jika selectAll tidak terpilih, nonaktifkan button
                $('#deleteAll').prop('disabled', true);
                $('#nonAktif').prop('disabled', true);
            }
        });
    </script>
@endsection
