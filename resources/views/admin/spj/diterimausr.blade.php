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
                ajax: "{{ route('spj.terima') }}",
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
        });
    </script>
@endsection
