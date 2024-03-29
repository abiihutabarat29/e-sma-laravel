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
                        <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}">Data Siswa</a></li>
                        <li class="breadcrumb-item active">{{ $menu }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#tabidentitas"
                                    data-toggle="tab">Identitas</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#tabpendidikan" data-toggle="tab">Status
                                    Pendidikan</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tabkontak" data-toggle="tab">Kontak</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tabfoto" data-toggle="tab">Foto</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('siswa.store') }}" class="form-horizontal"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="tab-content">
                                <div class="active tab-pane" id="tabidentitas">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>NISN<span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('nisn') is-invalid @enderror"
                                                        id="nisn" name="nisn" placeholder="NISN" autocomplete="off"
                                                        value="{{ old('nisn') }}" onkeypress="return hanyaAngka(event)">
                                                    @error('nisn')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nama<span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('nama') is-invalid @enderror"
                                                        id="nama" name="nama" placeholder="Nama" autocomplete="off"
                                                        value="{{ old('nama') }}">
                                                    @error('nama')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Alamat<span class="text-danger">*</span></label>
                                                    <textarea id="alamat" name="alamat" class="form-control  @error('alamat') is-invalid @enderror" rows="3">{{ old('alamat') }}</textarea>
                                                    @error('alamat')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tempat Lahir<span class="text-danger">*</span></label>
                                                    <textarea id="tempat_lahir" name="tempat_lahir" class="form-control  @error('tempat_lahir') is-invalid @enderror"
                                                        rows="3">{{ old('tempat_lahir') }}</textarea>
                                                    @error('tempat_lahir')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tanggal Lahir<span class="text-danger">*</span></label>
                                                    <input type="date" id="tgl_lahir" name="tgl_lahir"
                                                        class="form-control @error('tgl_lahir') is-invalid @enderror"
                                                        value="{{ old('tgl_lahir') }}">
                                                    @error('tgl_lahir')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Jenis Kelamin<span class="text-danger">*</span></label>
                                                    <div class="radio-btn">
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio"
                                                                value="L" name="jenis_kelamin" id="jk1"
                                                                {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }}>
                                                            <label for="jk1"
                                                                class="custom-control-label">Laki-laki</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio"
                                                                value="P" name="jenis_kelamin" id="jk2"
                                                                {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }}>
                                                            <label for="jk2"
                                                                class="custom-control-label">Perempuan</label>
                                                        </div>
                                                    </div>
                                                    @error('jenis_kelamin')
                                                        <small
                                                            class="text-danger"><strong>{{ $message }}</strong></small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Agama<span class="text-danger">*</span></label>
                                                    <select
                                                        class="form-control select2bs4 @error('agama') is-invalid @enderror"
                                                        id="agama" name="agama" style="width: 100%;">
                                                        <option selected disabled>---:---</option>
                                                        <option value="Islam"
                                                            {{ old('agama') == 'Islam' ? 'selected' : '' }}>
                                                            Islam</option>
                                                        <option value="Kristen Protestan"
                                                            {{ old('agama') == 'Kristen Protestan' ? 'selected' : '' }}>
                                                            Kristen
                                                            Protestan
                                                        </option>
                                                        <option value="Kristen Katholik"
                                                            {{ old('agama') == 'Kristen Katholik' ? 'selected' : '' }}>
                                                            Kristen Katholik
                                                        </option>
                                                        <option value="Hindu"
                                                            {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                                        <option value="Budha"
                                                            {{ old('agama') == 'Budha' ? 'selected' : '' }}>Budha</option>
                                                    </select>
                                                    @error('agama')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabpendidikan">
                                    <div class="card-body">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kelas/Rombel<span class="text-danger">*</span></label>
                                                <select
                                                    class="form-control select2bs4 @error('kelas_id') is-invalid @enderror"
                                                    id="kelas_id" name="kelas_id" style="width: 100%;">
                                                </select>
                                                @error('kelas_id')
                                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jurusan<span class="text-danger">*</span></label>
                                                <select
                                                    class="form-control select2bs4 @error('jurusan') is-invalid @enderror"
                                                    id="jurusan" name="jurusan" style="width: 100%;">
                                                    <option selected disabled>---:---</option>
                                                    <option value="IPA"
                                                        {{ old('jurusan') == 'IPA' ? 'selected' : '' }}>IPA
                                                    </option>
                                                    <option value="IPS"
                                                        {{ old('jurusan') == 'IPS' ? 'selected' : '' }}>IPS
                                                    </option>
                                                    <option value="Bahasa"
                                                        {{ old('jurusan') == 'Bahasa' ? 'selected' : '' }}>Bahasa
                                                    </option>
                                                </select>
                                                @error('jurusan')
                                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div> --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tahun Masuk<span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('thnmasuk') is-invalid @enderror"
                                                    id="thnmasuk" name="thnmasuk" placeholder="example : 2020"
                                                    autocomplete="off" value="{{ old('thnmasuk') }}"
                                                    onkeypress="return hanyaAngka(event)">
                                                @error('thnmasuk')
                                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabkontak">
                                    <div class="card-body">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Telp/No HP/No WhatsApp<small> (Opsional)</small></label>
                                                <input type="text"
                                                    class="form-control @error('nohp') is-invalid @enderror"
                                                    id="nohp" name="nohp" placeholder="08**********"
                                                    autocomplete="off" value="{{ old('nohp') }}"
                                                    onkeypress="return hanyaAngka(event)">
                                                @error('nohp')
                                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email<small> (Opsional)</small></label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    id="email" name="email" placeholder="example@gmail.com"
                                                    autocomplete="off" value="{{ old('email') }}">
                                                @error('email')
                                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabfoto">
                                    <div class="card-body">
                                        <div class="col-md-12">
                                            <div class="col-md-4">
                                                <label>Foto<small> (Opsional)</small></label>
                                            </div>
                                            <div class="col-md-4">
                                                <img src="{{ url('storage/foto-guru/blank.png') }}" alt="Image Profile"
                                                    class="img-thumbnail rounded img-preview" width="120px">
                                            </div>
                                            <div class="col-md-4 mt-2">
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" id="foto" name="foto"
                                                            class="custom-file-input @error('foto') is-invalid @enderror"
                                                            onchange="previewImg();">
                                                        <label class="custom-file-label">Pilih File</label>
                                                    </div>
                                                </div>
                                                <small><i>*Foto maksimal 1MB dan berekstensi jpeg, jpg, png.</i></small>
                                            </div>
                                            <div class="col-md-4">
                                                @error('foto')
                                                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('siswa.index') }}" class="btn btn-default btn-sm">Kembali</a>
                                        <button type="submit" class="btn btn-primary btn-sm" id="saveBtn"
                                            value="create">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
