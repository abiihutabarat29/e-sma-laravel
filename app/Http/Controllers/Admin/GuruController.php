<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Golongan;
use App\Models\MataPelajaran;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Guru';
        if ($request->ajax()) {
            $data = Guru::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('nik', function ($data) {
                    return $data->nik;
                })
                ->addColumn('nama', function ($data) {
                    return $data->nama;
                })
                ->addColumn('status', function ($data) {
                    return $data->status;
                })
                ->addColumn('foto', function ($data) {
                    if ($data->profile->foto != null) {
                        $foto = '<center><img src="' . url("storage/foto-guru/" . $data->foto) . '" width="30px" class="img rounded"><center>';
                    } else {
                        $foto = '<center><img src="' . url("storage/foto-guru/blank.png") . '" width="30px" class="img rounded"><center>';
                    }
                    return $foto;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editGuru"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteGuru"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['foto', 'action'])
                ->make(true);
        }
        return view('admin.guru.data', compact('menu'));
    }
    public function create(Request $req)
    {
        $menu = 'Tambah Data Guru';
        $golongan = Golongan::get();
        $mapel = MataPelajaran::get();
        return view('admin.guru.create', compact('menu', 'golongan', 'mapel'));
    }
}
