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
                <div class="box-shadow mb-5">
                    <div class="title mb-3">
                        <h3>Filter Berdasarkan : </h3>
                    </div>
                    <div class="row-kartu">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Bagian</label>
                                <select class="form-control select2bs4" style="width: 100%;">
                                    <option selected="selected">::Pilih Bagian::</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Kegiatan</label>
                                <select class="form-control select2bs4" style="width: 100%;">
                                    <option selected="selected">::Pilih Kegiatan::</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sub Kegiatan</label>
                                <select class="form-control select2bs4" style="width: 100%;">
                                    <option selected="selected">::Pilih Sub Kegiatan::</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group-append mt-10" id="#">
                                <button type="button" class="btn btn-block btn-primary btn-flat">
                                    Search <i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table table-bordered table-striped data-table">
                            <thead>
                                <tr>
                                    <th style="width:3%">No</th>
                                    <th>Nama Kegiatan</th>
                                    <th style="width:15%">Bagian</th>
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
                ajax: "{{ route('kartu.kegiatan') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama_kegiatan',
                        name: 'nama_kegiatan'
                    },
                    {
                        data: 'bagian',
                        name: 'bagian'
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
