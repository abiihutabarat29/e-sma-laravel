<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Golongan;
use App\Models\Jurusan;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Guru';
        if ($request->ajax()) {
            $data = Guru::get();
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
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editGuru"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteGuru"><i class="fas fa-trash"></i></a><center>';
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

    public function store(Request $request)
    {
        // dd($request->all());
        //Translate Bahasa Indonesia
        $message = array(
            'nip.min' => 'NIP minimal 18 angka.',
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
            'nama.required' => 'Nama harus dipilih.',
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
            'thnserti.required' => 'Tahun Sertifikasi harus diisi.',
            'thnserti.max' => 'Tahun Sertifikasi maksimal 4 angka.',
            'tmtguru.required' => 'TMT Guru harus diisi.',
            'tmtsekolah.required' => 'TMT Sekolah harus diisi.',
            'jlhjam.required' => 'Jumlah Jam harus diisi.',
            'kehadiran.required' => 'Kehadiran harus diisi.',
            'nohp.required' => 'Nomor Handphone harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Penulisan email tidak benar.',
            'email.unique' => 'Email sudah terdaftar.',
        );

        $validator = Validator::make($request->all(), [
            'nip' => 'min:18|unique:guru,nip',
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
            'thnserti' => 'required|max:4',
            'tmtguru' => 'required',
            'tmtsekolah' => 'required',
            'jlhjam' => 'required',
            'kehadiran' => 'required',
            'nohp' => 'required',
            'email' => 'required|email|unique:guru,email'
        ], $message);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
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
                'foto' => $request->foto,
            ]
        );
        return redirect()->route('guru.index')->with('toast_success', 'Guru saved successfully.');
    }

    public function destroy($id)
    {
        Guru::find($id)->delete();
        return response()->json(['success' => 'Jurusan deleted successfully.']);
        // return redirect()->route('guru.index')->with('toast_success', 'Guru deleted successfully.');
    }
}
