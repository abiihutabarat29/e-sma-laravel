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
                            <a href="{{ route('kartu.kegiatan') }}" class="btn btn-warning btn-xs float-right">
                                <i class="fas fa-reply"></i> Kembali
                            </a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th style="width:3%">No</th>
                                        <th>Nama Sub Kegiatan</th>
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
                ajax: "{{ route('kartu.subkeg', $id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
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
                        data: 'terpakai',
                        name: 'terpakai'
                    },
                    {
                        data: 'sisa_sub',
                        name: 'sisa_sub'
                    },
                ]
            });
        });
    </script>
@endsection
