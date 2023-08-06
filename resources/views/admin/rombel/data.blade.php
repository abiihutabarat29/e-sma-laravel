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
            <div class="row">
                <div class="col-md-12 mb-3">
                    <a href="javascript:void(0)" id="addRombel" class="btn btn-primary btn-sm float-right">
                        <i class="fas fa-plus-circle"></i> Tambah Kelas</a>
                </div>
                @if ($rombelWithSiswa == null)
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body box-profile">
                                <div class="text-center p-1">
                                    <span class="text-danger"><i>* Kelas / Rombel belum ditambahkan.</i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    @foreach ($rombelWithSiswa as $item)
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box bg-info">
                                <span class="info-box-icon"><i class="fa fa-home"></i></span>
                                <div class="info-box-content">
                                    <span
                                        class="info-box-text">{{ $item['rombel']->kelas }}&nbsp;{{ $item['rombel']->jurusan }}&nbsp;{{ $item['rombel']->ruangan }}
                                        - TA : {{ $item['rombel']->tahun_ajaran->nama }} </span>
                                    <span class="info-box-number">Jumlah Siswa/i :&nbsp;<span
                                            class="badge badge-danger">{{ $item['siswaCount'] }}</span></span>
                                </div>
                                <a href="javascript:void(0)" class="badge badge-sm editRombel mr-1"
                                    data-id="{{ $item['rombel']->id }}"><i class="fa fa-edit"
                                        title="Edit Kelas/Rombel"></i></a>
                            </div>
                        </div>
                    @endforeach
                @endif
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
                    <form id="rombelForm" name="rombelForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="rombel_id" id="rombel_id">
                        <div class="form-group">
                            <label>Kelas<span class="text-danger">*</span></label>
                            <select class="form-control select2bs4" id="kelas" name="kelas" style="width: 100%;">
                                <option selected disabled>---:---</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Program/Jurusan<span class="text-danger">*</span></label>
                                <select class="form-control select2bs4" id="jurusan" name="jurusan" style="width: 100%;">
                                    <option selected disabled>---:---</option>
                                    <option value="IPA">IPA</option>
                                    <option value="IPS">IPS</option>
                                    <option value="BAHASA">BAHASA</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Ruangan<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="ruangan" name="ruangan"
                                    placeholder="contoh : 1 atau 2 atau 3">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm" id="saveBtn" value="create">Simpan
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
        $("#addRombel").click(function() {
            $("#saveBtn").val("create-rombel");
            $("#rombel_id").val("");
            $("#rombelForm").trigger("reset");
            $("#modelHeading").html("Tambah Rombel");
            $("#ajaxModel").modal("show");
        });
        $("body").on("click", ".editRombel", function() {
            var rombel_id = $(this).data("id");
            $.get("{{ route('rombel-sekolah.index') }}" + "/" + rombel_id + "/edit", function(data) {
                $("#modelHeading").html("Edit Kelas/Rombel");
                $("#saveBtn").val("edit-rombel");
                $("#ajaxModel").modal("show");
                $("#rombel_id").val(data.id);
                $("#kelas").val(data.kelas).trigger('change');;
                $("#jurusan").val(data.jurusan).trigger('change');
                $("#ruangan").val(data.ruangan);
            });
        });
        $("#saveBtn").click(function(e) {
            e.preventDefault();
            $(this).html(
                "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
            ).attr('disabled', 'disabled');
            $.ajax({
                data: $("#rombelForm").serialize(),
                url: "{{ route('rombel-sekolah.store') }}",
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
                            $("#saveBtn").html("Simpan").removeAttr('disabled');
                        });
                    } else if (data.warning) {
                        alertWarning(data.warning);
                        $("#saveBtn").html("Simpan").removeAttr('disabled');
                        $('#ajaxModel').modal('hide');
                    } else {
                        alertSuccess("Kelas saved successfully.");
                        $("#saveBtn").html("Simpan").removeAttr('disabled');
                        $('#ajaxModel').modal('hide');
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    }
                },
            });
        });
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    </script>
@endsection
