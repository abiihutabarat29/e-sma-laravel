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
                            <a href="{{ route('kartukendali.subkeg', Crypt::encryptString($subkegiatan->kegiatan->id)) }}"
                                id="createNewSubkeg" class="btn btn-warning btn-xs float-right">
                                <i class="fas fa-reply"></i> Kembali
                            </a>
                        </div>
                        <div class="card-body">
                            <table id="data-table" class="table table-bordered table-striped ">
                                <thead>
                                    <tr>
                                        <th style="width:3%">No</th>
                                        <th style="width:15%">Kode Rekening</th>
                                        <th>Nama Rekening</th>
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

            var table = $("#data-table").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                dom: 'Bfrtip',
                buttons: ["excel", "pdf", "print", "colvis"],
                ajax: "{{ route('kartukendali.rek', $id) }}",
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
                        data: 'terpakai',
                        name: 'terpakai'
                    },
                    {
                        data: 'sisa_rekening',
                        name: 'sisa_rekening'
                    },
                ]
            })
        });
    </script>
@endsection
