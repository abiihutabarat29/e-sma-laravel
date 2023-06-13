<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dakl;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class DaklController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Data DAKL Guru';
        if ($request->ajax()) {
            $data = Dakl::where('sekolah_id', Auth::user()->sekolah_id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('mapel', function ($data) {
                    return $data->mapel->mapel;
                })
                ->addColumn('dibutuhkan', function ($data) {
                    return '<center>' . $data->dibutuhkan . '</center>';
                })
                ->addColumn('pns', function ($data) {
                    return '<center>' . $data->pns . '</center>';
                })
                ->addColumn('nonpns', function ($data) {
                    return '<center>' . $data->nonpns . '</center>';
                })
                ->addColumn('kurang', function ($data) {
                    return '<center>' . $data->kurang . '</center>';
                })
                ->addColumn('lebih', function ($data) {
                    return '<center>' . $data->lebih . '</center>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editDakl"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteDakl"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['dibutuhkan', 'pns', 'nonpns', 'kurang', 'lebih', 'action'])
                ->make(true);
        }
        return view('admin.dakl.data', compact('menu'));
    }
    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'mapel_id.required' => 'Mata Pelajaran haru dipilih.',
            'dibutuhkan.required' => 'Jumlah dibutuhkan harus diisi.',
            'pns.required' => 'Jumlah PNS tersedia harus diisi.',
            'nonpns.required' => 'Jumlah Non PNS tersedia harus diisi.',
            'kurang.required' => 'Jumlah Kurang harus diisi.',
            'lebih.required' => 'Jumlah Dibutuhkan harus diisi.',
        );
        $validator = Validator::make($request->all(), [
            'mapel_id' => 'required',
            'dibutuhkan' => 'required',
            'pns' => 'required',
            'nonpns' => 'required',
            'kurang' => 'required',
            'lebih' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        Dakl::updateOrCreate(
            [
                'id' => $request->dakl_id
            ],
            [
                'sekolah_id' => Auth::user()->sekolah_id,
                'mapel_id' => $request->mapel_id,
                'dibutuhkan' => $request->dibutuhkan,
                'pns' => $request->pns,
                'nonpns' => $request->nonpns,
                'kurang' => $request->kurang,
                'lebih' => $request->lebih,
                'keterangan' => $request->keterangan,
            ]
        );
        return response()->json(['success' => 'DAKL saved successfully.']);
    }
    public function edit($id)
    {
        $dakl = Dakl::find($id);
        return response()->json($dakl);
    }

    public function destroy($id)
    {
        Dakl::find($id)->delete();
        return response()->json(['success' => 'DAKL deleted successfully.']);
    }
}
