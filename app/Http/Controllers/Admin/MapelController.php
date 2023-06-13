<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class MapelController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Mata Pelajaran';
        if ($request->ajax()) {
            $data = MataPelajaran::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('mapel', function ($data) {
                    return $data->mapel;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editMapel"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteMapel"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['mapel', 'action'])
                ->make(true);
        }
        return view('admin.mapel.data', compact('menu'));
    }
    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'mapel.required' => 'Mata Pelajaran harus diisi.',
        );
        $validator = Validator::make($request->all(), [
            'mapel' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        MataPelajaran::updateOrCreate(
            [
                'id' => $request->mapel_id
            ],
            [
                'mapel' => $request->mapel,
            ]
        );
        return response()->json(['success' => 'Mata Pelajaran saved successfully.']);
    }
    public function edit($id)
    {
        $mapel = MataPelajaran::find($id);
        return response()->json($mapel);
    }

    public function destroy($id)
    {
        MataPelajaran::find($id)->delete();
        return response()->json(['success' => 'Mata Pelajaran deleted successfully.']);
    }
    public function getMapel()
    {
        $data = MataPelajaran::get(["id", "mapel"]);
        return response()->json($data);
    }
}
