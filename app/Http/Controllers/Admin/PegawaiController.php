<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Golongan;
use App\Models\Jurusan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Pegawai';
        if ($request->ajax()) {
            $data = Pegawai::where('sekolah_id', Auth::user()->sekolah_id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nik', function ($data) {
                    return $data->nik;
                })
                ->addColumn('nama', function ($data) {
                    return $data->nama;
                })
                ->addColumn('status', function ($data) {
                    return $data->status;
                })
                ->addColumn('foto', function ($data) {
                    if ($data->foto != null) {
                        $foto = '<center><img src="' . url("storage/foto-pegawai/" . $data->foto) . '" width="30px" class="img rounded"><center>';
                    } else {
                        $foto = '<center><img src="' . url("storage/foto-pegawai/blank.png") . '" width="30px" class="img rounded"><center>';
                    }
                    return $foto;
                })
                ->addColumn('action', function ($row) {
                    $btn = '        <a class="btn btn-primary btn-xs" href="' . route('pegawai.edit',  Crypt::encryptString($row->id)) . '">Edit</a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deletePegawai">Hapus</a><center>';
                    return $btn;
                })
                ->rawColumns(['foto', 'action'])
                ->make(true);
        }
        return view('admin.pegawai.data', compact('menu'));
    }
    public function create(Request $req)
    {
        $menu = 'Tambah Data Pegawai';
        $golongan = Golongan::get();
        $jurusan = Jurusan::get();
        return view('admin.pegawai.create', compact('menu', 'golongan', 'jurusan'));
    }
    public function edit($id)
    {
        $menu = 'Edit Data Pegawai';
        $pegawai = Pegawai::where('sekolah_id', Auth::user()->sekolah_id)->find(Crypt::decryptString($id));
        $golongan = Golongan::get();
        $jurusan = Jurusan::get();
        return view('admin.pegawai.edit', compact('menu', 'golongan', 'jurusan', 'pegawai'));
    }

    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'nip.max' => 'NIP maksimal 18 angka.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'nik.required' => 'NIK harus diisi.',
            'nik.min' => 'NIK minimal 16 angka.',
            'nik.max' => 'NIK maksimal 16 angka.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'nuptk.required' => 'NUPTK harus diisi.',
            'nuptk.min' => 'NUPTK minimal 16 angka.',
            'nuptk.max' => 'NUPTK maksimal 16 angka.',
            'nuptk.unique' => 'NUPTK sudah terdaftar.',
            'nama.required' => 'Nama harus diisi.',
            'agama.required' => 'Agama harus dipilih.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.max' => 'Alamat melebihi maksimal karakter.',
            'tempat_lahir.required' => 'Tempat Lahir harus diisi.',
            'tempat_lahir.max' => 'Tempat Lahir  melebihi maksimal karakter.',
            'tgl_lahir.required' => 'Tanggal Lahir harus diisi.',
            'jenis_kelamin.required' => 'Jenis Kelamin harus dipilih.',
            'pendidikan.required' => 'Pendidikan harus dipilih.',
            'jurusan.required' => 'Jurusan harus dipilih.',
            'thnijazah.required' => 'Tahun Ijazah harus diisi.',
            'thnijazah.max' => 'Tahun Ijazah maksimal 4 angka.',
            'status.required' => 'Status Kepegawaian harus dipilih.',
            'tmtpegawai.required' => 'TMT Pegawai harus diisi.',
            'tmtsekolah.required' => 'TMT Sekolah harus diisi.',
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
            'nip' => 'max:18|unique:pegawai,nip',
            'nik' => 'required|min:16|max:16|unique:pegawai,nik',
            'nuptk' => 'required|min:16|max:16|unique:pegawai,nuptk',
            'nama' => 'required|max:255',
            'agama' => 'required',
            'alamat' => 'required|max:255',
            'tempat_lahir' => 'required|max:255',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'pendidikan' => 'required',
            'jurusan' => 'required',
            'thnijazah' => 'required|max:4',
            'status' => 'required',
            'tmtpegawai' => 'required',
            'tmtsekolah' => 'required',
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
            $img->storeAs('public/foto-pegawai/', $fileName);
        } else {
            $fileName = null;
        }
        Pegawai::create(
            [
                'sekolah_id' => Auth::user()->sekolah_id,
                'nip' => $request->nip,
                'nik' => $request->nik,
                'nuptk' => $request->nuptk,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'agama' => $request->agama,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'gender' => $request->jenis_kelamin,
                'golongan' => $request->golongan,
                'tingkat' => $request->pendidikan,
                'jurusan' => $request->jurusan,
                'thnijazah' => $request->thnijazah,
                'status' => $request->status,
                'tmtpegawai' => $request->tmtpegawai,
                'tmtsekolah' => $request->tmtsekolah,
                'kehadiran' => $request->kehadiran,
                'nmdiklat' => $request->nama_diklat,
                'tdiklat' => $request->tempat_diklat,
                'lmdiklat' => $request->lmdiklat,
                'thndiklat' => $request->thndiklat,
                'nohp' => $request->nohp,
                'email' => $request->email,
                'foto' => $fileName,
            ]
        );
        return redirect()->route('pegawai.index')->with('toast_success', 'Pegawai saved successfully.');
    }
    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::find(Crypt::decryptString($id));
        //Translate Bahasa Indonesia
        $message = array(
            'nip.max' => 'NIP maksimal 18 angka.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'nik.required' => 'NIK harus diisi.',
            'nik.min' => 'NIK minimal 16 angka.',
            'nik.max' => 'NIK maksimal 16 angka.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'nuptk.required' => 'NUPTK harus diisi.',
            'nuptk.min' => 'NUPTK minimal 16 angka.',
            'nuptk.max' => 'NUPTK maksimal 16 angka.',
            'nuptk.unique' => 'NUPTK sudah terdaftar.',
            'nama.required' => 'Nama harus diisi.',
            'agama.required' => 'Agama harus dipilih.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.max' => 'Alamat melebihi maksimal karakter.',
            'tempat_lahir.required' => 'Tempat Lahir harus diisi.',
            'tempat_lahir.max' => 'Tempat Lahir  melebihi maksimal karakter.',
            'tgl_lahir.required' => 'Tanggal Lahir harus diisi.',
            'jenis_kelamin.required' => 'Jenis Kelamin harus dipilih.',
            'pendidikan.required' => 'Pendidikan harus dipilih.',
            'jurusan.required' => 'Jurusan harus dipilih.',
            'thnijazah.required' => 'Tahun Ijazah harus diisi.',
            'thnijazah.max' => 'Tahun Ijazah maksimal 4 angka.',
            'status.required' => 'Status Kepegawaian harus dipilih.',
            'tmtpegawai.required' => 'TMT Pegawai harus diisi.',
            'tmtsekolah.required' => 'TMT Sekolah harus diisi.',
            'nohp.required' => 'Nomor Handphone harus diisi.',
            'nohp.min' => 'Nomor minimal 11 angka.',
            'nohp.max' => 'Nomor maksimal 12 angka.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Penulisan email tidak benar.',
            'foto.image' => 'Foto harus gambar.',
            'foto.mimes' => 'Foto harus jpeg,png,jpg.',
            'foto.max' => 'Foto maksimal 1MB.',
        );
        if ($pegawai->nip == $request->nip) {
            $ruleNip = 'max:18';
        } else {
            $ruleNip = 'max:18|unique:pegawai,nip';
        }
        if ($pegawai->nik == $request->nik) {
            $ruleNik = 'required|min:16|max:16';
        } else {
            $ruleNik = 'required|min:16|max:16|unique:pegawai,nik';
        }
        if ($pegawai->nuptk == $request->nuptk) {
            $ruleNuptk = 'required|min:16|max:16';
        } else {
            $ruleNuptk = 'required|min:16|max:16|unique:pegawai,nuptk';
        }
        $validator = Validator::make($request->all(), [
            'nip' => $ruleNip,
            'nik' => $ruleNik,
            'nuptk' => $ruleNuptk,
            'nama' => 'required|max:255',
            'agama' => 'required',
            'alamat' => 'required|max:255',
            'tempat_lahir' => 'required|max:255',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'pendidikan' => 'required',
            'jurusan' => 'required',
            'thnijazah' => 'required|max:4',
            'status' => 'required',
            'tmtpegawai' => 'required',
            'tmtsekolah' => 'required',
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
            $img->storeAs('public/foto-pegawai/', $fileName);
            //delete old
            Storage::delete('public/foto-pegawai/' . $pegawai->foto);
        } else {
            $fileName = $pegawai->foto;
        }
        $pegawai->update(
            [
                'sekolah_id' => Auth::user()->sekolah_id,
                'nip' => $request->nip,
                'nik' => $request->nik,
                'nuptk' => $request->nuptk,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'agama' => $request->agama,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'gender' => $request->jenis_kelamin,
                'golongan' => $request->golongan,
                'tingkat' => $request->pendidikan,
                'jurusan' => $request->jurusan,
                'thnijazah' => $request->thnijazah,
                'status' => $request->status,
                'tmtpegawai' => $request->tmtpegawai,
                'tmtsekolah' => $request->tmtsekolah,
                'kehadiran' => $request->kehadiran,
                'nmdiklat' => $request->nama_diklat,
                'tdiklat' => $request->tempat_diklat,
                'lmdiklat' => $request->lmdiklat,
                'thndiklat' => $request->thndiklat,
                'nohp' => $request->nohp,
                'email' => $request->email,
                'foto' => $fileName,
            ]
        );
        return redirect()->route('pegawai.index')->with('toast_success', 'Pegawai saved successfully.');
    }
    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
        if ($pegawai->foto) {
            Storage::delete('public/foto-pegawai/' . $pegawai->foto);
        }
        return response()->json(['success' => 'Pegawai deleted successfully.']);
    }
}
