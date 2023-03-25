<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bagian;
use App\Models\User;
use App\Models\Kegiatan;
use App\Models\SPJ;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use App\Models\AppSetting;

class DashboardController extends Controller
{

    public function index()
    {
        $menu = "Dashboard";
        $gu = Setting::first();
        $idb = Auth::user()->bagian_id;
        $bagian = Bagian::count();
        $user = User::where('level', '!=', 1)->count();
        $kegiatan_all = Kegiatan::count();
        $spj = SPJ::count();
        $spj_terima = SPJ::where('status', 3)->where('bagian_id', $idb)->count();
        $spj_tolak = SPJ::where('status', 4)->where('bagian_id', $idb)->count();
        $app = AppSetting::first();
        $pagu_kegiatan = Kegiatan::select('*')->selectRaw('SUM(pagu_kegiatan) as pagu')
            ->where('bagian_id', $idb)
            ->first();
        $sisa_kegiatan = Kegiatan::select('*')->selectRaw('SUM(sisa_kegiatan) as sisa')
            ->where('bagian_id', $idb)
            ->first();
        return view('admin.dashboard', compact('menu', 'pagu_kegiatan', 'sisa_kegiatan',  'gu', 'bagian', 'user', 'kegiatan_all', 'spj', 'app', 'spj_terima', 'spj_tolak'));
    }
}
