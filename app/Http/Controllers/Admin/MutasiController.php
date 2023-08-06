<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HistoriSiswa;
use App\Models\Mutasi;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class MutasiController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Data Mutasi Masuk';
        if ($request->ajax()) {
            $data = Mutasi::where('sekolah_id', Auth::user()->sekolah_id)->where('sts_mutasi', 'pindahan')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('no_surat', function ($data) {
                    return $data->no_surat;
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
                ->addColumn('asal_sekolah', function ($data) {
                    return $data->asal_sekolah;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<center><a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteMutasiM">Hapus</a><center>';
                    return $btn;
                })
                ->rawColumns(['kelas', 'sts_mutasi', 'action'])
                ->make(true);
        }
        return view('admin.mutasi-masuk.data', compact('menu'));
    }
    public function create(Request $req)
    {
        $menu = 'Tambah Data Mutasi Masuk';
        return view('admin.mutasi-masuk.create', compact('menu'));
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
            'no_surat.required' => 'Nomor Surat harus diisi.',
            'asal_sekolah.required' => 'Asal Sekolah harus diisi.',
            'asal_sekolah.max' => 'Asal Sekolah melebihi maksimal karakter.',
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
            'no_surat' => 'required',
            'asal_sekolah' => 'required|max:255',
            'nohp' => $ruleNohp,
            'email' => $ruleEmail,
        ], $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $tahunAjaranAktif = TahunAjaran::where('status', 1)->first();
        if ($tahunAjaranAktif) {
            $tahunAjaranId = $tahunAjaranAktif->id;
            Mutasi::create(
                [
                    'sekolah_id' => Auth::user()->sekolah_id,
                    'tahun_ajaran_id' => $tahunAjaranId,
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
                    'no_surat' => $request->no_surat,
                    'asal_sekolah' => $request->asal_sekolah,
                    'keterangan' => $request->keterangan,
                    'sts_mutasi' => 'Pindahan',
                ]
            );
            $siswa = Siswa::create(
                [
                    'sekolah_id' => Auth::user()->sekolah_id,
                    'tahun_ajaran_id' => $tahunAjaranId,
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
                ]
            );
            HistoriSiswa::create([
                'sekolah_id' => Auth::user()->sekolah_id,
                'siswa_id' => $siswa->id,
                'kelas_id' => $request->kelas_id,
                'tahun_ajaran_id' => $tahunAjaranId,
                'status' => 'Pindahan',
            ]);
            return redirect()->route('mutasi-masuk.index')->with('toast_success', 'Siswa Pindahan saved successfully.');
        } else {
            return redirect()->route('mutasi-masuk.index')->with('toast_error', 'Tahun Ajaran saat ini belum aktif.');
        }
    }
    public function destroy(Mutasi $mutasi)
    {
        $data_siswa = Siswa::where('sekolah_id', Auth::user()->sekolah_id)->where('nisn', $mutasi->nisn)->first();
        if ($data_siswa != null) {
            if ($mutasi->nisn == $data_siswa->nisn) {
                $data_siswa->delete();
                if ($data_siswa->foto) {
                    Storage::delete('public/foto-siswa/' . $data_siswa->foto);
                }
            }
        }
        $mutasi->delete();
        return response()->json(['success' => 'Siswa Pindahan deleted successfully.']);
    }
    public function indexk(Request $request)
    {
        $menu = 'Data Mutasi Keluar';
        if ($request->ajax()) {
            $data = Mutasi::where('sekolah_id', Auth::user()->sekolah_id)->where('sts_mutasi', 'keluar')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('no_surat', function ($data) {
                    return $data->no_surat;
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
                ->addColumn('sekolah_tujuan', function ($data) {
                    return $data->sekolah_tujuan;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<center><a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteMutasiK">Hapus</a><center>';
                    return $btn;
                })
                ->rawColumns(['kelas', 'sts_mutasi', 'action'])
                ->make(true);
        }
        return view('admin.mutasi-keluar.data', compact('menu'));
    }
    // public function createk(Request $req)
    // {
    //     $menu = 'Tambah Data Mutasi Keluar';
    //     return view('admin.mutasi-keluar.create', compact('menu'));
    // }
    public function storek(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'siswa_id.required' => 'Siswa harus dipilih.',
            'no_surat.required' => 'Nomor Surat harus diisi.',
            'sekolah_tujuan.required' => 'Sekolah Tujuan harus diisi.',
            'sekolah_tujuan.max' => 'Sekolah Tujuan melebihi maksimal karakter.',
            'keterangan.max' => 'Keterangan melebihi maksimal karakter.',
        );
        $validator = Validator::make($request->all(), [
            'siswa_id' => 'required',
            'no_surat' => 'required',
            'sekolah_tujuan' => 'required|max:255',
            'keterangan' => 'max:255',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $tahunAjaranAktif = TahunAjaran::where('status', 1)->first();
        if ($tahunAjaranAktif) {
            $tahunAjaranId = $tahunAjaranAktif->id;
            $data = new Mutasi();
            $data->sekolah_id = Auth::user()->sekolah_id;
            $data->tahun_ajaran_id = $tahunAjaranId;
            $data->nisn = $request->nisn;
            $data->nama = $request->nama;
            $data->kelas_id = $request->kelas_id;
            $data->alamat = $request->alamat;
            $data->tempat_lahir = $request->tempat_lahir;
            $data->tgl_lahir = $request->tgl_lahir;
            $data->gender = $request->gender;
            $data->agama = $request->agama;
            $data->nohp = $request->nohp;
            $data->email = $request->email;
            $data->tahun_masuk = $request->tahun_masuk;
            $data->sts_mutasi = 'Keluar';
            $data->no_surat = $request->no_surat;
            $data->sekolah_tujuan = $request->sekolah_tujuan;
            $data->keterangan = $request->keterangan;
            $data->save();
            $siswa = Siswa::where('sekolah_id', Auth::user()->sekolah_id)->findOrFail($request->siswa_id);
            HistoriSiswa::create([
                'sekolah_id' => Auth::user()->sekolah_id,
                'siswa_id' => $siswa->id,
                'kelas_id' => $request->kelas_id,
                'tahun_ajaran_id' => $tahunAjaranId,
                'status' => 'Keluar',
            ]);
            $siswa->delete();
            return response()->json(['success' => 'Siswa Dropout successfully.']);
        } else {
            return response()->json(['warning' => 'Tahun Ajaran saat ini belum aktif.']);
        }
    }
    public function destroyk($id)
    {
        Mutasi::find($id)->delete();
        return response()->json(['success' => 'Mutasi Keluar deleted successfully.']);
    }
}
