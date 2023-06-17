<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rombel;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RombelController extends Controller
{
    public function index()
    {
        $menu = 'Kelas/Rombel Sekolah';
        $rombel = Rombel::where('sekolah_id', Auth::user()->sekolah_id)->get();
        $rombelWithSiswa = [];
        foreach ($rombel as $r) {
            $kelas_id = $r->id;
            $siswaCount = Siswa::where('sekolah_id', Auth::user()->sekolah_id)->where('kelas_id', $kelas_id)->count();
            $rombelWithSiswa[] = [
                'rombel' => $r,
                'siswaCount' => $siswaCount
            ];
        }
        return view('admin.rombel.data', compact('menu', 'rombelWithSiswa'));
    }
    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'kelas.required' => 'Kelas/Rombel harus diisi.',
            'jurusan.required' => 'Program/Jurusan harus diisi.',
            'ruangan.required' => 'Ruangan harus diisi.',
        );
        $validator = Validator::make($request->all(), [
            'kelas' => 'required',
            'jurusan' => 'required',
            'ruangan' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        Rombel::updateOrCreate(
            [
                'id' => $request->rombel_id
            ],
            [
                'sekolah_id' => Auth::user()->sekolah_id,
                'kelas' => $request->kelas,
                'jurusan' => $request->jurusan,
                'ruangan' => $request->ruangan,
            ]
        );
        return response()->json(['success' => 'Kelas saved successfully.']);
    }
    public function edit($id)
    {
        $rombel = Rombel::find($id);
        return response()->json($rombel);
    }
    public function getRombel()
    {
        $data = Rombel::where('sekolah_id', Auth::user()->sekolah_id)->get(["id", "kelas", "jurusan", "ruangan"]);
        return response()->json($data);
    }
    public function getRombelXII()
    {
        $data = Rombel::where('sekolah_id', Auth::user()->sekolah_id)->where('kelas', 'XII')->get(["id", "kelas", "jurusan", "ruangan"]);
        return response()->json($data);
    }
}
