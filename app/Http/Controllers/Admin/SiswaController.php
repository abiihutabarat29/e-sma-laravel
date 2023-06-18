<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mutasi;
use App\Models\Rombel;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
            $data = Siswa::where('sekolah_id', Auth::user()->sekolah_id)->where('sts_siswa', 'Aktif')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<center><input type="checkbox" class="row-checkbox" name="siswaCheck[]" value="' . $row->id . '"></center>';
                })
                ->addColumn('nisn', function ($data) {
                    return $data->nisn;
                })
                ->addColumn('nama', function ($data) {
                    return $data->nama;
                })
                ->addColumn('kelas', function ($data) {
                    return '<center>' . $data->kelas->kelas . ' ' . $data->kelas->jurusan .  ' ' . $data->kelas->ruangan . '</center>';
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
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-nama="' . $row->nama . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteSiswa">Hapus</a><center>';
                    return $btn;
                })
                ->rawColumns(['checkbox', 'kelas', 'sts_siswa', 'foto', 'action'])
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
            'agama.required' => 'Agama harus dipilih.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.max' => 'Alamat melebihi maksimal karakter.',
            'tempat_lahir.required' => 'Tempat Lahir harus diisi.',
            'tempat_lahir.max' => 'Tempat Lahir  melebihi maksimal karakter.',
            'tgl_lahir.required' => 'Tanggal Lahir harus diisi.',
            'jenis_kelamin.required' => 'Jenis Kelamin harus dipilih.',
            'kelas_id.required' => 'Kelas/Rombel harus dipilih.',
            'thnmasuk.required' => 'Tahun Masuk harus diisi.',
            'thnmasuk.max' => 'Tahun Masuk maksimal 4 angka.',
            'nohp.min' => 'Nomor minimal 11 angka.',
            'nohp.max' => 'Nomor maksimal 12 angka.',
            'email.email' => 'Penulisan email tidak benar.',
            'foto.image' => 'Foto harus gambar.',
            'foto.mimes' => 'Foto harus jpeg,png,jpg.',
            'foto.max' => 'Foto maksimal 1MB.',
        );
        if ($request->nohp == null) {
            $ruleNohp = '';
        } else {
            $ruleNohp = 'min:11|max:12';
        }
        if ($request->email == null) {
            $ruleEmail = '';
        } else {
            $ruleEmail = 'email';
        }
        $validator = Validator::make($request->all(), [
            'nisn' => 'required|min:10|max:10|unique:siswa,nisn',
            'nama' => 'required|max:255',
            'alamat' => 'required|max:255',
            'tempat_lahir' => 'required|max:255',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'kelas_id' => 'required',
            'thnmasuk' => 'required|max:4',
            'nohp' => $ruleNohp,
            'email' => $ruleEmail,
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
                'kelas_id' => $request->kelas_id,
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
        $siswa = Siswa::where('sekolah_id', Auth::user()->sekolah_id)->where('sts_siswa', 'Aktif')->find(Crypt::decryptString($id));
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
            'agama.required' => 'Agama harus dipilih.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.max' => 'Alamat melebihi maksimal karakter.',
            'tempat_lahir.required' => 'Tempat Lahir harus diisi.',
            'tempat_lahir.max' => 'Tempat Lahir  melebihi maksimal karakter.',
            'tgl_lahir.required' => 'Tanggal Lahir harus diisi.',
            'jenis_kelamin.required' => 'Jenis Kelamin harus dipilih.',
            'kelas_id.required' => 'Kelas/Rombel harus dipilih.',
            'thnmasuk.required' => 'Tahun Masuk harus diisi.',
            'thnmasuk.max' => 'Tahun Masuk maksimal 4 angka.',
            'nohp.min' => 'Nomor minimal 11 angka.',
            'nohp.max' => 'Nomor maksimal 12 angka.',
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
        if ($request->nohp == null) {
            $ruleNohp = '';
        } else {
            $ruleNohp = 'min:11|max:12';
        }
        if ($request->email == null) {
            $ruleEmail = '';
        } else {
            $ruleEmail = 'email';
        }
        $validator = Validator::make($request->all(), [
            'nisn' => $ruleNisn,
            'nama' => 'required|max:255',
            'alamat' => 'required|max:255',
            'tempat_lahir' => 'required|max:255',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'kelas_id' => 'required',
            'thnmasuk' => 'required|max:4',
            'nohp' => $ruleNohp,
            'email' => $ruleEmail,
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
                'kelas_id' => $request->kelas_id,
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
        $mutasi = Mutasi::where('sekolah_id', Auth::user()->sekolah_id)->where('nisn', $siswa->nisn)->first();
        if ($mutasi != null) {
            if ($mutasi->nisn == $siswa->nisn) {
                $mutasi->delete();
            }
        }
        return response()->json(['success' => 'Siswa deleted successfully.']);
    }
    public function getSiswa()
    {
        $data = Siswa::where('sekolah_id', Auth::user()->sekolah_id)->where('sts_siswa', 'Aktif')->get(["id", "nisn", "nama"]);
        return response()->json($data);
    }
    public function getSiswaData($id)
    {
        $data = Siswa::where('sekolah_id', Auth::user()->sekolah_id)->where('sts_siswa', 'Aktif')->find($id);
        return response()->json($data);
    }
    public function kenaikan(Request $request)
    {
        $menu = 'Kenaikan Kelas';
        if ($request->ajax()) {
            $data = Siswa::where('sekolah_id', Auth::user()->sekolah_id)->where('sts_siswa', 'Aktif')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nisn', function ($data) {
                    return $data->nisn;
                })
                ->addColumn('nama', function ($data) {
                    return $data->nama;
                })
                ->addColumn('kelas', function ($data) {
                    return '<center>' . $data->kelas->kelas . ' ' . $data->kelas->jurusan .  ' ' . $data->kelas->ruangan . '</center>';
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
                    return '<center><input type="checkbox" class="itemCheckbox" name="siswaID[]" value="' . $row->id . '"></center>';
                })
                ->rawColumns(['kelas', 'sts_siswa', 'foto', 'action'])
                ->make(true);
        }
        return view('admin.siswa.naik', compact('menu'));
    }
    public function naik(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'kelas_id.required' => 'Silahkan pilih kelas/rombel terlebih dahulu.',
            'siswaID.required' => 'Silahkan pilih siswa/i terlebih dahulu.',
        );
        $validator = Validator::make($request->all(), [
            'kelas_id' => 'required',
            'siswaID' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $siswaID = $request->input('siswaID', []);
        $jumlahSiswaID = count($siswaID);
        $kelas = $request->input('kelas_id');
        // Menggunakan Model Eloquent untuk mengupdate data
        Siswa::whereIn('id', $siswaID)->update([
            'kelas_id' => $kelas,
        ]);
        return response()->json(['success' => '<span class="text-white">' . $jumlahSiswaID . '</span> Siswa berhasil naik kelas.']);
    }
    public function kelulusan(Request $request)
    {
        $menu = 'Kelulusan Alumni Tahun ' . Carbon::now()->year;
        $siswa = Siswa::with('kelas')->where('sekolah_id', Auth::user()->sekolah_id)->where('sts_siswa', 'Aktif')->whereHas('kelas', function ($query) {
            $query->where('kelas', 'XII');
        })->get();
        if ($request->ajax()) {
            $data = Siswa::with('kelas')->where('sekolah_id', Auth::user()->sekolah_id)->where('sts_siswa', 'Aktif')->whereHas('kelas', function ($query) {
                $query->where('kelas', 'XII');
            })->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nisn', function ($data) {
                    return $data->nisn;
                })
                ->addColumn('nama', function ($data) {
                    return $data->nama;
                })
                ->addColumn('kelas', function ($data) {
                    return '<center>' . $data->kelas->kelas . ' ' . $data->kelas->jurusan .  ' ' . $data->kelas->ruangan . '</center>';
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
                    return '<center><input type="checkbox" class="itemCheckboxA" name="CalumniID[]" value="' . $row->id . '"></center>';
                })
                ->rawColumns(['kelas', 'sts_siswa', 'foto', 'action'])
                ->make(true);
        }
        return view('admin.siswa.lulus', compact('menu', 'siswa'));
    }
    public function lulus(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'CalumniID.required' => 'Silahkan pilih calon alumni terlebih dahulu.',
        );
        $validator = Validator::make($request->all(), [
            'CalumniID' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $CalumniID = $request->input('CalumniID', []);
        $jumlahCalumniID = count($request->input('CalumniID'));
        // Menggunakan Model Eloquent untuk mengupdate data
        Siswa::whereIn('id', $CalumniID)->update([
            'sts_siswa' => 'Lulus',
        ]);
        return response()->json(['success' => 'Congratulations <span class="text-white">' . $jumlahCalumniID . '</span> Siswa berhasil diluluskan.']);
    }

    public function deleteMultiple(Request $request)
    {
        $SiswaId = $request->input('SiswaId');
        $count = count($SiswaId);
        // Menghapus foto siswa jika ada
        foreach ($SiswaId as $id) {
            $siswa = Siswa::where('sekolah_id', Auth::user()->sekolah_id)->find($id);
            if ($siswa && $siswa->foto) {
                $path = 'foto-siswa/' . $siswa->foto;
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        }
        // Menghapus entri mutasi terkait dengan siswa yang dihapus
        foreach ($SiswaId as $id) {
            $siswa = Siswa::where('sekolah_id', Auth::user()->sekolah_id)->find($id);
            if ($siswa && $siswa->nisn) {
                $nisn = $siswa->nisn;
                Mutasi::where('sekolah_id', Auth::user()->sekolah_id)->where('nisn', $nisn)->delete();
            }
        }
        //Hapus siswa
        Siswa::where('sekolah_id', Auth::user()->sekolah_id)->whereIn('id', $SiswaId)->delete();
        return response()->json(['success' => '<span class="text-white">' . $count . '</span> Siswa deleted successfully.']);
    }
    public function nonaktif(Request $request)
    {
        $siswaID = $request->input('SiswaId');
        $Nonaktif = count($siswaID);
        // Menggunakan Model Eloquent untuk mengupdate data
        Siswa::whereIn('id', $siswaID)->update([
            'sts_siswa' => 'Nonaktif',
        ]);
        return response()->json(['success' => '<span class="text-white">' . $Nonaktif . '</span> Siswa berhasil dinonaktifkan.']);
    }
}
