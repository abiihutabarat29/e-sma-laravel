<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KelompokMapel;
use App\Models\KategoriMapel;
use App\Models\MataPelajaran;
use App\Models\SubKelompokMapel;
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
    public function kelompok(Request $request)
    {
        if ($request->ajax()) {
            $data = KelompokMapel::orderBy('id', 'DESC')->get();
            return Datatables::of($data)
                ->addColumn('kategori', function ($data) {
                    return '<center>' . $data->kategori->kategori . '</center>';
                })
                ->addColumn('kode', function ($data) {
                    return '<center>' . $data->kode . '</center>';
                })
                ->addColumn('nama_kelompok', function ($data) {
                    return $data->nama_kelompok;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-warning btn-xs editKel"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-kelompok="' . $row->nama_kelompok . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteKel"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['kategori', 'kode', 'action'])
                ->make(true);
        }
        return view('admin.mapel.data', compact('menu'));
    }
    public function storeKelompok(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'kategori_id.required' => 'Kategori harus dipilih.',
            'kode.required' => 'Kode harus diisi.',
            'nama.required' => 'Nama Kelompok harus diisi.',
        );
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required',
            'kode' => 'required',
            'nama' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        KelompokMapel::updateOrCreate(
            [
                'id' => $request->kelompokId
            ],
            [
                'kategori_id' => $request->kategori_id,
                'kode' => $request->kode,
                'nama_kelompok' => $request->nama,
            ]
        );
        return response()->json(['success' => 'Kelompok Mapel saved successfully.']);
    }

    public function editKelompok($id)
    {
        $kelompokmapel = KelompokMapel::find($id);
        return response()->json($kelompokmapel);
    }
    public function destroyKelompok($id)
    {
        $kelompokmapel =  KelompokMapel::find($id);
        $kelompokmapel->delete();
        return response()->json(['success' => '' . $kelompokmapel->nama_kelompok . ' deleted successfully.']);
    }
    public function subKelompok(Request $request)
    {
        if ($request->ajax()) {
            $data = SubKelompokMapel::get();
            return Datatables::of($data)
                ->addColumn('kode', function ($data) {
                    return '<center>' . $data->kode . '<center>';
                })
                ->addColumn('nama_subkel', function ($data) {
                    return $data->nama_subkelompok;
                })
                ->addColumn('kelompok', function ($data) {
                    return '<center>' . $data->kelompok->nama_kelompok . '<center>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-warning btn-xs editSubKel"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-subkelompok="' . $row->nama_subkelompok . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteSubKel"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['kode', 'kelompok', 'action'])
                ->make(true);
        }
        return view('admin.mapel.data', compact('menu'));
    }
    public function storeSubKelompok(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'kelompok_id.required' => 'Kelompok harus dipilih.',
            'kodeSub.required' => 'Kode harus diisi.',
            'namaSub.required' => 'Nama Sub Kelompok harus diisi.',
        );
        $validator = Validator::make($request->all(), [
            'kelompok_id' => 'required',
            'kodeSub' => 'required',
            'namaSub' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        SubKelompokMapel::updateOrCreate(
            [
                'id' => $request->subkelompokId
            ],
            [
                'kelompok_id' => $request->kelompok_id,
                'kode' => $request->kodeSub,
                'nama_subkelompok' => $request->namaSub,
            ]
        );
        return response()->json(['success' => 'Sub Kelompok Mapel saved successfully.']);
    }

    public function editSubKelompok($id)
    {
        $subkelompokmapel = SubKelompokMapel::find($id);
        return response()->json($subkelompokmapel);
    }
    public function destroySubKelompok($id)
    {
        $subkelompokmapel =  SubKelompokMapel::find($id);
        $subkelompokmapel->delete();
        return response()->json(['success' => '' . $subkelompokmapel->nama_subkelompok . ' deleted successfully.']);
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
    public function getKategoriMapel()
    {
        $data = KategoriMapel::get(["id", "kategori"]);
        return response()->json($data);
    }
    public function getKelompok()
    {
        $data = KelompokMapel::get(["id", "nama_kelompok"]);
        return response()->json($data);
    }
}
