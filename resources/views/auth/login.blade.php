@include('auth.layouts-log.head')

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">
                        <div class="img" style="background-image: url(dist/login/images/hero.jpg);">
                        </div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex justify-content-center">
                                <img src="dist/login/images/logo-sekolah.svg" style="width:100px">
                            </div>
                            <div class="w-100 text-center">
                                <h3>E-SEKOLAH</h3>
                            </div>
                            <form action="{{ route('login') }}" class="signin-form" method="post">
                                @csrf
                                <div class="form-group mb-3">
                                    <label class="label" for="name"><i class="fa fa-user"></i> Email</label>
                                    <input type="text" name="email"
                                        class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                        value="{{ old('email') }}" required>
                                    @error('email')
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
                                <div class="form-group">
                                    <button type="submit"
                                        class="form-control btn btn-primary rounded submit px-3">Masuk</button>
                                </div>
                                <div class="copyright text-center mt-4">
                                    © {{ date('Y') }}
                                    <span> <a href="{{ '/' }}">e-sekolah</a></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('auth.layouts-log.js')
