<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class TAController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Tahun Pelajaran dan Semester';
        if ($request->ajax()) {
            $data = TahunPelajaran::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tahun', function ($data) {
                    return 'TP : ' . $data->tahun;
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        $btn = '<center><span class="text-success"><i class="fas fa-check"></i> Aktif</span></center>';
                    } else {
                        $btn = '<center><a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" class="btn btn-primary btn-sm aktifTa">Aktifkan</a><center>';
                    }
                    return $btn;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-warning btn-sm editTa">Edit</a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-tahun="' . $row->tahun . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteTa">Hapus</a><center>';
                    return $btn;
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('admin.ta.data', compact('menu'));
    }
    public function semesterData(Request $request)
    {
        if ($request->ajax()) {
            $data = Semester::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('semester', function ($data) {
                    return 'Semester : ' . $data->semester;
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        $btn = '<center><span class="text-success"><i class="fas fa-check"></i> Aktif</span></center>';
                    } else {
                        $btn = '<center><a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $data->id . '" class="btn btn-primary btn-sm aktifSmt">Aktifkan</a><center>';
                    }
                    return $btn;
                })
                ->rawColumns(['status'])
                ->make(true);
        }
        return view('admin.ta.data', compact('menu'));
    }
    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'tahun.required' => 'Tahun Pelajaran harus diisi.',
            'tahun.unique' => 'Tahun Pelajaran sudah ada.',
            'tahun.regex' => 'Format Tahun Pelajaran tidak valid. Contoh gunakan format 2023/2024.',
        );
        if (!$request->taId) {
            $ruleTa = 'required|unique:tahun_pelajaran,tahun|regex:/^\d{4}\/\d{4}$/';
        } else {
            $lastTa = TahunPelajaran::where('id', $request->taId)->first();
            if ($lastTa->tahun == $request->tahun) {
                $ruleTa = 'required|regex:/^\d{4}\/\d{4}$/';
            } else {
                $ruleTa = 'required|unique:tahun_pelajaran,tahun|regex:/^\d{4}\/\d{4}$/';
            }
        }
        $validator = Validator::make($request->all(), [
            'tahun' => $ruleTa,
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        TahunPelajaran::updateOrCreate(
            [
                'id' => $request->taId
            ],
            [
                'tahun' => $request->tahun,
            ]
        );
        return response()->json(['success' => 'Tahun Pelajaran saved successfully.']);
    }
    public function edit($id)
    {
        $ta = TahunPelajaran::find($id);
        return response()->json($ta);
    }
    public function destroy($id)
    {
        TahunPelajaran::find($id)->delete();
        return response()->json(['success' => 'Tahun Pelajaran deleted successfully.']);
    }
    public function setAktifTa($id)
    {
        $tahunPelajaranAktif = TahunPelajaran::find($id);
        if ($tahunPelajaranAktif) {
            $tahunPelajaranAktif->status = 1;
            $tahunPelajaranAktif->save();
            TahunPelajaran::where('id', '!=', $id)->update(['status' => 0]);
            return response()->json(['success' => 'Tahun Pelajaran ' . $tahunPelajaranAktif->tahun . ' diaktifkan.']);
        }
        return response()->json(['success' => 'Tahun Pelajaran tidak ditemukan.']);
    }
    public function setAktifSmt($id)
    {
        $semesterAktif = Semester::find($id);
        if ($semesterAktif) {
            $semesterAktif->status = 1;
            $semesterAktif->save();
            Semester::where('id', '!=', $id)->update(['status' => 0]);
            return response()->json(['success' => 'Semester ' . $semesterAktif->semester . ' diaktifkan.']);
        }
        return response()->json(['success' => 'Semester tidak ditemukan.']);
    }
}
