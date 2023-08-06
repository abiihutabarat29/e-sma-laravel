<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class TAController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Tahun Ajaran';
        if ($request->ajax()) {
            $data = TahunAjaran::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($data) {
                    return 'TA : ' . $data->nama;
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        $status = '<center><span class="badge badge-success">aktif</span></center>';
                    } elseif ($data->status == null) {
                        $status = '<center><span class="badge badge-primary">selesai</span></center>';
                    } else {
                        $status = '<center><span class="badge badge-danger">nonaktif</span></center>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    if ($row->status == 1) {
                        $btn = '<center><a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-nama="' . $row->nama . '" data-original-title="Non Aktifkan TA" class="btn btn-danger btn-xs nonaktifTa"><i class="fas fa-ban"></i> nonaktifkan/selesai</a><center>';
                    } elseif ($row->status == null) {
                        $btn = '<center><span class="badge badge-primary">selesai</span></center>';
                    } else {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editTa"><i class="fas fa-edit"></i> Edit</a>';
                        $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-nama="' . $row->nama . '" data-original-title="Aktifkan TA" class="btn btn-success btn-xs aktifTa"><i class="fas fa-check"></i> aktifkan</a><center>';
                    }
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('admin.ta.data', compact('menu'));
    }
    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'nama.required' => 'Tahun Ajaran harus diisi.',
            'nama.unique' => 'Tahun Ajaran sudah ada.',
            'nama.regex' => 'Format Tahun Ajaran tidak valid. Contoh gunakan format 2023/2024.',
        );
        if (!$request->ta_id) {
            $ruleTa = 'required|unique:tahun_ajaran,nama|regex:/^\d{4}\/\d{4}$/';
        } else {
            $lastTa = TahunAjaran::where('id', $request->ta_id)->first();
            if ($lastTa->nama == $request->nama) {
                $ruleTa = 'required|regex:/^\d{4}\/\d{4}$/';
            } else {
                $ruleTa = 'required|unique:tahun_ajaran,nama|regex:/^\d{4}\/\d{4}$/';
            }
        }
        $validator = Validator::make($request->all(), [
            'nama' => $ruleTa,
        ], $message);

        if (!$request->ta_id) {
            $validator->after(function ($validator) {
                $tahunAjaranAktif = TahunAjaran::where('status', 0)->first();

                if ($tahunAjaranAktif && $tahunAjaranAktif->status == 0) {
                    $validator->errors()->add('status', 'Maaf, Tahun Ajaran hanya masih ada yang belum diaktifkan.');
                }
            });
        }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        TahunAjaran::updateOrCreate(
            [
                'id' => $request->ta_id
            ],
            [
                'nama' => $request->nama,
                'status' => 0,
            ]
        );
        return response()->json(['success' => 'Tahun Ajaran saved successfully.']);
    }
    public function edit($id)
    {
        $ta = TahunAjaran::find($id);
        return response()->json($ta);
    }

    public function setAktif($id)
    {
        // Cari tahun ajaran berdasarkan ID
        $tahunAjaran = TahunAjaran::findOrFail($id);

        // Cek apakah ada tahun ajaran lain yang statusnya masih aktif (nilai 1)
        $activeTahunAjaran = TahunAjaran::where('status', 1)->where('id', '<>', $id)->first();

        if ($activeTahunAjaran) {
            $namaPrev = $activeTahunAjaran->nama;
            $nama = $tahunAjaran->nama;
            return response()->json(['warning' => 'Tahun Ajaran ' . $namaPrev . ' yang masih aktif. Tahun Ajaran ' . $nama . ' tidak dapat diaktifkan.']);
        } else {
            $nama = $tahunAjaran->nama;
            // Mengaktifkan tahun ajaran yang dipilih
            $tahunAjaran->update(['status' => 1]);
            return response()->json(['success' => 'Tahun Ajaran ' . $nama . ' berhasil diaktifkan.']);
        }
    }
    public function setnAktif($id)
    {
        // Cari tahun ajaran berdasarkan ID
        $tahunAjaran = TahunAjaran::findOrFail($id);
        // Mengaktifkan tahun ajaran yang dipilih
        $tahunAjaran->update(['status' => null]);
        return response()->json(['success' => 'Tahun ajaran diselesaikan.']);
    }
}
