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
                                <div>: {{ $rekening->subkegiatan->kegiatan->kode_kegiatan ?? 'None' }}
                                    {{ $rekening->subkegiatan->kegiatan->nama_kegiatan ?? 'None' }}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <div>Sub Kegiatan</div>
                            </div>
                            <div class="col-10">
                                <div>: {{ $rekening->subkegiatan->kode_sub ?? 'None' }}
                                    {{ $rekening->subkegiatan->nama_sub ?? 'None' }}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <div>Rekening</div>
                            </div>
                            <div class="col-10">
                                <div>: {{ $rekening->kode_rekening ?? 'None' }} {{ $rekening->nama_rekening ?? 'None' }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <div>Bidang</div>
                            </div>
                            <div class="col-10">
                                <div>: {{ $rekening->subkegiatan->kegiatan->bagian->nama_bagian ?? 'None' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="javascript:void(0)" id="createNewDetail" class="btn btn-info btn-xs">
                                <i class="fas fa-plus-circle"></i> Tambah
                            </a>
                            <a href="{{ route('rekening.index', $rekening->subkegiatan->id ?? 'None') }}"
                                class="btn btn-warning btn-xs float-right">
                                <i class="fas fa-reply"></i> Kembali
                            </a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th style="width:3%">No</th>
                                        <th>Nama Detail</th>
                                        <th style="width:10%">Koefisien</th>
                                        <th style="width:10%">Satuan</th>
                                        <th style="width:15%">Harga</th>
                                        <th style="width:15%">Jumlah</th>
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

    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
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
                    <form id="detailForm" name="detailForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" id="kegiatan_id" name="kegiatan_id"
                            value="{{ $rekening->subkegiatan->kegiatan->id ?? 'None' }}">

                        <input type="hidden" id="subkegiatan_id" name="subkegiatan_id"
                            value="{{ $rekening->subkegiatan->id ?? 'None' }}">

                        <input type="hidden" id="rekening_id" name="rekening_id" value="{{ $rekening->id ?? 'None' }}">
                        <input type="hidden" id="pagu_rekening" name="pagu_rekening"
                            value="{{ $rekening->pagu_rekening ?? 'None' }}">

                        <input type="hidden" name="detail_id" id="detail_id">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Kegiatan</label>
                                    <input type="text" class="form-control"
                                        placeholder="{{ $rekening->subkegiatan->kegiatan->kode_kegiatan ?? 'None' }} {{ $rekening->subkegiatan->kegiatan->nama_kegiatan ?? 'None' }}"
                                        disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Sub Kegiatan</label>
                                    <input type="text" class="form-control"
                                        placeholder="{{ $rekening->subkegiatan->kode_sub ?? 'None' }} {{ $rekening->subkegiatan->nama_sub ?? 'None' }}"
                                        disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Rekening</label>
                                    <input type="text" class="form-control"
                                        placeholder="{{ $rekening->kode_rekening ?? 'None' }} {{ $rekening->nama_rekening ?? 'None' }}"
                                        disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Uraian<span class="text-danger">
                                            *</span></label>
                                    <input type="text" class="form-control" id="nama_detail" name="nama_detail"
                                        placeholder="Uraian">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Spesifikasi</label>
                                    <input type="text" class="form-control" id="spesifikasi" name="spesifikasi"
                                        placeholder="Spesifikasi boleh kosong">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Koefisien<span class="text-danger">
                                            *</span></label>
                                    <div class="form row" id="kof">
                                        <div class="col">
                                            <input type="text" class="form-control" id="koefisien1" name="koefisien1"
                                                placeholder="Koefisien">
                                        </div>
                                        <div id="kofx">X</div>
                                        <div class="col" id="kof2">
                                            <input type="text" class="form-control" id="koefisien2" name="koefisien2"
                                                placeholder="Koefisien">
                                        </div>
                                        <a href="javascript:void(0)" id="removeKoefisien" class="btn btn-xs">
                                            <i class="fas fa-minus-circle"></i>
                                        </a>
                                        <a href="javascript:void(0)" id="addKoefisien" class="btn btn-xs">
                                            <i class="fas fa-plus-circle"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Satuan<span class="text-danger">
                                            *</span></label>
                                    <input type="text" class="form-control" id="satuan" name="satuan"
                                        placeholder="Satuan">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Harga<span class="text-danger">
                                            *</span></label>
                                    <input type="text" class="form-control" id="harga" name="harga"
                                        placeholder="Harga">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Jumlah<span class="text-danger">
                                            *</span></label>
                                    <input type="text" class="form-control" id="jumlah" name="jumlah"
                                        placeholder="Jumlah">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#kofx').hide();
            $('#kof2').hide();
            $('#removeKoefisien').hide();
            $("#addKoefisien").click(function() {
                $("#kofx").show();
                $("#kof2").show();
                $("#removeKoefisien").show();
                $("#addKoefisien").hide();
            });
            $("#removeKoefisien").click(function() {
                $("#kofx").hide();
                $("#kof2").hide();
                $("#removeKoefisien").hide();
                $('#kof1').show();
                $('#addKoefisien').show();
            });

            $('#koefisien1,#koefisien2,#harga').keyup(function() {
                var harga = $(this).val().replace(/\./g, '');
                var harga_akhir = harga.replace('Rp ', '');
                var koefisien1 = $('#koefisien1').val();
                var koefisien2 = $('#koefisien2').val();
                if (koefisien2 == "") {
                    var jumlah = harga_akhir * koefisien1;
                } else {
                    var jumlah = koefisien1 * koefisien2 * harga_akhir;
                }

                var rupiah = "Rp. " + jumlah.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
                $('#jumlah').val(rupiah);
            });
        });

        $(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            var table = $(".data-table").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('detail.index', $id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama_detail',
                        name: 'nama_detail'
                    },
                    {
                        data: 'koefisien',
                        name: 'koefisien'
                    },
                    {
                        data: 'satuan',
                        name: 'satuan'
                    },
                    {
                        data: 'harga',
                        name: 'harga'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $("#createNewDetail").click(function() {
                $("#saveBtn").val("create-detail");
                $("#detail_id").val("");
                $("#detailForm").trigger("reset");
                $("#modelHeading").html("Tambah Detail");
                $("#ajaxModel").modal("show");
                $("#deleteDetail").modal("show");
            });

            $("body").on("click", ".editDetail", function() {
                var detail_id = $(this).data("id");
                $.get("{{ route('detail.index', $detail->rekening_id ?? 'None') }}" + "/" + detail_id +
                    "/edit",
                    function(data) {
                        $("#modelHeading").html("Edit Detail");
                        $("#saveBtn").val("edit-detail");
                        $("#ajaxModel").modal("show");
                        $("#detail_id").val(data.id);
                        $("#rekening_id").val(data.rekening_id);
                        $("#nama_detail").val(data.nama_detail);
                        $("#spesifikasi").val(data.spesifikasi);
                        $("#koefisien1").val(data.koefisien1);
                        $("#koefisien2").val(data.koefisien2);
                        $("#satuan").val(data.satuan);
                        $("#harga").val("Rp. " + data.harga.toString().replace(
                            /(\d)(?=(\d{3})+(?!\d))/g, "$1."));
                        $("#jumlah").val("Rp. " + data.jumlah.toString().replace(
                            /(\d)(?=(\d{3})+(?!\d))/g, "$1."));
                    });
            });

            $("#saveBtn").click(function(e) {
                e.preventDefault();
                $(this).html("menyimpan..");

                $.ajax({
                    data: $("#detailForm").serialize(),
                    url: "{{ route('detail.store') }}",
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
                                $('#detailForm').trigger("reset");
                            });
                        } else {
                            table.draw();
                            alertSuccess("Rekening Berhasil di tambah");
                            $('#detailForm').trigger("reset");
                            $("#saveBtn").html("Simpan");
                            $('#ajaxModel').modal('hide');
                        }
                    },
                });
            });

            $("body").on("click", ".deleteDetail", function() {
                var detail_id = $(this).data("id");
                confirm("Are You sure want to delete !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('detail.store') }}" + "/" + detail_id + "/destroy",
                    data: {
                        _token: "{!! csrf_token() !!}",
                    },
                    success: function(data) {
                        alertDanger("Detail Berhasil di hapus");
                        table.draw();
                    },
                    error: function(data) {
                        console.log("Error:", data);
                    },
                });
            });
        });
    </script>
@endsection
