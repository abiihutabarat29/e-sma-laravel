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
                        <li class="breadcrumb-item"><a href="{{ route('pegawai.index') }}">Data Pegawai</a></li>
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
                            <li class="nav-item"><a class="nav-link" href="#tabpendidikan" data-toggle="tab">Pendidikan &
                                    Pekerjaan</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tabdiklat" data-toggle="tab">Diklat</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tabkontak" data-toggle="tab">Kontak</a></li>
                            <li class="nav-item"><a class="nav-link" href="#tabfoto" data-toggle="tab">Foto</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('pegawai.update', Crypt::encryptString($pegawai->id)) }}"
                            class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <input type="hidden" name="pegawai_id" id="{{ $pegawai->id }}">
                            <div class="tab-content">
                                <div class="active tab-pane" id="tabidentitas">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>NIP<small> (Opsional)</small></label>
                                                    <input type="text"
                                                        class="form-control @error('nip') is-invalid @enderror"
                                                        id="nip" name="nip" placeholder="NIP" autocomplete="off"
                                                        value="{{ old('nip', $pegawai->nip) }}"
                                                        onkeypress="return hanyaAngka(event)">
                                                    @error('nip')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>NIK<span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('nik') is-invalid @enderror"
                                                        id="nik" name="nik" placeholder="NIK" autocomplete="off"
                                                        value="{{ old('nik', $pegawai->nik) }}"
                                                        onkeypress="return hanyaAngka(event)">
                                                    @error('nik')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>NUPTK<span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('nuptk') is-invalid @enderror"
                                                        id="nuptk" name="nuptk" placeholder="NUPTK" autocomplete="off"
                                                        value="{{ old('nuptk', $pegawai->nuptk) }}"
                                                        onkeypress="return hanyaAngka(event)">
                                                    @error('nuptk')
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
                                                        value="{{ old('nama', $pegawai->nama) }}">
                                                    @error('nama')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Agama<span class="text-danger">*</span></label>
                                                    <select
                                                        class="form-control select2bs4 @error('agama') is-invalid @enderror"
                                                        id="agama" name="agama" style="width: 100%;">
                                                        <option value="Islam"
                                                            {{ $pegawai->agama == 'Islam' ? 'selected' : '' }}>
                                                            Islam</option>
                                                        <option value="Kristen Protestan"
                                                            {{ $pegawai->agama == 'Kristen Protestan' ? 'selected' : '' }}>
                                                            Kristen
                                                            Protestan
                                                        </option>
                                                        <option value="Kristen Katholik"
                                                            {{ $pegawai->agama == 'Kristen Katholik' ? 'selected' : '' }}>
                                                            Kristen Katholik
                                                        </option>
                                                        <option value="Hindu"
                                                            {{ $pegawai->agama == 'Hindu' ? 'selected' : '' }}>Hindu
                                                        </option>
                                                        <option value="Budha"
                                                            {{ $pegawai->agama == 'Budha' ? 'selected' : '' }}>Budha
                                                        </option>
                                                    </select>
                                                    @error('agama')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Alamat<span class="text-danger">*</span></label>
                                                    <textarea id="alamat" name="alamat" class="form-control  @error('alamat') is-invalid @enderror" rows="3">{{ old('alamat', $pegawai->alamat) }}</textarea>
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
                                                        rows="3">{{ old('tempat_lahir', $pegawai->tempat_lahir) }}</textarea>
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
                                                        value="{{ old('tgl_lahir', $pegawai->tgl_lahir) }}">
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
                                                                {{ $pegawai->gender == 'L' ? 'checked' : '' }}>
                                                            <label for="jk1"
                                                                class="custom-control-label">Laki-laki</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio"
                                                                value="P" name="jenis_kelamin" id="jk2"
                                                                {{ $pegawai->gender == 'P' ? 'checked' : '' }}>
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
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabpendidikan">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Pendidikan/Ijazah Tertinggi<span
                                                            class="text-danger">*</span></label>
                                                    <select
                                                        class="form-control select2bs4 @error('pendidikan') is-invalid @enderror"
                                                        id="pendidikan" name="pendidikan" style="width: 100%;">
                                                        <option disabled>---:---</option>
                                                        <option value="D3"
                                                            {{ $pegawai->tingkat == 'D3' ? 'selected' : '' }}>D3
                                                        </option>
                                                        <option value="S1"
                                                            {{ $pegawai->tingkat == 'S1' ? 'selected' : '' }}>S1
                                                        </option>
                                                        <option value="S2"
                                                            {{ $pegawai->tingkat == 'S2' ? 'selected' : '' }}>S2
                                                        </option>
                                                    </select>
                                                    @error('pendidikan')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Jurusan<span class="text-danger">*</span></label>
                                                    <select
                                                        class="form-control select2bs4 @error('jurusan') is-invalid @enderror"
                                                        id="jurusan" name="jurusan" style="width: 100%;">
                                                        <option selected disabled>---:---</option>
                                                        @foreach ($jurusan as $j)
                                                            <option value="{{ $j->jurusan }}"
                                                                {{ $pegawai->jurusan == $j->jurusan ? 'selected' : '' }}>
                                                                {{ $j->jurusan }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('jurusan')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tahun Ijazah<span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('thnijazah') is-invalid @enderror"
                                                        id="thnijazah" name="thnijazah" placeholder="example : 2020"
                                                        autocomplete="off"
                                                        value="{{ old('thnijazah', $pegawai->thnijazah) }}"
                                                        onkeypress="return hanyaAngka(event)">
                                                    @error('thnijazah')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Status Kepegawaian<span class="text-danger">*</span></label>
                                                    <select
                                                        class="form-control select2bs4 @error('status') is-invalid @enderror""
                                                        id="status" name="status" style="width: 100%;">
                                                        <option disabled>---:---</option>
                                                        <option value="PNS"
                                                            {{ $pegawai->status == 'PNS' ? 'selected' : '' }}>PNS</option>
                                                        <option value="CPNS"
                                                            {{ $pegawai->status == 'CPNS' ? 'selected' : '' }}>CPNS
                                                        </option>
                                                        <option value="Non PNS"
                                                            {{ $pegawai->status == 'Non PNS' ? 'selected' : '' }}>Non PNS
                                                        </option>
                                                        <option value="Honda"
                                                            {{ $pegawai->status == 'Honda' ? 'selected' : '' }}>Honda
                                                        </option>
                                                        <option value="GTY"
                                                            {{ $pegawai->status == 'GTY' ? 'selected' : '' }}>GTY</option>
                                                        <option value="GTT"
                                                            {{ $pegawai->status == 'GTT' ? 'selected' : '' }}>GTT</option>
                                                        <option value="GTTY"
                                                            {{ $pegawai->status == 'GTTY' ? 'selected' : '' }}>GTTY
                                                        </option>
                                                        <option value="PPPK"
                                                            {{ $pegawai->status == 'PPPK' ? 'selected' : '' }}>PPPK
                                                        </option>
                                                    </select>
                                                    @error('status')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Golongan <small> (Opsional)</small></label>
                                                    <select
                                                        class="form-control select2bs4
                                                        id="golongan"
                                                        name="golongan" style="width: 100%;">
                                                        <option value="">---:---</option>
                                                        @foreach ($golongan as $g)
                                                            <option value="{{ $g->golongan }}"
                                                                {{ $pegawai->golongan == $g->golongan ? 'selected' : '' }}>
                                                                {{ $g->golongan }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>TMT Pegawai<span class="text-danger">*</span></label>
                                                    <input type="date" id="tmtpegawai" name="tmtpegawai"
                                                        class="form-control @error('tmtpegawai') is-invalid @enderror"
                                                        value="{{ old('tmtpegawai', $pegawai->tmtpegawai) }}">
                                                    @error('tmtpegawai')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>TMT Sekolah<span class="text-danger">*</span></label>
                                                    <input type="date" id="tmtsekolah" name="tmtsekolah"
                                                        class="form-control @error('tmtsekolah') is-invalid @enderror"
                                                        value="{{ old('tmtsekolah', $pegawai->tmtsekolah) }}">
                                                    @error('tmtsekolah')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Kehadiran<small> (Opsional)</small></label>
                                                    <input type="text"
                                                        class="form-control @error('kehadiran') is-invalid @enderror"
                                                        id="kehadiran" name="kehadiran" placeholder="example : 100"
                                                        autocomplete="off"
                                                        value="{{ old('kehadiran', $pegawai->kehadiran) }}"
                                                        onkeypress="return hanyaAngka(event)">
                                                    <small><i>*perhitungan dalam % kehadiran di sekolah.</i></small>
                                                    @error('kehadiran')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabdiklat">
                                    <div class="card-body">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Diklat</label>
                                                <input type="text"
                                                    class="form-control @error('nama_diklat') is-invalid @enderror"
                                                    id="nama_diklat" name="nama_diklat" placeholder="Nama Diklat"
                                                    autocomplete="off"
                                                    value="{{ old('nama_diklat', $pegawai->nmdiklat) }}">
                                                @error('nama_diklat')
                                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tempat Diklat</label>
                                                <textarea id="tempat_diklat" name="tempat_diklat" class="form-control  @error('tempat_diklat') is-invalid @enderror"
                                                    rows="3">{{ old('tempat_diklat', $pegawai->tdiklat) }}</textarea>
                                                @error('tempat_diklat')
                                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tahun Diklat</label>
                                                <input type="text"
                                                    class="form-control @error('thndiklat') is-invalid @enderror"
                                                    id="thndiklat" name="thndiklat" placeholder="example : 2020"
                                                    autocomplete="off"
                                                    value="{{ old('thndiklat', $pegawai->thndiklat) }}"
                                                    onkeypress="return hanyaAngka(event)">
                                                @error('thndiklat')
                                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Lama Diklat</label>
                                                <input type="text"
                                                    class="form-control @error('lmdiklat') is-invalid @enderror"
                                                    id="lmdiklat" name="lmdiklat" placeholder="example : 8"
                                                    autocomplete="off" value="{{ old('lmdiklat', $pegawai->lmdiklat) }}"
                                                    onkeypress="return hanyaAngka(event)">
                                                <small><i>*perhitungan dalam Jam dalam pelaksanaan diklat.</i></small>
                                                @error('lmdiklat')
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
                                                <label>Telp/No HP/No WhatsApp<span class="text-danger">*</label>
                                                <input type="text"
                                                    class="form-control @error('nohp') is-invalid @enderror"
                                                    id="nohp" name="nohp" placeholder="08**********"
                                                    autocomplete="off" value="{{ old('nohp', $pegawai->nohp) }}"
                                                    onkeypress="return hanyaAngka(event)">
                                                @error('nohp')
                                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email<span class="text-danger">*</label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    id="email" name="email" placeholder="example@gmail.com"
                                                    autocomplete="off" value="{{ old('email', $pegawai->email) }}">
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
                                                @if ($pegawai->foto == null)
                                                    <img src="{{ url('storage/foto-pegawai/blank.png') }}"
                                                        alt="Image Profile" class="img-thumbnail rounded img-preview"
                                                        width="120px">
                                                @else
                                                    <img src="{{ url('storage/foto-pegawai/' . $pegawai->foto) }}"
                                                        alt="Image Profile" class="img-thumbnail rounded img-preview"
                                                        width="120px">
                                                @endif
                                            </div>
                                            <div class="col-md-4 mt-2">
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" id="foto" name="foto"
                                                            class="custom-file-input @error('foto') is-invalid @enderror""
                                                            id="foto" onchange="previewImg();">
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
                                        <a href="{{ route('pegawai.index') }}" class="btn btn-default btn-sm">Kembali</a>
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
    </script>
@endsection
