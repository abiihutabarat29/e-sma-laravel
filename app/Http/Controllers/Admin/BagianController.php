<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bagian;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class BagianController extends Controller
{

    public function index(Request $request)
    {
        $menu = 'Bagian';
        if ($request->ajax()) {
            $data = Bagian::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editBagian"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteBagian"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.bagian.data', compact('menu'));
    }

    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'nama_bagian.required' => 'Nama Bagian harus diisi.',
        );
        $validator = Validator::make($request->all(), [
            'nama_bagian' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        Bagian::updateOrCreate(
            [
                'id' => $request->bagian_id
            ],
            [
                'nama_bagian' => $request->nama_bagian,
            ]
        );

        return response()->json(['success' => 'Bagian saved successfully.']);
    }

    public function edit($id)
    {
        $bagian = Bagian::find($id);
        return response()->json($bagian);
    }

    public function destroy($id)
    {
        Bagian::find($id)->delete();
        return response()->json(['success' => 'Bagian deleted successfully.']);
    }
}
