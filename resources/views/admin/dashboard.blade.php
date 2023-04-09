@extends('admin.layouts.app')
@section('content')
    <div class="panel-header bg-secondary">
        <div class="page-inner py-4">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4 class="text-white pb-2 fw-bold">Dashboard
                                @if (Str::length(Auth::guard('admincbd')->user()) > 0)
                                    @if (Auth::guard('admincbd')->user()->role == 1)
                                        Administrator
                                    @endif
                                @elseif (Str::length(Auth::guard('user')->user()) > 0)
                                    @if (Auth::guard('user')->user()->role == 2)
                                        {{ Auth::guard('user')->user()->sekolah->nama_sekolah }}
                                    @endif
                                @endif
                                </h2>
                                <h5 class="text-white op-7 mb-2">Aplikasi Manajemen Data Sekolah</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
