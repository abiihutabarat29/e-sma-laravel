<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventaris;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;


class InventarisController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Inventaris';
        if ($request->ajax()) {
            $data = Inventaris::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('inventaris', function ($data) {
                    return $data->inventaris;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editInv"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteInv"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['inventaris', 'action'])
                ->make(true);
        }
        return view('admin.inventaris.data', compact('menu'));
    }
    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'inventaris.required' => 'Nama Inventaris harus diisi.',
        );
        $validator = Validator::make($request->all(), [
            'inventaris' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        Inventaris::updateOrCreate(
            [
                'id' => $request->inventaris_id
            ],
            [
                'inventaris' => $request->inventaris,
            ]
        );
        return response()->json(['success' => 'Inventaris saved successfully.']);
    }
    public function edit($id)
    {
        $inventaris = Inventaris::find($id);
        return response()->json($inventaris);
    }

    public function destroy($id)
    {
        Inventaris::find($id)->delete();
        return response()->json(['success' => 'Inventaris deleted successfully.']);
    }
}
