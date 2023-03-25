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
        $user = User::where('role', '!=', 1)->count();
        return view('admin.dashboard', compact('menu', 'user'));
    }
}
