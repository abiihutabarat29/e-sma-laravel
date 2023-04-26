<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Golongan;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class GolonganController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Golongan';
        if ($request->ajax()) {
            $data = Golongan::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('golongan', function ($data) {
                    return $data->golongan;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editGol"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteGol"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['golongan', 'action'])
                ->make(true);
        }
        return view('admin.golongan.data', compact('menu'));
    }
    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'golongan.required' => 'Golongan harus diisi.',
        );
        $validator = Validator::make($request->all(), [
            'golongan' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        Golongan::updateOrCreate(
            [
                'id' => $request->golongan_id
            ],
            [
                'golongan' => $request->golongan,
            ]
        );
        return response()->json(['success' => 'Golongan saved successfully.']);
    }
    public function edit($id)
    {
        $golongan = Golongan::find($id);
        return response()->json($golongan);
    }

    public function destroy($id)
    {
        Golongan::find($id)->delete();
        return response()->json(['success' => 'Golongan deleted successfully.']);
    }
}
