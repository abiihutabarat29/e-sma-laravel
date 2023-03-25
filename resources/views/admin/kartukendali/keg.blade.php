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
            <div class="col-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table table-bordered table-striped data-table">
                            <thead>
                                <tr>
                                    <th style="width:3%">No</th>
                                    <th>Nama Kegiatan</th>
                                    <th style="width:13%">Jumlah</th>
                                    <th style="width:13%">Terpakai</th>
                                    <th style="width:13%">Sisa</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
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
                dom: 'Bfrtip',
                buttons: ["excel", "pdf", "print", "colvis"],
                ajax: "{{ route('kartukendali.kegiatan') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama_kegiatan',
                        name: 'nama_kegiatan'
                    },
                    {
                        data: 'pagu_kegiatan',
                        name: 'pagu_kegiatan'
                    },
                    {
                        data: 'terpakai',
                        name: 'terpakai'
                    },
                    {
                        data: 'sisa_kegiatan',
                        name: 'sisa_kegiatan'
                    },
                ]
            });
        });
    </script>
@endsection
