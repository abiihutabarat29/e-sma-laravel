<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rekening;
use App\Models\Detail;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class DetailController extends Controller
{
    public function index(Request $request, $id)
    {
        $menu = 'Detail';
        $id = $id;
        $rekening = rekening::where('id', $id)->first();
        $detail = detail::where('rekening_id', $id)->first();

        if ($request->ajax()) {
            $data = Detail::with('rekening')->where('rekening_id', $id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_detail', function ($data) {
                    $link = $data->nama_detail . '<br>' . 'Spesifikasi :' . $data->spesifikasi;
                    return $link;
                })
                ->addColumn('koefisien', function ($data) {
                    if ($data->koefisien2 == "") {
                        $link = $data->koefisien1;
                    } else {
                        $link = $data->koefisien1 . " X " . $data->koefisien2 . " " . $data->satuan;
                    }

                    return $link;
                })
                ->addColumn('harga', function ($data) {
                    $link = 'Rp. ' . number_format($data->harga, 0, ',', '.');
                    return $link;
                })
                ->addColumn('jumlah', function ($data) {
                    $link = 'Rp. ' . number_format($data->jumlah, 0, ',', '.');
                    return $link;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editDetail"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteDetail"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.detail.data', compact('menu', 'id', 'rekening', 'detail'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_detail' => 'required',
            'koefisien1' => 'required',
            'satuan' => 'required',
            'harga' => 'required',
            'jumlah' => 'required',
            // 'kegiatan_id' => 'required',
            // 'subkegiatan_id' => 'required',
            'rekening_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $harga = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $request->harga);
        $harga_bersih = str_replace('Rp ', '', $harga);
        $jumlah = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $request->jumlah);
        $total = str_replace('Rp. ', '', $jumlah);

        Detail::updateOrCreate(
            [
                'id' => $request->detail_id
            ],
            [
                'nama_detail' => $request->nama_detail,
                'spesifikasi' => $request->spesifikasi,
                'koefisien1' => $request->koefisien1,
                'koefisien2' => $request->koefisien2,
                'satuan' => $request->satuan,
                'harga' => $harga_bersih,
                'jumlah' => $total,
                // 'kegiatan_id' => $request->kegiatan_id,
                // 'subkegiatan_id' => $request->subkegiatan_id,
                'rekening_id' => $request->rekening_id,
            ]
        );

        return response()->json(['success' => 'Detail saved successfully.']);
    }

    public function edit($rekening_id, $id)
    {
        $detail = Detail::find($id);
        return response()->json($detail);
    }

    public function destroy($id)
    {
        Detail::find($id)->delete();
        return response()->json(['success' => 'Detail deleted successfully.']);
    }
}
