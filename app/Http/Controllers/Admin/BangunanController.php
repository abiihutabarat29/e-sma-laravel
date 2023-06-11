<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bangunan;
use App\Models\ProfileSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BangunanController extends Controller
{
    public function index()
    {
        $menu = 'Wilayah Sekolah';
        $wilayah = Bangunan::where('sekolah_id', Auth::user()->sekolah_id)->first();
        $foto = ProfileSekolah::where('sekolah_id', Auth::user()->sekolah_id)->select('foto_sekolah')->first();
        return view('admin.wilayah-sekolah.data', compact('wilayah', 'foto', 'menu'));
    }
    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'luas_tanah.required' => 'Luas Tanah harus diisi.',
            'luas_bangunan.required' => 'Luas Bangunan harus diisi.',
            'luas_rpembangunan.required' => 'Luas Rencana Pembangunan harus diisi.',
            'status_tanah.required' => 'Status Kepemilikan Tanah harus diisi.',
            'status_gedung.required' => 'Status Kepemilikan Gedung harus diisi.',
        );
        $validator = Validator::make($request->all(), [
            'luas_tanah' => 'required',
            'luas_bangunan' => 'required',
            'luas_rpembangunan' => 'required',
            'status_tanah' => 'required',
            'status_gedung' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        Bangunan::updateOrCreate(
            [
                'id' => $request->wilayah_id
            ],
            [
                'sekolah_id' => Auth::user()->sekolah_id,
                'luas_tanah' => $request->luas_tanah,
                'luas_bangunan' => $request->luas_bangunan,
                'luas_rpembangunan' => $request->luas_rpembangunan,
                'status_tanah' => $request->status_tanah,
                'status_gedung' => $request->status_gedung,
            ]
        );
        return response()->json(['success' => 'Wilayah Sekolah saved successfully.']);
    }
    public function edit($id)
    {
        $bangunan = Bangunan::find($id);
        return response()->json($bangunan);
    }
}
