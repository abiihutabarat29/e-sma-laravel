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
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="naikForm" name="naikForm" method="post" class="form-horizontal">
                @csrf
                <div class="col-12">
                    <div class="box-shadow">
                        <div class="col-md-12">
                            <div class="alert alert-dismissible fade show" role="alert" style="display: none;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <small class="mb-5"><i class="fas fa-info-circle text-danger"></i> Silahkan pilih kelas XII
                                yang ingin diluluskan.
                            </small>
                            <hr>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Filter Kelas<span class="text-danger">*</span></label>
                                        <select data-column="3" id="kelas_filter_id" name="kelas_filter_id"
                                            class="form-control select2bs4 filter">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 mt-4 p-2">
                                    <div class="form-group">
                                        <button class="btn btn-primary" id="lulus"><i class="fa fa-check"></i>
                                            Luluskan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th style="width:5%">No</th>
                                        <th style="width:10%">NISN</th>
                                        <th>Nama</th>
                                        <th style="width:8%">Kelas</th>
                                        <th style="width:8%">Status</th>
                                        <th style="width:8%">Foto</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('kelulusan.index') }}",
                columns: [{
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
                ],
            });
            $.ajax({
                url: "{{ url('rombel-sekolah/get-rombel-xii') }}",
                type: "POST",
                dataType: 'json',
                success: function(result) {
                    if (result == "") {
                        $('#kelas_filter_id').html(
                            '<option>::Tambahkan Kelas/Rombel Terlebih Dahulu::</option>'
                        );
                    } else {
                        $('#kelas_filter_id').html(
                            '<option value="">::Filter Kelas/Rombel::</option>');
                    }
                    $.each(result, function(key, value) {
                        $("#kelas_filter_id").append('<option value="' + value.kelas + ' ' +
                            value
                            .jurusan + ' ' + value
                            .ruangan + '">' + value
                            .kelas + ' ' + value.jurusan + ' ' +
                            value
                            .ruangan + '</option>');
                    });
                }
            });
            $("#lulus").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> sedang diproses...</i></span>"
                ).attr('disabled', 'disabled');
                $.ajax({
                    data: $("#naikForm").serialize(),
                    url: "{{ route('kenaikan-kelas.naik') }}",
                    type: "POST",
                    dataType: "json",
                    success: function(data) {
                        $('#selectAll').prop('checked', false);
                        if (data.errors) {
                            $('.alert-danger').html('');
                            $.each(data.errors, function(key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<strong><li>' +
                                    value +
                                    '</li></strong>');
                                $(".alert-danger").fadeOut(5000);
                                $("#lulus").html(
                                        "<i class='fa fa-arrow-up'></i> Naikkan")
                                    .removeAttr("disabled");
                            });
                        } else {
                            $("#lulus").html("<i class='fa fa-arrow-up'></i> Naikkan")
                                .removeAttr(
                                    "disabled");
                            window.location.reload();
                        }
                    },
                });
            });
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
            $('.filter').change(function() {
                table.column($(this).data('column'))
                    .search($(this).val())
                    .draw();
            });
        });
    </script>
@endsection
