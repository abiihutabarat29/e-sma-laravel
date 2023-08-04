@extends('admin.layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Selamat Datang
                        @if (Str::length(Auth::guard('admincbd')->user()) > 0)
                            @if (Auth::guard('admincbd')->user()->role == 1)
                                Administrator Cabdis
                            @endif
                        @endif
                        </h2>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $guruall }}</h3>
                            <p>Total Guru</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $pegawaiall }}</h3>
                            <p>Total Pegawai</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning ">
                        <div class="inner">
                            <h3>{{ $siswaall }}</h3>
                            <p>Total Siswa/i</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $alumniall }}</h3>
                            <p>Total Alumni</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <figure class="highcharts-figure">
                        <div id="container-sekolah-siswa" style="height: 400px; width:100%;"></div>
                    </figure>
                </div>
            </div>
            <hr>
            <div class="col-md-12">
                <div class="card">
                    <figure class="highcharts-figure">
                        <div id="container-sekolah-guru" style="height: 400px; width:100%;"></div>
                    </figure>
                </div>
            </div>
            <hr>
            <div class="col-md-12">
                <div class="card">
                    <figure class="highcharts-figure">
                        <div id="container-sekolah-pegawai" style="height: 400px; width:100%;"></div>
                    </figure>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data passed from the controller
            var siswa = @json($siswa);

            // Prepare the data for Highcharts
            var categories = [];
            var counts = [];

            siswa.forEach(function(item) {
                categories.push(item.sekolah_nama); // School name from the 'sekolah' table
                counts.push(item.siswa_count);
            });

            // Create the Highcharts chart
            Highcharts.chart('container-sekolah-siswa', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Grafik Jumlah Siswa/i Seluruh Sekolah'
                },
                xAxis: {
                    categories: categories
                },
                yAxis: {
                    title: {
                        text: 'Jumlah'
                    }
                },
                series: [{
                    name: 'Jumlah Siswa/i',
                    data: counts
                }]
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Data passed from the controller
            var guru = @json($guru);

            // Prepare the data for Highcharts
            var categories = [];
            var counts = [];

            guru.forEach(function(item) {
                categories.push(item.sekolah_nama); // School name from the 'sekolah' table
                counts.push(item.guru_count);
            });

            // Create the Highcharts chart
            Highcharts.chart('container-sekolah-guru', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Grafik Jumlah Guru Seluruh Sekolah'
                },
                xAxis: {
                    categories: categories
                },
                yAxis: {
                    title: {
                        text: 'Jumlah'
                    }
                },
                series: [{
                    name: 'Jumlah Guru',
                    data: counts
                }]
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Data passed from the controller
            var pegawai = @json($pegawai);

            // Prepare the data for Highcharts
            var categories = [];
            var counts = [];

            pegawai.forEach(function(item) {
                categories.push(item.sekolah_nama); // School name from the 'sekolah' table
                counts.push(item.pegawai_count);
            });

            // Create the Highcharts chart
            Highcharts.chart('container-sekolah-pegawai', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Grafik Jumlah Pegawai Seluruh Sekolah'
                },
                xAxis: {
                    categories: categories
                },
                yAxis: {
                    title: {
                        text: 'Jumlah'
                    }
                },
                series: [{
                    name: 'Jumlah Pegawai',
                    data: counts
                }]
            });
        });
    </script>
@endsection
