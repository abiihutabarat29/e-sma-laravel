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
                        <li class="breadcrumb-item"><a href="{{ '/dashboard' }}">Dashboard</a></li>
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
                            <li class="nav-item"><a class="nav-link active" href="#identitas"
                                    data-toggle="tab">Identitas</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#pendidikan" data-toggle="tab">Pendidikan &
                                    Pekerjaan</a></li>
                            <li class="nav-item"><a class="nav-link" href="#diklat" data-toggle="tab">Diklat</a></li>
                            <li class="nav-item"><a class="nav-link" href="#kontak" data-toggle="tab">Kontak</a></li>
                            <li class="nav-item"><a class="nav-link" href="#foto" data-toggle="tab">Foto</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <form id="userForm" name="userForm" class="form-horizontal">
                            <div class="tab-content">
                                @csrf
                                <div class="active tab-pane" id="identitas">
                                    <div class="card-body">
                                        <input type="hidden" name="user_id" id="user_id">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>NIP<small> (Opsional)</small></label>
                                                    <input type="text" class="form-control" id="nip" name="nip"
                                                        placeholder="NIP" autocomplete="off" value="{{ old('nip') }}"
                                                        onkeypress="return hanyaAngka(event)">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>NIK<span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('nik') is-invalid @enderror"
                                                        id="nik" name="nik" placeholder="NIK" autocomplete="off"
                                                        value="{{ old('nik') }}" onkeypress="return hanyaAngka(event)">
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
                                                        value="{{ old('nuptk') }}" onkeypress="return hanyaAngka(event)">
                                                    @error('nuptk')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>NRG<span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('nrg') is-invalid @enderror"
                                                        id="nrg" name="nrg" placeholder="NRG" autocomplete="off"
                                                        value="{{ old('nrg') }}" onkeypress="return hanyaAngka(event)">
                                                    @error('nrg')
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
                                                        id="nama" name="nama" placeholder="Nama"
                                                        autocomplete="off" value="{{ old('nama') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Agama<span class="text-danger">*</span></label>
                                                    <select
                                                        class="form-control select2bs4 @error('agama') is-invalid @enderror"
                                                        id="agama" name="agama" style="width: 100%;">
                                                        <option selected disabled>---:---</option>
                                                        <option value="Islam">Islam</option>
                                                        <option value="Kristen Protestan">Kristen Protestan</option>
                                                        <option value="Kristen Katholik">Kristen Katholik</option>
                                                        <option value="Hindu">Hindu</option>
                                                        <option value="Budha">Budha</option>
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
                                                    <textarea name="alamat" class="form-control  @error('alamat') is-invalid @enderror" rows="3">{{ old('alamat') }}</textarea>
                                                    @error('alamat')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tempat Lahir<span class="text-danger">*</span></label>
                                                    <textarea name="tempat_lahir" class="form-control  @error('tempat_lahir') is-invalid @enderror" rows="3">{{ old('tempat_lahir') }}</textarea>
                                                    @error('tempat_lahir')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tanggal Lahir<span class="text-danger">*</span></label>
                                                    <input type="date" name="tgl_lahir"
                                                        class="form-control @error('tgl_lahir') is-invalid @enderror">
                                                    @error('ttgl_lahir')
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
                                                        @error('jenis_kelamin')
                                                            <small
                                                                class="text-danger"><strong>{{ $message }}</strong></small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="pendidikan">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Pendidikan/Ijazah Tertinggi<span
                                                            class="text-danger">*</span></label>
                                                    <select
                                                        class="form-control select2bs4 @error('pendidikan') is-invalid @enderror"
                                                        id="pendidikan" name="pendidikan" style="width: 100%;">
                                                        <option selected disabled>---:---</option>
                                                        <option value="D3">D3</option>
                                                        <option value="S1">S1</option>
                                                        <option value="S2">S2</option>
                                                    </select>
                                                    @error('pendidikan')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Golongan <small> (Opsional)</small></label>
                                                    <select
                                                        class="form-control select2bs4 @error('golongan') is-invalid @enderror"
                                                        id="golongan" name="golongan" style="width: 100%;">
                                                        <option selected disabled>---:---</option>
                                                        @foreach ($golongan as $g)
                                                            <option value="{{ $g->golongan }}">
                                                                {{ $g->golongan }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('golongan')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Jurusan<span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('jurusan') is-invalid @enderror"
                                                        id="jurusan" name="jurusan" placeholder="Jurusan"
                                                        autocomplete="off" value="{{ old('jurusan') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Status Kepegawaian<span class="text-danger">*</span></label>
                                                    <select
                                                        class="form-control select2bs4 @error('status') is-invalid @enderror""
                                                        id="status" name="status" style="width: 100%;">
                                                        <option selected disabled>---:---</option>
                                                        <option value="PNS">PNS</option>
                                                        <option value="CPNS">CPNS</option>
                                                        <option value="Non PNS">Non PNS</option>
                                                        <option value="Honda">Honda</option>
                                                        <option value="GTY">GTY</option>
                                                        <option value="GTT">GTT</option>
                                                        <option value="GTTY">GTTY</option>
                                                        <option value="PPPK">PPPK</option>
                                                    </select>
                                                    @error('status')
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
                                                        autocomplete="off" value="{{ old('thnijazah') }}"
                                                        onkeypress="return hanyaAngka(event)">
                                                    @error('thnijazah')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Status Sertifikasi<span class="text-danger">*</span></label>
                                                    <select
                                                        class="form-control select2bs4 @error('stsserti') is-invalid @enderror"
                                                        id="stsserti" name="stsserti" style="width: 100%;"
                                                        onchange=" if (this.selectedIndex==1){ document.getElementById('tahun').style.display='inline' }else { document.getElementById('tahun').style.display='none' };">
                                                        <option selected disabled>---:---</option>
                                                        <option value="Sudah">Sudah</option>
                                                        <option value="Belum">Belum</option>
                                                    </select>
                                                    @error('stsserti')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Mata Pelajaran<span class="text-danger">*</span></label>
                                                    <select
                                                        class="form-control select2bs4 @error('mapel') is-invalid @enderror"
                                                        id="mapel" name="mapel" style="width: 100%;">
                                                        <option selected disabled>---:---</option>
                                                        @foreach ($mapel as $m)
                                                            <option value="{{ $m->mapel }}">
                                                                {{ $m->mapel }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('golongan')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div id="tahun" style="display:none;">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Tahun Sertifikasi</label>
                                                        <input type="text"
                                                            class="form-control @error('thnserti') is-invalid @enderror"
                                                            id="thnserti" name="thnserti" placeholder="example : 2020"
                                                            autocomplete="off" value="{{ old('thnserti') }}"
                                                            onkeypress="return hanyaAngka(event)">
                                                        @error('thnserti')
                                                            <span
                                                                class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>TMT Guru<span class="text-danger">*</span></label>
                                                    <input type="date" name="tmtguru"
                                                        class="form-control @error('tmtguru') is-invalid @enderror">
                                                    @error('tmtguru')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>TMT Sekolah<span class="text-danger">*</span></label>
                                                    <input type="date" name="tmtsekolah"
                                                        class="form-control @error('tmtsekolah') is-invalid @enderror">
                                                    @error('tmtsekolah')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Jumlah Jam/Minggu<span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('jlhjam') is-invalid @enderror"
                                                        id="jlhjam" name="jlhjam" placeholder="example : 8"
                                                        autocomplete="off" value="{{ old('jlhjam') }}"
                                                        onkeypress="return hanyaAngka(event)">
                                                    <small><i>*perhitungan dalam Jam mengajar dalam seminggu.</i></small>
                                                    @error('jlhjam')
                                                        <span
                                                            class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Kehadiran<span class="text-danger">*</label>
                                                    <input type="text"
                                                        class="form-control @error('kehadiran') is-invalid @enderror"
                                                        id="kehadiran" name="kehadiran" placeholder="example : 100"
                                                        autocomplete="off" value="{{ old('kehadiran') }}"
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
                                <div class="tab-pane" id="diklat">
                                    <div class="card-body">
                                        <p>DIKLAT</p>
                                    </div>
                                </div>
                                <div class="tab-pane" id="kontak">
                                    <div class="card-body">
                                        <p>KONTAK</p>
                                    </div>
                                </div>
                                <div class="tab-pane" id="foto">
                                    <div class="card-body">
                                        <p>FOTO</p>
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
    </script>
@endsection
