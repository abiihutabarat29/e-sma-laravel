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
                        <li class="breadcrumb-item"><a href="{{ '/dashboard' }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $menu }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!-- form start -->
                        <form method="POST"
                            action="{{ route('appsetting.update', Crypt::encryptString($appsetting->id)) }}"enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nama Aplikasi<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama_aplikasi"
                                        placeholder="Nama Aplikasi" autocomplete="off"
                                        value="{{ old('nama_aplikasi', $appsetting->nama_aplikasi) }}">
                                    @error('nama_aplikasi')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Keterangan Aplikasi<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="keterangan_aplikasi"
                                        placeholder="Keterangan Aplikasi" autocomplete="off"
                                        value="{{ old('keterangan_aplikasi', $appsetting->keterangan_aplikasi) }}">
                                    @error('keterangan_aplikasi')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Visi<span class="text-danger">*</span></label>
                                    <textarea name="visi" id="texteditor1">{{ old('visi', $appsetting->visi) }}</textarea>
                                    @error('visi')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Misi<span class="text-danger">*</span></label>
                                    <textarea name="misi" id="texteditor2">{{ old('misi', $appsetting->misi) }}</textarea>
                                    @error('misi')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Logo Website<span class="text-danger">*</span></label><br>
                                    <img src="{{ url('storage/logo/' . $appsetting->gambar) }}"
                                        style="width: 234px; height:53px;">
                                </div>
                                <div class="form-group">
                                    <label>Ganti Logo<span class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                        type="text" name="gambar">
                                    @error('gambar')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
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
            // Summernote
            $('#texteditor1').summernote()
        })
        $(function() {
            // Summernote
            $('#texteditor2').summernote()
        })
    </script>
@endsection
