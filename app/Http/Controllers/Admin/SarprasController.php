<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sarpras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SarprasController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Sarpras';
        if ($request->ajax()) {
            $data = Sarpras::where('sekolah_id', Auth::user()->sekolah_id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('sarana', function ($data) {
                    return $data->sarana->sarana;
                })
                ->addColumn('baik', function ($data) {
                    return '<center>' . $data->baik . '</center>';
                })
                ->addColumn('rusak_ringan', function ($data) {
                    return '<center>' . $data->rusak_ringan . '</center>';
                })
                ->addColumn('rusak_berat', function ($data) {
                    return '<center>' . $data->rusak_berat . '</center>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editSarpras"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteSarpras"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['baik', 'rusak_ringan', 'rusak_berat', 'action'])
                ->make(true);
        }
        return view('admin.sarpras.data', compact('menu'));
    }
    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'sarana_id.required' => 'Sarana harus dipilih.',
            'baik.required' => 'Jumlah Baik harus diisi.',
            'rusak_ringan.required' => 'Jumlah Rusak Ringan harus diisi.',
            'rusak_berat.required' => 'Jumlah Rusak Berat tersedia harus diisi.',
        );
        $validator = Validator::make($request->all(), [
            'sarana_id' => 'required',
            'baik' => 'required',
            'rusak_ringan' => 'required',
            'rusak_berat' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        Sarpras::updateOrCreate(
            [
                'id' => $request->sarpras_id
            ],
            [
                'sekolah_id' => Auth::user()->sekolah_id,
                'sarana_id' => $request->sarana_id,
                'baik' => $request->baik,
                'rusak_ringan' => $request->rusak_ringan,
                'rusak_berat' => $request->rusak_berat,
                'keterangan' => $request->keterangan,
            ]
        );
        return response()->json(['success' => 'Sarpras saved successfully.']);
    }
    public function edit($id)
    {
        $sarpras = Sarpras::find($id);
        return response()->json($sarpras);
    }

    public function destroy($id)
    {
        Sarpras::find($id)->delete();
        return response()->json(['success' => 'Sarpras deleted successfully.']);
    }
}
