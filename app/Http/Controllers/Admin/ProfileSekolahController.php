<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileSekolahController extends Controller
{
    public function index()
    {
        $menu = 'Profil Sekolah';
        $profil = ProfileSekolah::where('id', Auth::user()->sekolah_id)->first();
        // dd($profil);
        return view('admin.profil-sekolah.data', compact('profil', 'menu'));
    }
    public function create()
    {
        $menu = 'Profil Sekolah';
        return view('admin.profil-sekolah.create', compact('menu'));
    }
}
