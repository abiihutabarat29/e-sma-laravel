<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Pegawai;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        $menu = "Dashboard";
        $guru = Guru::where('sekolah_id', Auth::user()->sekolah_id)->count();
        $pegawai = Pegawai::where('sekolah_id', Auth::user()->sekolah_id)->count();
        $siswa = Siswa::where('sekolah_id', Auth::user()->sekolah_id)->where('sts_siswa', 'Aktif')->count();
        $alumni = Siswa::where('sekolah_id', Auth::user()->sekolah_id)->where('sts_siswa', 'Lulus')->count();
        $user = User::where('role', '!=', 1)->count();
        return view('admin.dashboard', compact('menu', 'guru', 'pegawai', 'user', 'siswa', 'alumni'));
    }
}
