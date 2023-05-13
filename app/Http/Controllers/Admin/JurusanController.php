<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurusan;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class JurusanController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Jurusan';
        if ($request->ajax()) {
            $data = Jurusan::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('jurusan', function ($data) {
                    return $data->jurusan;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editJur"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteJur"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['jurusan', 'action'])
                ->make(true);
        }
        return view('admin.jurusan.data', compact('menu'));
    }
    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'jurusan.required' => 'Jurusan harus diisi.',
        );
        $validator = Validator::make($request->all(), [
            'jurusan' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        Jurusan::updateOrCreate(
            [
                'id' => $request->jurusan_id
            ],
            [
                'jurusan' => $request->jurusan,
            ]
        );
        return response()->json(['success' => 'Jurusan saved successfully.']);
    }
    public function edit($id)
    {
        $jurusan = Jurusan::find($id);
        return response()->json($jurusan);
    }

    public function destroy($id)
    {
        Jurusan::find($id)->delete();
        return response()->json(['success' => 'Jurusan deleted successfully.']);
    }
}
