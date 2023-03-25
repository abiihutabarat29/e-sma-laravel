@include('auth.layouts-log.head')

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">
                        <div class="img" style="background-image: url(dist/login/images/hero-bg3.jpg);">
                        </div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex justify-content-center">
                                <img src="dist/login/images/logobb.png" style="width:100px">
                            </div>
                            <div class="w-100 text-center">
                                <h3>Sipenaku</h3>
                            </div>
                            <form action="{{ route('login') }}" class="signin-form" method="post">
                                @csrf
                                <div class="form-group mb-3">
                                    <label class="label" for="name"><i class="fa fa-user"></i> Username</label>
                                    <input type="text" name="username"
                                        class="form-control @error('username') is-invalid @enderror"
                                        placeholder="Username" value="{{ old('username') }}" required>
                                    @error('username')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label" for="password"><i class="fa fa-lock"></i> Password</label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Password" required>

                                    @error('password')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- aktifkan ketika sudah berjalan 1 tahun dari sekarang (2023) --}}
                                {{-- =========================================================== --}}
                                {{-- <div class="form-group mb-3">
                                    <label class="label" for="tahun"><i class="fa fa-calendar"></i> Tahun
                                        Anggaran</label>
                                    <select name="tahun" class="form-control @error('tahun') is-invalid @enderror"
                                        required>
                                        <?php
                                        $now = date('Y');
                                        $min = $now;
                                        $max = $now;
                                        for ($i = $max; $i >= $min; $i--) {
                                            echo '<option value=' . $i . '>' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                    @error('tahun')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div> --}}
                                {{-- =========================================================== --}}
                                <div class="form-group">
                                    <button type="submit"
                                        class="form-control btn btn-primary rounded submit px-3">Masuk</button>
                                </div>
                                <div class="copyright text-center mt-4">
                                    © {{ date('Y') }}
                                    <span> <a href="{{ '/' }}">Bagian Keuangan
                                            Setdakab Batubara</a></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('auth.layouts-log.js')
