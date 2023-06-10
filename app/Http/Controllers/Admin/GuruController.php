<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Golongan;
use App\Models\Jurusan;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Guru';
        if ($request->ajax()) {
            $data = Guru::where('sekolah_id', Auth::user()->sekolah_id)->get();
            return Datatables::of($data)
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
                        $foto = '<center><img src="' . url("storage/foto-guru/" . $data->foto) . '" width="30px" class="img rounded"><center>';
                    } else {
                        $foto = '<center><img src="' . url("storage/foto-guru/blank.png") . '" width="30px" class="img rounded"><center>';
                    }
                    return $foto;
                })
                ->addColumn('action', function ($row) {
                    $btn = '        <a class="btn btn-primary btn-xs" href="' . route('guru.edit',  Crypt::encryptString($row->id)) . '">Edit</a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteGuru">Hapus</a><center>';
                    return $btn;
                })
                ->rawColumns(['foto', 'action'])
                ->make(true);
        }
        return view('admin.guru.data', compact('menu'));
    }
    public function create(Request $req)
    {
        $menu = 'Tambah Data Guru';
        $golongan = Golongan::get();
        $mapel = MataPelajaran::get();
        $jurusan = Jurusan::get();
        return view('admin.guru.create', compact('menu', 'golongan', 'mapel', 'jurusan'));
    }
    public function edit($id)
    {
        $menu = 'Edit Data Guru';
        $guru = Guru::where('sekolah_id', Auth::user()->sekolah_id)->find(Crypt::decryptString($id));
        $golongan = Golongan::get();
        $mapel = MataPelajaran::get();
        $jurusan = Jurusan::get();
        return view('admin.guru.edit', compact('menu', 'golongan', 'mapel', 'jurusan', 'guru'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
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
            'nrg.required' => 'NRG harus diisi.',
            'nrg.min' => 'NRG minimal 16 angka.',
            'nrg.max' => 'NRG maksimal 16 angka.',
            'nrg.unique' => 'NRG sudah terdaftar.',
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
            'stsserti.required' => 'Status Sertifikasi harus dipilih.',
            'mapel.required' => 'Mata Pelajaran harus dipilih.',
            'thnserti.max' => 'Tahun Sertifikasi maksimal 4 angka.',
            'tmtguru.required' => 'TMT Guru harus diisi.',
            'tmtsekolah.required' => 'TMT Sekolah harus diisi.',
            'jlhjam.required' => 'Jumlah Jam harus diisi.',
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
            'nip' => 'max:18|unique:guru,nip',
            'nik' => 'required|min:16|max:16|unique:guru,nik',
            'nuptk' => 'required|min:16|max:16|unique:guru,nuptk',
            'nrg' => 'required|min:16|max:16|unique:guru,nrg',
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
            'stsserti' => 'required',
            'mapel' => 'required',
            'thnserti' => 'max:4',
            'tmtguru' => 'required',
            'tmtsekolah' => 'required',
            'jlhjam' => 'required',
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
            $img->storeAs('public/foto-guru/', $fileName);
        } else {
            $fileName = null;
        }
        Guru::create(
            [
                'sekolah_id' => Auth::user()->sekolah_id,
                'nip' => $request->nip,
                'nik' => $request->nik,
                'nuptk' => $request->nuptk,
                'nrg' => $request->nrg,
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
                'sts_serti' => $request->stsserti,
                'mapel' => $request->mapel,
                'thnserti' => $request->thnserti,
                'tmtguru' => $request->tmtguru,
                'tmtsekolah' => $request->tmtsekolah,
                'j_jam' => $request->jlhjam,
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
        return redirect()->route('guru.index')->with('toast_success', 'Guru saved successfully.');
    }
    public function update(Request $request, $id)
    {
        $guru = Guru::find(Crypt::decryptString($id));
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
            'nrg.required' => 'NRG harus diisi.',
            'nrg.min' => 'NRG minimal 16 angka.',
            'nrg.max' => 'NRG maksimal 16 angka.',
            'nrg.unique' => 'NRG sudah terdaftar.',
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
            'stsserti.required' => 'Status Sertifikasi harus dipilih.',
            'mapel.required' => 'Mata Pelajaran harus dipilih.',
            'thnserti.max' => 'Tahun Sertifikasi maksimal 4 angka.',
            'tmtguru.required' => 'TMT Guru harus diisi.',
            'tmtsekolah.required' => 'TMT Sekolah harus diisi.',
            'jlhjam.required' => 'Jumlah Jam harus diisi.',
            'nohp.required' => 'Nomor Handphone harus diisi.',
            'nohp.min' => 'Nomor minimal 11 angka.',
            'nohp.max' => 'Nomor maksimal 12 angka.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Penulisan email tidak benar.',
            'foto.image' => 'Foto harus gambar.',
            'foto.mimes' => 'Foto harus jpeg,png,jpg.',
            'foto.max' => 'Foto maksimal 1MB.',
        );
        if ($guru->nip == $request->nip) {
            $ruleNip = 'max:18';
        } else {
            $ruleNip = 'max:18|unique:guru,nip';
        }
        if ($guru->nik == $request->nik) {
            $ruleNik = 'required|min:16|max:16';
        } else {
            $ruleNik = 'required|min:16|max:16|unique:guru,nik';
        }
        if ($guru->nuptk == $request->nuptk) {
            $ruleNuptk = 'required|min:16|max:16';
        } else {
            $ruleNuptk = 'required|min:16|max:16|unique:guru,nuptk';
        }
        if ($guru->nrg == $request->nrg) {
            $ruleNrg = 'required|min:16|max:16';
        } else {
            $ruleNrg = 'required|min:16|max:16|unique:guru,nrg';
        }
        $validator = Validator::make($request->all(), [
            'nip' => $ruleNip,
            'nik' => $ruleNik,
            'nuptk' => $ruleNuptk,
            'nrg' => $ruleNrg,
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
            'stsserti' => 'required',
            'mapel' => 'required',
            'thnserti' => 'max:4',
            'tmtguru' => 'required',
            'tmtsekolah' => 'required',
            'jlhjam' => 'required',
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
            $img->storeAs('public/foto-guru/',  $fileName);
            //delete old
            Storage::delete('public/foto-guru/' . $guru->foto);
        } else {
            $fileName = $guru->foto;
        }
        $guru->update(
            [
                'nip' => $request->nip,
                'nik' => $request->nik,
                'nuptk' => $request->nuptk,
                'nrg' => $request->nrg,
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
                'sts_serti' => $request->stsserti,
                'mapel' => $request->mapel,
                'thnserti' => $request->thnserti,
                'tmtguru' => $request->tmtguru,
                'tmtsekolah' => $request->tmtsekolah,
                'j_jam' => $request->jlhjam,
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
        return redirect()->route('guru.index')->with('toast_success', 'Guru updated successfully.');
    }
    public function destroy(Guru $guru)
    {
        $guru->delete();
        if ($guru->foto) {
            Storage::delete('public/foto-guru/' . $guru->foto);
        }
        return response()->json(['success' => 'Guru deleted successfully.']);
        // return redirect()->route('guru.index')->with('toast_success', 'Guru deleted successfully.');
    }
}
