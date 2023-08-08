<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Pegawai;
use App\Models\Sekolah;
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
        $guruall = Guru::count();
        $pegawaiall = Pegawai::count();
        $siswaall = Siswa::where('sts_siswa', 'Aktif')->count();
        $alumniall = Siswa::where('sts_siswa', 'Lulus')->count();
        $user = User::where('role', '!=', 1)->count();
        if (Auth::user()->role == 1) {
            $siswa = Sekolah::select('sekolah.nama_sekolah as sekolah_nama', Siswa::raw('COUNT(siswa.id) as siswa_count'))
                ->leftJoin('siswa', 'sekolah.id', '=', 'siswa.sekolah_id')
                ->groupBy('sekolah.id', 'sekolah.nama_sekolah')
                ->get();
            $alumni = Siswa::select('sekolah.nama_sekolah as sekolah_nama', Siswa::raw('COUNT(siswa.id) as alumni_count'))
                ->join('sekolah', 'sekolah.id', '=', 'siswa.sekolah_id')
                ->where('siswa.sts_siswa', 'Lulus') // Menambahkan kondisi untuk siswa yang statusnya "lulus"
                ->groupBy('sekolah.id', 'sekolah.nama_sekolah')
                ->get();
            $guru = Sekolah::select('sekolah.nama_sekolah as sekolah_nama', Guru::raw('COUNT(guru.id) as guru_count'))
                ->leftJoin('guru', 'sekolah.id', '=', 'guru.sekolah_id')
                ->groupBy('sekolah.id', 'sekolah.nama_sekolah')
                ->get();
            $pegawai = Sekolah::select('sekolah.nama_sekolah as sekolah_nama', Pegawai::raw('COUNT(pegawai.id) as pegawai_count'))
                ->leftJoin('pegawai', 'sekolah.id', '=', 'pegawai.sekolah_id')
                ->groupBy('sekolah.id', 'sekolah.nama_sekolah')
                ->get();
            return view('admin.dashboard.admin', compact('menu', 'guruall', 'pegawaiall', 'user', 'siswaall', 'alumniall', 'siswa', 'alumni', 'guru', 'pegawai'));
        } else {
            return view('admin.dashboard.sekolah', compact('menu', 'guru', 'pegawai', 'user', 'siswa', 'alumni'));
        }
    }
}
