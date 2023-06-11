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
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        {{-- foto sekolah --}}
                        @if ($foto->foto_sekolah == null)
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center p-5">
                                        <span class="text-danger"><i>* gambar sekolah tidak ada</i></span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card">
                                <div class="card-body">
                                    @if ($foto->foto_sekolah == null)
                                        <img class="img-fluid pad" src="{{ url('storage/foto-sekolah/blank.png') }}"
                                            alt="Gambar Sekolah">
                                    @else
                                        <img src="{{ url('storage/foto-sekolah/' . $foto->foto_sekolah) }}"
                                            class="img-fluid pad" alt="Gambar Sekolah">
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <div class="invoice p-3 mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <h6>
                                        <i class="fas fa-home"></i> Wilayah Sekolah
                                        <div class="float-right">
                                            @if ($wilayah == null)
                                                <a href="javascript:void(0)" id="createNewWil" class="btn btn-info btn-xs"
                                                    title="Lengkapi Wilayah Sekolah">Lengkapi Wilayah Sekolah
                                                </a>
                                            @else
                                                <a href="javascript:void(0)" data-id="{{ $wilayah->id }}"
                                                    class="btn btn-secondary btn-xs editWilayah"
                                                    title="Perbaharui Wilayah Sekolah">Perbaharui Wilayah Sekolah
                                                </a>
                                            @endif
                                        </div>
                                    </h6>
                                </div>
                            </div>
                            @if ($wilayah == null)
                                <div class="col-sm-12 invoice-col mt-5" style="height: 400px">
                                    <div class="text-center p-5">
                                        <span class="text-danger"><i>* wilayah sekolah tidak ada</i></span>
                                    </div>
                                </div>
                            @else
                                <div class="col-sm-4 invoice-col mt-4">
                                    <h6 class="mt-2"><b>Luas Tanah</b></h6>
                                    <span>{{ $wilayah->luas_tanah }} m2</span>
                                    <h6 class="mt-2"><b>Luas Bangunan</b></h6>
                                    <span>{{ $wilayah->luas_bangunan }} m2</span>
                                    <h6 class="mt-2"><b>Luas Rencana Pembangunan</b></h6>
                                    <span>{{ $wilayah->luas_rpembangunan }} m2</span>
                                    <h6 class="mt-2"><b>Status Kepemilikan Tanah</b></h6>
                                    <span>{{ $wilayah->status_tanah }}</span>
                                    <h6 class="mt-2"><b>Status Kepemilikan Gedung</b></h6>
                                    <span>{{ $wilayah->status_gedung }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('modal')
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
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
                    <form id="wilayahForm" name="wilayahForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="wilayah_id" id="wilayah_id">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Luas Tanah<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="luas_tanah" name="luas_tanah"
                                    placeholder="Luas Tanah">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Luas Bangunan<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="luas_bangunan" name="luas_bangunan"
                                    placeholder="Luas Bangunan">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Luas Rencana Pembangunan<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="luas_rpembangunan" name="luas_rpembangunan"
                                    placeholder="Luas Rencana Pembangunan">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Status Kepemilikan Tanah<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="status_tanah" name="status_tanah"
                                    placeholder="Status Kepemilikan Tanah">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Status Kepemilikan Gedung<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="status_gedung" name="status_gedung"
                                    placeholder="Status Kepemilikan Gedung">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm" id="saveBtn"
                                    value="create">Simpan
                                </button>
                            </div>
                        </div>
                    </form>
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
            $("#createNewWil").click(function() {
                $("#saveBtn").val("create-wilayah");
                $("#wilayah_id").val("");
                $("#wilayahForm").trigger("reset");
                $("#modelHeading").html("Wilayah Sekolah");
                $("#ajaxModel").modal("show");
            });
            $("body").on("click", ".editWilayah", function() {
                var wilayah_id = $(this).data("id");
                $.get("{{ route('wilayah-sekolah.index') }}" + "/" + wilayah_id + "/edit", function(data) {
                    $("#modelHeading").html("Perbaharui Wilayah Sekolah");
                    $("#saveBtn").val("edit-wilayah");
                    $("#ajaxModel").modal("show");
                    $("#wilayah_id").val(data.id);
                    $("#luas_tanah").val(data.luas_tanah);
                    $("#luas_bangunan").val(data.luas_bangunan);
                    $("#luas_rpembangunan").val(data.luas_rpembangunan);
                    $("#status_tanah").val(data.status_tanah);
                    $("#status_gedung").val(data.status_gedung);
                });
            });
            $("#saveBtn").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
                );
                $.ajax({
                    data: $("#wilayahForm").serialize(),
                    url: "{{ route('wilayah-sekolah.store') }}",
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
                            });
                        } else {
                            alertSuccess("Wilayah saved successfully.");
                            $("#saveBtn").html("Simpan");
                            $('#ajaxModel').modal('hide');
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        }
                    },
                });
            });
        });
    </script>
@endsection
