<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventarisSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class InventarisSekolahController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Data Inventaris';
        if ($request->ajax()) {
            $data = InventarisSekolah::where('sekolah_id', Auth::user()->sekolah_id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('inventaris', function ($data) {
                    return $data->inventaris->inventaris;
                })
                ->addColumn('dibutuhkan', function ($data) {
                    return '<center>' . $data->dibutuhkan . '</center>';
                })
                ->addColumn('ada', function ($data) {
                    return '<center>' . $data->ada . '</center>';
                })
                ->addColumn('kurang', function ($data) {
                    return '<center>' . $data->kurang . '</center>';
                })
                ->addColumn('lebih', function ($data) {
                    return '<center>' . $data->lebih . '</center>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editInventaris"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteInventaris"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['dibutuhkan', 'ada', 'kurang', 'lebih', 'action'])
                ->make(true);
        }
        return view('admin.inventaris-sekolah.data', compact('menu'));
    }
    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'inventaris_id.required' => 'Inventaris harus dipilih.',
            'dibutuhkan.required' => 'Jumlah Dibutuhkan harus diisi.',
            'ada.required' => 'Jumlah Ada harus diisi.',
            'kurang.required' => 'Jumlah Kurang harus diisi.',
            'lebih.required' => 'Jumlah Lebih harus diisi.',
        );
        $validator = Validator::make($request->all(), [
            'inventaris_id' => 'required',
            'dibutuhkan' => 'required',
            'ada' => 'required',
            'kurang' => 'required',
            'lebih' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        InventarisSekolah::updateOrCreate(
            [
                'id' => $request->inventarissekolah_id
            ],
            [
                'sekolah_id' => Auth::user()->sekolah_id,
                'inventaris_id' => $request->inventaris_id,
                'dibutuhkan' => $request->dibutuhkan,
                'ada' => $request->ada,
                'kurang' => $request->kurang,
                'lebih' => $request->lebih,
            ]
        );
        return response()->json(['success' => 'Data Inventaris saved successfully.']);
    }
    public function edit($id)
    {
        $inventaris = InventarisSekolah::find($id);
        return response()->json($inventaris);
    }

    public function destroy($id)
    {
        InventarisSekolah::find($id)->delete();
        return response()->json(['success' => 'Data Inventaris deleted successfully.']);
    }
}
