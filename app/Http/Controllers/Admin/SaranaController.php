<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sarana;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class SaranaController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Sarana';
        if ($request->ajax()) {
            $data = Sarana::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('sarana', function ($data) {
                    return $data->sarana;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editSarana"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteSarana"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['sarana', 'action'])
                ->make(true);
        }
        return view('admin.sarana.data', compact('menu'));
    }
    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'sarana.required' => 'Nama Sarana harus diisi.',
        );
        $validator = Validator::make($request->all(), [
            'sarana' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        Sarana::updateOrCreate(
            [
                'id' => $request->sarana_id
            ],
            [
                'sarana' => $request->sarana,
            ]
        );
        return response()->json(['success' => 'Sarana saved successfully.']);
    }
    public function edit($id)
    {
        $sarana = Sarana::find($id);
        return response()->json($sarana);
    }

    public function destroy($id)
    {
        Sarana::find($id)->delete();
        return response()->json(['success' => 'Sarana deleted successfully.']);
    }
}
