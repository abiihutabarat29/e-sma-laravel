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
            <div class="col-md-12">

                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5>Ketentuan :</h6>
                        <small>
                            *Harap lihat kartu kendali sebelum input SPJ untuk memastikan nilai kwitansi.<br>
                            *Nilai kwitansi tidak boleh melebihi nilai anggaran.<br>
                            *Jika tidak memperbaharui file, kosongkan saja.<br>
                            *Berkas file digabung dalam 1 file dan wajib berbentuk pdf.<br>
                            *Ukuran file maksimal 5MB.
                </div>
                <div class="card">
                    <form method="POST" action="{{ route('spj.update', Crypt::encryptString($spj->id)) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="card-body-form">

                            <div class="form-group">
                                <label>Jenis SPM<span class="text-danger"> *</span></label>
                                <span class="badge badge-primary btn-sm"> {{ $setting->judul }}</span>
                                @if (date('Y-m-d') < $setting->tgl_mulai && date('H:i:s') < $setting->jam_mulai)
                                    <span class="badge badge-warning btn-sm text-white">sesi belum dimulai</span>
                                @elseif(date('Y-m-d') == $setting->tgl_mulai && date('H:i:s') < $setting->jam_mulai)
                                    <span class="badge badge-warning btn-sm text-white">sesi belum dimulai</span>
                                @elseif (date('Y-m-d') == $setting->tgl_mulai ||
                                        (date('Y-m-d') > $setting->tgl_mulai &&
                                            date('H:i:s') > $setting->jam_mulai &&
                                            date('Y-m-d') < $setting->tgl_selesai) ||
                                        (date('Y-m-d') == $setting->tgl_selesai && date('H:i:s') < $setting->jam_selesai))
                                    <span class="badge badge-success btn-sm">aktif</span>
                                @else
                                    <span class="badge badge-danger btn-sm">sesi telah berakhir</span>
                                @endif
                                <div class="radio-btn">
                                    @if (date('Y-m-d') < $setting->tgl_mulai && date('H:i:s') < $setting->jam_mulai)
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" disabled>
                                            <label class="custom-control-label text-danger">GU</label>
                                        </div>
                                    @elseif(date('Y-m-d') == $setting->tgl_mulai && date('H:i:s') < $setting->jam_mulai)
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" disabled>
                                            <label class="custom-control-label text-danger">GU</label>
                                        </div>
                                    @elseif (date('Y-m-d') == $setting->tgl_mulai ||
                                            (date('Y-m-d') > $setting->tgl_mulai &&
                                                date('H:i:s') > $setting->jam_mulai &&
                                                date('Y-m-d') < $setting->tgl_selesai) ||
                                            (date('Y-m-d') == $setting->tgl_selesai && date('H:i:s') < $setting->jam_selesai))
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" value="1"
                                                id="jenis_spm1" name="jenis_spm"
                                                {{ old('jenis_spm', $spj->jenis_spm) == 1 ? 'checked' : '' }}>
                                            <label for="jenis_spm1" class="custom-control-label">GU</label>
                                        </div>
                                    @else
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" disabled>
                                            <label class="custom-control-label text-danger">GU</label>
                                        </div>
                                    @endif
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" value="2" id="jenis_spm2"
                                            name="jenis_spm" {{ old('jenis_spm', $spj->jenis_spm) == 2 ? 'checked' : '' }}>
                                        <label for="jenis_spm2" class="custom-control-label">TU</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" value="3" id="jenis_spm3"
                                            name="jenis_spm" {{ old('jenis_spm', $spj->jenis_spm) == 3 ? 'checked' : '' }}>
                                        <label for="jenis_spm3" class="custom-control-label">LS</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" value="4" id="jenis_spm4"
                                            name="jenis_spm" {{ old('jenis_spm', $spj->jenis_spm) == 4 ? 'checked' : '' }}>
                                        <label for="jenis_spm4" class="custom-control-label">UP</label>
                                    </div>
                                </div>
                                @error('jenis_spm')
                                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Tanggal<small> (Opsional)</small></label>
                                <input type="date" name="tanggal" class="form-control"
                                    value="{{ old('tanggal', $spj->tanggal) }}">
                            </div>
                            <div class="form-group">
                                <label>Kegiatan<span class="text-danger"> *</span></label>
                                <select class="form-control select2bs4 @error('kegiatan_id') is-invalid @enderror"
                                    id="kegiatan" name="kegiatan_id" style="width: 100%;">
                                    <option value="">::Pilih Kegiatan::</option>
                                    @foreach ($kegiatan as $keg)
                                        <option value="{{ $keg->id }}"
                                            {{ $keg->id == $spj->kegiatan_id ? 'selected' : '' }}>
                                            {{ $keg->nama_kegiatan }}</option>
                                    @endforeach
                                </select>
                                @error('kegiatan_id')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Sub Kegiatan<span class="text-danger"> *</span></label>
                                <select id="subkeg" name="subkegiatan_id"
                                    class="form-control select2bs4 @error('subkegiatan_id') is-invalid @enderror">
                                </select>
                                @error('subkegiatan_id')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Rekening Belanja<span class="text-danger"> *</span></label>
                                <select id="rekening" name="rekening_id"
                                    class="form-control select2bs4 @error('rekening_id') is-invalid @enderror">
                                </select>
                                @error('rekening_id')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Uraian<span class="text-danger"> *</span></label>
                                <textarea name="uraian" class="form-control @error('uraian') is-invalid @enderror" rows="3">{{ old('uraian', $spj->uraian) }}</textarea>
                                @error('uraian')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Nilai Kwitansi<span class="text-danger"> *</span></label>
                                <input name="kwitansi" type="text"
                                    class="form-control @error('kwitansi') is-invalid @enderror" placeholder="Rp."
                                    value="{{ old('kwitansi', $spj->kwitansi) }}" id="kwitansi">
                                @error('kwitansi')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Nama Rekanan/Penerima<span class="text-danger"> *</span></label>
                                <input name="nama_penerima" type="text"
                                    class="form-control @error('nama_penerima') is-invalid @enderror"
                                    value="{{ old('nama_penerima', $spj->nama_penerima) }}">
                                @error('nama_penerima')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Alamat Penerima<span class="text-danger"> *</span></label>
                                <textarea name="alamat_penerima" class="form-control  @error('alamat_penerima') is-invalid @enderror" rows="3">{{ old('alamat_penerima', $spj->alamat_penerima) }}</textarea>
                                @error('alamat_penerima')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <a href="{{ url('storage/file/', $spj->file) }}" target="blank"
                                    class="link-blue text-sm"><i class="fas fa-link mr-1"></i> File Lama</a>
                            </div>
                            <div class="form-group">
                                <label>Upload File Baru <small>(Opsional)</small></label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('file') is-invalid @enderror"
                                        name="file" id="customFile" accept=".pdf">
                                    <label class="custom-file-label">Pilih File</label>
                                </div>
                                @error('file')
                                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm">
                                Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        var rupiah = document.getElementById("kwitansi");
        rupiah.addEventListener("keyup", function(e) {
            rupiah.value = formatRupiah(this.value, "Rp. ");
        });


        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
        }

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
        $(function() {
            bsCustomFileInput.init();
        });
        $('#kegiatan').on('change', function() {
            var idKegiatan = $('#kegiatan').val();
            $("#subkeg").html('');
            $.ajax({
                url: "{{ route('spj.getsubkeg') }}",
                type: "POST",
                data: {
                    kegiatan_id: idKegiatan,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#subkeg').html('<option value="">Pilih Sub Kegiatan</option>');
                    $.each(result.subkeg, function(key, value) {
                        $("#subkeg").append('<option value="' + value
                            .id + '">' + value.nama_sub + '</option>');
                    });
                }
            });
            $('#subkeg').on('change', function() {
                var idSubkeg = $('#subkeg').val();
                console.log(idSubkeg);
                $("#rekening").html('');
                $.ajax({
                    url: "{{ route('spj.getrekening') }}",
                    type: "POST",
                    data: {
                        subkeg_id: idSubkeg,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#rekening').html('<option value="">Pilih Rekening</option>');
                        $.each(result.rekening, function(key, value) {
                            $("#rekening").append('<option value="' + value
                                .id + '">' + value.nama_rekening + '</option>');
                        });
                    }
                });
            });
        });
    </script>
@endsection
