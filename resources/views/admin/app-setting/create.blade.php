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
                        <li class="breadcrumb-item"><a href="{{ 'dashboard' }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $menu }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card">
                    <!-- form start -->
                    <form method="POST" action="{{ route('appsetting.store') }}"enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama Aplikasi<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_aplikasi') is-invalid @enderror"
                                    name="nama_aplikasi" placeholder="Nama Aplikasi" autocomplete="off"
                                    value="{{ old('nama_aplikasi') }}">
                                @error('nama_aplikasi')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Keterangan Aplikasi<span class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control  @error('keterangan_aplikasi') is-invalid @enderror"
                                    name="keterangan_aplikasi" placeholder="Keterangan Aplikasi" autocomplete="off"
                                    value="{{ old('keterangan_aplikasi') }}">
                                @error('keterangan_aplikasi')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Visi<span class="text-danger">*</span></label>
                                <textarea name="visi" id="texteditor1"></textarea>
                                @error('visi')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Misi<span class="text-danger">*</span></label>
                                <textarea name="misi" id="texteditor2"></textarea>
                                @error('misi')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Logo Website<span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                    type="text" name="gambar" accept=".jpg, .jpeg, .png">
                                @error('gambar')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        </div>
                    </form>
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
