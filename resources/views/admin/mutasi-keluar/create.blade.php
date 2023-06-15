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
                        <li class="breadcrumb-item"><a href="{{ route('mutasi-keluar.index') }}">Data Mutasi Keluar</a></li>
                        <li class="breadcrumb-item active">{{ $menu }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-info">
                        <form method="POST" action="{{ route('mutasi-keluar.store') }}" class="form-horizontal">
                            @csrf
                            <div class="card-body">
                                <h6><i class="fa fa-info-circle text-danger"></i> Siswa yang telah dikeluarkan, data terkait
                                    siswa tersebut akan terhapus.</h6>
                                <hr>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label>Siswa<span class="text-danger">*</span></label>
                                        <select
                                            class="browser-default custom-select select2bs4  @error('siswa_id') is-invalid @enderror""
                                            name="siswa_id" id="siswa_id">
                                        </select>
                                        @error('siswa_id')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12">NISN</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="nisn" name="nisn" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12">Nama</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="nama" name="nama" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12">Kelas</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="kelas" name="kelas" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nomor Surat<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('no_surat') is-invalid @enderror"
                                            id="no_surat" name="no_surat" placeholder="Nomor Surat" autocomplete="off"
                                            value="{{ old('no_surat') }}">
                                        @error('no_surat')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Sekolah Tujuan<span class="text-danger">*</span></label>
                                        <textarea id="sekolah_tujuan" name="sekolah_tujuan" class="form-control  @error('sekolah_tujuan') is-invalid @enderror"
                                            rows="3">{{ old('sekolah_tujuan') }}</textarea>
                                        @error('sekolah_tujuan')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Keterangan<small> (Opsional)</small></label>
                                        <textarea id="keterangan" name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info">Simpan</button>
                                </div>
                            </div>
                        </form>
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
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('siswa/get-siswa') }}",
                type: "POST",
                dataType: 'json',
                success: function(result) {
                    if (result == "") {
                        $('#siswa_id').html(
                            '<option disable>::Data Siswa Tidak Tersedia::</option>'
                        );
                    } else {
                        $('#siswa_id').html(
                            '<option value="">--:---</option>');
                    }
                    $.each(result, function(key, value) {
                        $("#siswa_id").append('<option value="' +
                            value
                            .id + '">' + '(' + value.nisn + ')' + ' ' + value.nama +
                            ' </option>');
                    });
                }
            });
            $('#siswa_id').on('change', function() {
                var idSiswa = this.value;
                console.log(idSiswa);
                $("#nisn_id").html('');
                $.get("{{ url('siswa') }}" + "/" + idSiswa + "/get-siswa-data", function(data) {
                    $("#nisn").val(data.nisn);
                    $("#nama").val(data.nama);
                    $("#kelas").val(data.kelas.kelas + ' ' + data.kelas.jurusan + ' ' + data.kelas
                        .ruangan);
                });
            });
            //Initialize Select2 Elements
            $('.select2').select2()
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection
