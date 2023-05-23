<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Siswa';
        if ($request->ajax()) {
            $data = Siswa::where('sekolah_id', Auth::user()->sekolah_id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nisn', function ($data) {
                    return $data->nisn;
                })
                ->addColumn('nama', function ($data) {
                    return $data->nama;
                })
                ->addColumn('kelas', function ($data) {
                    return '<center>' . $data->kelas . ' - ' . $data->jurusan . '</center>';
                })
                ->addColumn('sts_siswa', function ($data) {
                    return '<center>' . $data->sts_siswa . '</center>';
                })
                ->addColumn('foto', function ($data) {
                    if ($data->foto != null) {
                        $foto = '<center><img src="' . url("storage/foto-siswa/" . $data->foto) . '" width="30px" class="img rounded"><center>';
                    } else {
                        $foto = '<center><img src="' . url("storage/foto-siswa/blank.png") . '" width="30px" class="img rounded"><center>';
                    }
                    return $foto;
                })
                ->addColumn('action', function ($row) {
                    $btn = '        <a class="btn btn-primary btn-xs" href="' . route('siswa.edit',  Crypt::encryptString($row->id)) . '">Edit</a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteSiswa">Hapus</a><center>';
                    return $btn;
                })
                ->rawColumns(['kelas', 'sts_siswa', 'foto', 'action'])
                ->make(true);
        }
        return view('admin.siswa.data', compact('menu'));
    }
    public function create(Request $req)
    {
        $menu = 'Tambah Data Siswa';
        return view('admin.siswa.create', compact('menu'));
    }
    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'nisn.required' => 'NISN harus diisi.',
            'nisn.min' => 'NISN minimal 10 angka.',
            'nisn.max' => 'NISN maksimal 10 angka.',
            'nisn.unique' => 'NISN sudah terdaftar.',
            'nama.required' => 'Nama harus diisi.',
            'nama.required' => 'Nama harus dipilih.',
            'agama.required' => 'Agama harus dipilih.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.max' => 'Alamat melebihi maksimal karakter.',
            'tempat_lahir.required' => 'Tempat Lahir harus diisi.',
            'tempat_lahir.max' => 'Tempat Lahir  melebihi maksimal karakter.',
            'tgl_lahir.required' => 'Tanggal Lahir harus diisi.',
            'jenis_kelamin.required' => 'Jenis Kelamin harus dipilih.',
            'kelas.required' => 'Kelas harus dipilih.',
            'jurusan.required' => 'Jurusan harus dipilih.',
            'thnmasuk.required' => 'Tahun Masuk harus diisi.',
            'thnmasuk.max' => 'Tahun Masuk maksimal 4 angka.',
            'nohp.required' => 'Nomor Handphone harus diisi.',
            'nohp.min' => 'Nomor minimal 11 angka.',
            'nohp.max' => 'Nomor maksimal 12 angka.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Penulisan email tidak benar.',
            'foto.image' => 'Foto harus gambar.',
            'foto.mimes' => 'Foto harus jpeg,png,jpg.',
            'foto.max' => 'Foto maksimal 1MB.',
        );

        $validator = Validator::make($request->all(), [
            'nisn' => 'required|min:10|max:10|unique:siswa,nisn',
            'nama' => 'required|max:255',
            'alamat' => 'required|max:255',
            'tempat_lahir' => 'required|max:255',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'thnmasuk' => 'required|max:4',
            'nohp' => 'required|min:11|max:12',
            'email' => 'required|email',
            'foto' => 'image|mimes:jpeg,png,jpg|max:1024'
        ], $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $img = $request->file('foto');
        if ($img != null) {
            $fileName = $img->hashName();
            $img->storeAs('public/foto-siswa/', $fileName);
        } else {
            $fileName = null;
        }
        Siswa::create(
            [
                'sekolah_id' => Auth::user()->sekolah_id,
                'nisn' => $request->nisn,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'gender' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'kelas' => $request->kelas,
                'jurusan' => $request->jurusan,
                'tahun_masuk' => $request->thnmasuk,
                'nohp' => $request->nohp,
                'email' => $request->email,
                'sts_siswa' => 'Aktif',
                'foto' => $fileName,
            ]
        );
        return redirect()->route('siswa.index')->with('toast_success', 'Siswa saved successfully.');
    }
    public function edit($id)
    {
        $menu = 'Edit Data Siswa';
        $siswa = Siswa::where('sekolah_id', Auth::user()->sekolah_id)->find(Crypt::decryptString($id));
        return view('admin.siswa.edit', compact('menu', 'siswa'));
    }
    public function update(Request $request, $id)
    {
        $siswa = Siswa::find(Crypt::decryptString($id));
        //Translate Bahasa Indonesia
        $message = array(
            'nisn.required' => 'NISN harus diisi.',
            'nisn.min' => 'NISN minimal 10 angka.',
            'nisn.max' => 'NISN maksimal 10 angka.',
            'nisn.unique' => 'NISN sudah terdaftar.',
            'nama.required' => 'Nama harus diisi.',
            'nama.required' => 'Nama harus dipilih.',
            'agama.required' => 'Agama harus dipilih.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.max' => 'Alamat melebihi maksimal karakter.',
            'tempat_lahir.required' => 'Tempat Lahir harus diisi.',
            'tempat_lahir.max' => 'Tempat Lahir  melebihi maksimal karakter.',
            'tgl_lahir.required' => 'Tanggal Lahir harus diisi.',
            'jenis_kelamin.required' => 'Jenis Kelamin harus dipilih.',
            'kelas.required' => 'Kelas harus dipilih.',
            'jurusan.required' => 'Jurusan harus dipilih.',
            'thnmasuk.required' => 'Tahun Masuk harus diisi.',
            'thnmasuk.max' => 'Tahun Masuk maksimal 4 angka.',
            'nohp.required' => 'Nomor Handphone harus diisi.',
            'nohp.min' => 'Nomor minimal 11 angka.',
            'nohp.max' => 'Nomor maksimal 12 angka.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Penulisan email tidak benar.',
            'foto.image' => 'Foto harus gambar.',
            'foto.mimes' => 'Foto harus jpeg,png,jpg.',
            'foto.max' => 'Foto maksimal 1MB.',
        );
        if ($siswa->nisn == $request->nisn) {
            $ruleNisn = 'required|min:10|max:10';
        } else {
            $ruleNisn = 'required|min:10|max:10|unique:siswa,nisn';
        }
        $validator = Validator::make($request->all(), [
            'nisn' => $ruleNisn,
            'nama' => 'required|max:255',
            'alamat' => 'required|max:255',
            'tempat_lahir' => 'required|max:255',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'thnmasuk' => 'required|max:4',
            'nohp' => 'required|min:11|max:12',
            'email' => 'required|email',
            'foto' => 'image|mimes:jpeg,png,jpg|max:1024'
        ], $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $img = $request->file('foto');
        if ($img != null) {
            $fileName = $img->hashName();
            $img->storeAs('public/foto-siswa/',  $fileName);
            //delete old
            Storage::delete('public/foto-siswa/' . $siswa->foto);
        } else {
            $fileName = $siswa->foto;
        }
        $siswa->update(
            [
                'nisn' => $request->nisn,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'gender' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'kelas' => $request->kelas,
                'jurusan' => $request->jurusan,
                'tahun_masuk' => $request->thnmasuk,
                'nohp' => $request->nohp,
                'email' => $request->email,
                'foto' => $fileName,
            ]
        );
        return redirect()->route('siswa.index')->with('toast_success', 'Siswa updated successfully.');
    }
    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        if ($siswa->foto) {
            Storage::delete('public/foto-siswa/' . $siswa->foto);
        }
        return response()->json(['success' => 'Siswa deleted successfully.']);
    }
}