@endsection
@section('script')
    <script>
        // Fungsi hanyaAngka
        function hanyaAngka(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))

                return false;
            return true;
        }
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        function previewImg() {
            const foto = document.querySelector('#foto');
            const img = document.querySelector('.img-preview');

            const fileFoto = new FileReader();
            fileFoto.readAsDataURL(foto.files[0]);

            fileFoto.onload = function(e) {
                img.src = e.target.result;
            }
        }
        $(function() {
            bsCustomFileInput.init();
        });

        $(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            $.ajax({
                url: "{{ url('rombel-sekolah/get-rombel') }}",
                type: "POST",
                dataType: 'json',
                success: function(result) {
                    var selectElement = $("#kelas_id");
                    if (result == "") {
                        $('#kelas_id').html(
                            '<option disable>::Tambahkan Kelas/Rombel Terlebih Dahulu::</option>'
                        );
                    } else {
                        $('#kelas_id').html(
                            '<option value="">--:---</option>');
                    }
                    $.each(result, function(key, value) {
                        var option = $('<option>', {
                            value: value.id,
                            text: value.kelas + ' ' + value.jurusan + ' ' + value
                                .ruangan
                        });

                        // Memeriksa apakah value.id sama dengan old('kelas_id')
                        if (value.id == "{{ old('kelas_id') }}") {
                            option.attr("selected", "selected");
                        }

                        selectElement.append(option);
                    });
                }
            });
        });
    </script>
@endsection
