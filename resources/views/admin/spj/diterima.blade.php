@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $menu }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $menu }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            @if ($export != null)
                                <a href="{{ route('spj.export') }}" class="btn btn-success btn-xs float-right btn-rounded">
                                    <i class="fa fa-file-export"></i> Export</a>
                            @endif
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 8%">Tanggal</th>
                                        <th>Kegiatan</th>
                                        <th>Sub Kegiatan</th>
                                        <th>Rekening</th>
                                        <th style="width: 30%">Uraian</th>
                                        <th style="width: 10%">Nilai</th>
                                        <th style="width: 5%" class="text-center">Aksi</th>
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
    <div class="modal fade" id="ajaxModeldb">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modelHeading">
                        </h4>
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
                    <center>
                        <h6 class="text-muted">::KEPUTUSAN INI TIDAK DAPAT DIUBAH KEMBALI::</h6>
                        <br>
                    </center>
                    <center>
                        <h6>Apakah anda yakin menghapus SPJ yang sudah diterima ini ?</h6>
                    </center><br>
                    <small class="text-danger"><i class="fa fa-info-circle"></i> Nilai anggaran akan kembali
                        sesuai
                        nilai kwitansi & SPJ akan dikembalikan ke user yang mengajukan.</small>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-danger btn-sm " id="hapusBtn"><i
                            class="fa fa-trash"></i>&nbsp;Hapus</button>
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
                ajax: "{{ route('spj.diterima') }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    {
                        data: "tanggal",
                        name: "tanggal",
                    },
                    {
                        data: "kegiatan",
                        name: "kegiatan",
                    },
                    {
                        data: "subkeg",
                        name: "subkeg",
                    },
                    {
                        data: "rekening",
                        name: "rekening",
                    },
                    {
                        data: "uraian",
                        name: "uraian",
                    },
                    {
                        data: "nilai",
                        name: "nilai",
                    },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                ],
            });
            $("body").on("click", ".delete", function() {
                var spj_id = $(this).data("id");
                $("#modelHeading").html("Hapus");
                $("#ajaxModeldb").modal("show");
                $("#hapusBtn").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menghapus...</i></span>"
                    );
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('spj/destroyback') }}" + '/' + spj_id,
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
                                        "<i class='fa fa-trash'>&nbsp;Hapus</i>"
                                    );
                                });
                            } else {
                                alertSuccess(data.success);
                                $("#hapusBtn").html(
                                    "<i class='fa fa-trash'>&nbsp;Hapus</i>");
                                $('#ajaxModeldb').modal('hide');
                                window.location.href = "{{ url('spj/diterima') }}"
                            }
                        },
                    });
                });
            });
            // $("body").on("click", ".deleteSpj", function() {
            //     var spj_id = $(this).data("id");
            //     confirm("Apa kamu yakin menghapus data ini ?");
            //     $.ajax({
            //         type: "DELETE",
            //         url: "{{ url('spj/destroyed') }}" + '/' + spj_id,
            //         data: {
            //             _token: "{!! csrf_token() !!}",
            //         },
            //         success: function(data) {
            //             alertDanger("SPJ Berhasil di hapus");
            //             table.draw();
            //         },
            //         error: function(data) {
            //             console.log("Error:", data);
            //         },
            //     });
            // });
        });
    </script>
@endsection
