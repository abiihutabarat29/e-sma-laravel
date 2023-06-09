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
                        <li class="breadcrumb-item"><a href="{{ route('profile-sekolah.index') }}">Profil Sekolah</a></li>
                        <li class="breadcrumb-item">{{ $menu }}</li>
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
                            <li class="nav-item"><a class="nav-link" href="#tabprofil" data-toggle="tab">Profil</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tabkontak" data-toggle="tab">Kontak</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tabkepsek" data-toggle="tab">Kepala Sekolah</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <form method="post"
                            action="{{ route('profile-sekolah.update', Crypt::encryptString($profil->id)) }}"
                            class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="tab-content">
                                <div class="active tab-pane" id="tabidentitas">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>NSS<span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('nss') is-invalid @enderror"
                                                        id="nss" name="nss" placeholder="NSS" autocomplete="off"
                                                        value="{{ old('nss', $profil->nss) }}"
                                                        onkeypress="return hanyaAngka(event)">
                                                    @error('nss')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>NDS<span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('nds') is-invalid @enderror"
                                                        id="nds" name="nds" placeholder="NDS" autocomplete="off"
                                                        value="{{ old('nds', $profil->nds) }}"
                                                        onkeypress="return hanyaAngka(event)">
                                                    @error('nds')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nomor SIOP<span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('nosiop') is-invalid @enderror"
                                                        id="nosiop" name="nosiop" placeholder="Nomor SIOP"
                                                        autocomplete="off" value="{{ old('nosiop', $profil->nosiop) }}">
                                                    @error('nosiop')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Akreditas<span class="text-danger">*</span></label>
                                                    <select
                                                        class="form-control select2bs4 @error('akreditas') is-invalid @enderror"
                                                        id="akreditas" name="akreditas" style="width: 100%;">
                                                        <option selected disabled>---:---</option>
                                                        <option value="A"
                                                            {{ $profil->akreditas == 'A' ? 'selected' : '' }}>
                                                            A</option>
                                                        <option value="B"
                                                            {{ $profil->akreditas == 'B' ? 'selected' : '' }}>
                                                            B
                                                        </option>
                                                        <option value="C"
                                                            {{ $profil->akreditas == 'C' ? 'selected' : '' }}>
                                                            C
                                                        </option>
                                                    </select>
                                                    @error('akreditas')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tahun Berdiri<span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('thnberdiri') is-invalid @enderror"
                                                        id="thnberdiri" name="thnberdiri" placeholder="example : 2020"
                                                        autocomplete="off"
                                                        value="{{ old('thnberdiri', $profil->thnberdiri) }}"
                                                        onkeypress="return hanyaAngka(event)">
                                                    @error('thnberdiri')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nomor SK Pendirian<span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('nosk') is-invalid @enderror"
                                                        id="nosk" name="nosk" placeholder="Nomor SK Pendirian"
                                                        autocomplete="off" value="{{ old('nosk', $profil->nosk) }}">
                                                    @error('nosk')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tanggal SK<span class="text-danger">*</span></label>
                                                    <input type="date" id="tglsk" name="tglsk"
                                                        class="form-control @error('tglsk') is-invalid @enderror"
                                                        value="{{ old('tglsk', $profil->tglsk) }}">
                                                    @error('tglsk')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Standar Sekolah Bertaraf<span
                                                            class="text-danger">*</span></label>
                                                    <select
                                                        class="form-control select2bs4 @error('standar') is-invalid @enderror"
                                                        id="standar" name="standar" style="width: 100%;">
                                                        <option selected disabled>---:---</option>
                                                        <option value="SSN"
                                                            {{ $profil->standar == 'SSN' ? 'selected' : '' }}>
                                                            SSN</option>
                                                        <option value="SBI"
                                                            {{ $profil->standar == 'SBI' ? 'selected' : '' }}>
                                                            SBI
                                                        </option>
                                                        <option value="SPM"
                                                            {{ $profil->standar == 'SPM' ? 'selected' : '' }}>
                                                            SPM
                                                        </option>
                                                        <option value="SNS"
                                                            {{ $profil->standar == 'SNS' ? 'selected' : '' }}>
                                                            SNS
                                                        </option>
                                                    </select>
                                                    @error('standar')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Waktu Belajar<span class="text-danger">*</span></label>
                                                    <select
                                                        class="form-control select2bs4 @error('waktub') is-invalid @enderror"
                                                        id="waktub" name="waktub" style="width: 100%;">
                                                        <option selected disabled>---:---</option>
                                                        <option value="PAGI"
                                                            {{ $profil->waktub == 'PAGI' ? 'selected' : '' }}>
                                                            PAGI</option>
                                                        <option value="SIANG"
                                                            {{ $profil->waktub == 'SIANG' ? 'selected' : '' }}>
                                                            SIANG
                                                        </option>
                                                        <option value="SORE"
                                                            {{ $profil->waktub == 'SORE' ? 'selected' : '' }}>
                                                            SORE
                                                        </option>
                                                    </select>
                                                    @error('waktub')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabprofil">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Kabupaten<span class="text-danger">*</span></label>
                                                    <select class="browser-default custom-select select2bs4"
                                                        name="kabupaten_id" id="kabupaten_id">
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Kecamatan<span class="text-danger">*</span></label>
                                                    <select class="browser-default custom-select select2bs4"
                                                        name="kecamatan_id" id="kecamatan_id">
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Desa/Kelurahan<span class="text-danger">*</span></label>
                                                    <select class="browser-default custom-select select2bs4"
                                                        name="desa_id" id="desa_id">
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Kode Pos<span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('kodepos') is-invalid @enderror"
                                                        id="kodepos" name="kodepos" autocomplete="off"
                                                        value="{{ old('kodepos', $profil->kodepos) }}"
                                                        onkeypress="return hanyaAngka(event)">
                                                    @error('kodepos')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Alamat<span class="text-danger">*</span></label>
                                                    <textarea id="alamat" name="alamat" class="form-control  @error('alamat') is-invalid @enderror" rows="3"
                                                        placeholder="Tuliskan alamat sekolah ...">{{ old('alamat', $profil->alamat) }}</textarea>
                                                    @error('alamat')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <label>Foto Sekolah<small> (Opsional)</small></label>
                                                </div>
                                                <div class="col-md-12">
                                                    @if ($profil->foto_sekolah == null)
                                                        <img src="{{ url('storage/foto-sekolah/blank.png') }}"
                                                            alt="Image Profile"
                                                            class="img-thumbnail rounded img-preview-school"
                                                            width="120px">
                                                    @else
                                                        <img src="{{ url('storage/foto-sekolah/' . $profil->foto_sekolah) }}"
                                                            alt="Image Profile"
                                                            class="img-thumbnail rounded img-preview-school"
                                                            width="120px">
                                                    @endif
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" name="fotosekolah"
                                                                class="custom-file-input @error('fotosekolah') is-invalid @enderror""
                                                                id="fotosekolah" onchange="previewImgSchool();">
                                                            <label class="custom-file-label">Pilih File</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <small><i>*Foto maksimal 2MB dan berekstensi jpeg, jpg,
                                                        png.</i></small>
                                                <div class="col-md-12">
                                                    @error('fotosekolah')
                                                        <small
                                                            class="text-danger"><strong>{{ $message }}</strong></small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabkontak">
                                    <div class="card-body">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Telp/No HP/No WhatsApp<span class="text-danger">*</label>
                                                <input type="text"
                                                    class="form-control @error('telp') is-invalid @enderror"
                                                    id="telp" name="telp" placeholder="08**********"
                                                    autocomplete="off" value="{{ old('telp', $profil->telp) }}"
                                                    onkeypress="return hanyaAngka(event)">
                                                @error('telp')
                                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email<span class="text-danger">*</label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    id="email" name="email" placeholder="sma@gmail.com"
                                                    autocomplete="off" value="{{ old('email', $profil->email) }}">
                                                @error('email')
                                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Website<small> (Opsional)</small></label>
                                                <input type="text"
                                                    class="form-control @error('website') is-invalid @enderror"
                                                    id="website" name="website" placeholder="https://"
                                                    autocomplete="off" value="{{ old('website', $profil->website) }}">
                                                @error('website')
                                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabkepsek">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>NIP<small> (Opsional)</small></label>
                                                    <input type="text"
                                                        class="form-control @error('nip') is-invalid @enderror"
                                                        id="nip" name="nip" placeholder="NIP"
                                                        autocomplete="off" value="{{ old('nip', $profil->nip) }}"
                                                        onkeypress="return hanyaAngka(event)">
                                                    @error('nip')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama<span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('nama_kepsek') is-invalid @enderror"
                                                        id="nama_kepsek" name="nama_kepsek" placeholder="Nama Kepsek"
                                                        autocomplete="off"
                                                        value="{{ old('nama_kepsek', $profil->kepsek) }}">
                                                    @error('nama_kepsek')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12">
                                                    <label>Foto<small> (Opsional)</small></label>
                                                </div>
                                                <div class="col-md-12">
                                                    @if ($profil->foto_kepsek == null)
                                                        <img src="{{ url('storage/foto-kepsek/blank.png') }}"
                                                            alt="Image Profile" class="img-thumbnail rounded img-preview"
                                                            width="65px">
                                                    @else
                                                        <img src="{{ url('storage/foto-kepsek/' . $profil->foto_kepsek) }}"
                                                            alt="Image Profile" class="img-thumbnail rounded img-preview"
                                                            width="65px">
                                                    @endif
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" name="fotokepsek"
                                                                class="custom-file-input @error('fotokepsek') is-invalid @enderror""
                                                                id="fotokepsek" onchange="previewImg();">
                                                            <label class="custom-file-label">Pilih File</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <small><i>*Foto maksimal 2MB dan berekstensi jpeg, jpg,
                                                        png.</i></small>
                                                <div class="col-md-12">
                                                    @error('fotokepsek')
                                                        <small
                                                            class="text-danger"><strong>{{ $message }}</strong></small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('profile-sekolah.index') }}"
                                            class="btn btn-default btn-sm">Kembali</a>
                                        <button type="submit" class="btn btn-primary btn-sm" id="saveBtn"
                                            value="create">Perbaharui</button>
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
            const foto = document.querySelector('#fotokepsek');
            const img = document.querySelector('.img-preview');

            const fileFoto = new FileReader();
            fileFoto.readAsDataURL(foto.files[0]);

            fileFoto.onload = function(e) {
                img.src = e.target.result;
            }
        }

        function previewImgSchool() {
            const foto = document.querySelector('#fotosekolah');
            const img = document.querySelector('.img-preview-school');

            const fileFoto = new FileReader();
            fileFoto.readAsDataURL(foto.files[0]);

            fileFoto.onload = function(e) {
                img.src = e.target.result;
            }
        }
        $(function() {
            bsCustomFileInput.init();
        });
        //get kabupaten
        $(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            var kab = "{{ $profil->kabupaten_id }}";
            var kec = "{{ $profil->kecamatan_id }}";
            var desa = "{{ $profil->desa_id }}";
            $.ajax({
                url: "{{ url('kabupaten/get-kabupaten') }}",
                type: "POST",
                dataType: 'json',
                success: function(result) {
                    if (result.length == 0) {
                        $('#kabupaten_id').html(
                            '<option value="">----Data Kabupaten Kosong----</option>'
                        );
                    } else {
                        $('#kabupaten_id').html(
                            '<option value="">:::Pilih Kabupaten:::</option>');
                    }
                    $.each(result, function(key, value) {
                        $("#kabupaten_id").append('<option value="' + value
                            .id + '">' + value.kabupaten + '</option>');
                    });
                    $('#kabupaten_id').val(kab).trigger('change');
                }
            });
            $('#kabupaten_id').on('change', function() {
                var idKabupaten = $(this).val();
                $("#kecamatan_id").html('');
                $("#desa_id").html('');
                $.ajax({
                    url: "{{ url('kecamatan/get-kecamatan') }}",
                    type: "POST",
                    data: {
                        kabupaten_id: idKabupaten,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.kecamatan.length == 0) {
                            $('#kecamatan_id').html(
                                '<option value="">----Data Kecamatan Kosong----</option>'
                            );
                        } else {
                            $('#kecamatan_id').html(
                                '<option value="">:::Pilih Kecamatan:::</option>');
                            $.each(result.kecamatan, function(key, value) {
                                $("#kecamatan_id").append('<option value="' + value.id +
                                    '">' + value.kecamatan + '</option>');
                            });
                            $("#kecamatan_id").val(kec).trigger('change');
                        }
                    }
                });
            });
            $('#kecamatan_id').on('change', function() {
                var idKecamatan = $(this).val();
                $("#desa_id").html('');
                $.ajax({
                    url: "{{ url('desa/get-desa') }}",
                    type: "POST",
                    data: {
                        kecamatan_id: idKecamatan,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.desa == "") {
                            $('#desa_id').html(
                                '<option value="">----Data Desa Kosong----</option>'
                            );
                        } else {
                            $('#desa_id').html(
                                '<option value="">:::Pilih Desa/Kelurahan:::</option>');
                            $.each(result.desa, function(key, value) {
                                $("#desa_id").append('<option value="' + value
                                    .id + '">' + value.desa + '</option>');
                            });
                            $('#desa_id').val(desa);
                        }
                    }
                });
            });
        });
    </script>
@endsection
