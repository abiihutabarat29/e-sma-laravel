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
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 10%">Tanggal</th>
                                        <th style="width: 20%">Bagian</th>
                                        <th>Uraian</th>
                                        <th style="width: 12%">Nilai</th>
                                        <th class="text-center" style="width: 8%">Aksi</th>
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
                ajax: "{{ route('spj.verifikasi') }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    {
                        data: "tanggal",
                        name: "tanggal",
                    },
                    {
                        data: "bagian",
                        name: "bagian",
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

            // $("body").on("click", ".deleteSpj", function() {
            //     var spj_id = $(this).data("id");
            //     confirm("Are You sure want to delete !");

            //     $.ajax({
            //         type: "DELETE",
            //         url: "{{ url('spj/destroy') }}" + '/' + spj_id,
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

            // $("body").on("click", ".terima", function() {
            //     var spj_id = $(this).data("id");
            //     $.ajax({
            //         type: "POST",
            //         url: "{{ url('spj/terima') }}" + '/' + spj_id,
            //         data: {
            //             _token: "{!! csrf_token() !!}",
            //         },
            //         success: function(data) {
            //             alertSuccess("SPJ Berhasil diterima");
            //             table.draw();
            //         },
            //         error: function(data) {
            //             console.log("Error:", data);
            //         },
            //     });
            // });

            // $("body").on("click", ".kembalikan", function() {
            //     var spj_id = $(this).data("id");
            //     $.ajax({
            //         type: "POST",
            //         url: "{{ url('spj/kembalikan') }}" + '/' + spj_id,
            //         data: {
            //             _token: "{!! csrf_token() !!}",
            //         },
            //         success: function(data) {
            //             alertSuccess("SPJ Berhasil dikembalikan");
            //             table.draw();
            //         },
            //         error: function(data) {
            //             console.log("Error:", data);
            //         },
            //     });
            // });

            // $("body").on("click", ".tolak", function() {
            //     var spj_id = $(this).data("id");
            //     $.ajax({
            //         type: "POST",
            //         url: "{{ url('spj/tolak') }}" + '/' + spj_id,
            //         data: {
            //             _token: "{!! csrf_token() !!}",
            //         },
            //         success: function(data) {
            //             alertSuccess("SPJ Berhasil ditolak");
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
