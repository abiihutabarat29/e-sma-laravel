<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArsipLabul;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Date;

class LabulController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Arsip Laporan Bulanan';
        if ($request->ajax()) {
            $data = ArsipLabul::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_labul', function ($data) {
                    return $data->nama_labul;
                })
                ->addColumn('bulan', function ($data) {
                    return '<center>' . $data->bulan . '</center>';
                })
                ->addColumn('tahun', function ($data) {
                    return '<center>' . $data->tahun . '</center>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<center><a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteArsip"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['bulan', 'tahun', 'action'])
                ->make(true);
        }
        return view('admin.arsip-labul.data', compact('menu'));
    }
    public function store(Request $request)
    {
        // Set locale ke Indonesia
        App::setLocale('id');
        Date::setLocale('id');
        //Translate Bahasa Indonesia
        $message = array(
            'nama_labul.required' => 'Nama Laporan harus diisi.',
            'file.required' => 'File Laporan harus diisi.',
            'file.mimes' => 'File harus xls, xlsx',
            'file.max' => 'File maksimal 2MB',
            'validfile.unique' => 'Maaf, bulan ini sudah menginput arsip laporan bulanan. Mohon input kembali bulan depan.',
        );
        $validator = Validator::make($request->all(), [
            'nama_labul' => 'required',
            'file' => 'required|max:2048|mimes:xls,xlsx',
            'validfile' => 'unique:arsip_labul,validfile',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        if ($request->hasFile('file')) {
            $npsn = Auth::user()->sekolah->npsn;
            $currentMonth = Carbon::now()->translatedFormat('F');
            $currentMonthv = Carbon::now()->format('m');
            $currentYear = Carbon::now()->year;
            $validfile = $npsn  . $currentMonthv . $currentYear;
            $file = $request->file('file');
            $fileName = Str::random(100);
            $extension = $file->getClientOriginalExtension();
            $encryptedFileName = Crypt::encryptString($fileName);
            $limitedEncryptedFileName = substr($encryptedFileName . $npsn, 0, 35) . '.' . $extension;
            $file->storeAs('public/file-labul', $limitedEncryptedFileName);
            ArsipLabul::updateOrCreate(
                [
                    'id' => $request->arsip_id
                ],
                [
                    'sekolah_id' => Auth::user()->sekolah_id,
                    'nama_labul' => $request->nama_labul,
                    'bulan' => $currentMonth,
                    'tahun' => $currentYear,
                    'validfile' => $validfile,
                    'file_labul' => $limitedEncryptedFileName,
                ]
            );
            return response()->json(['message' => 'Arsip Laporan Bulanan saved successfully']);
        }
    }

    public function destroy($id)
    {
        $arsip = ArsipLabul::find($id);
        if ($arsip->file_labul) {
            Storage::delete('public/file-labul/' . $arsip->file_labul);
        }
        $arsip->delete();
        return response()->json(['success' => 'Arsip Laporan Bulanan deleted successfully.']);
    }
}
