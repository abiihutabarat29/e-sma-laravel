<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArsipLabul;
use App\Models\Bangunan;
use App\Models\Dakl;
use App\Models\Guru;
use App\Models\InventarisSekolah;
use App\Models\Pegawai;
use App\Models\ProfileSekolah;
use App\Models\Rombel;
use App\Models\Sarpras;
use App\Models\Siswa;
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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Response;

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
                ->addColumn('unduh', function ($data) {
                    return '<center><a href="' . route('file.unduh', (Crypt::encryptString($data->id))) . '" class="btn btn-xs btn-primary" title="Unduh Laporan"><i class="fa fa-download"></i></a></center>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<center><a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteArsip"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['bulan', 'tahun', 'unduh', 'action'])
                ->make(true);
        }
        return view('admin.arsip-labul.data', compact('menu'));
    }
    public function downloadFile($id)
    {
        $file = ArsipLabul::findOrFail(Crypt::decryptString($id));

        $filePath = 'public/file-labul/' . $file->file_labul;

        if (Storage::exists($filePath)) {
            return response()->download(storage_path('app/' . $filePath));
            return redirect()->route('arsip-labul.index')->with('toast_success', 'Arsip downloaded successfully.');
        } else {
            return redirect()->route('arsip-labul.index')->with('toast_error', 'Maaf terjadi kesalahan.');
        }
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
            'file.max' => 'File maksimal 1MB',
            'validfile.unique' => 'Maaf, bulan ini sudah menginput arsip laporan bulanan. Mohon input kembali bulan depan.',
        );
        $validator = Validator::make($request->all(), [
            'nama_labul' => 'required',
            'file' => 'required|max:1024|mimes:xls,xlsx',
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
    public function indexGenerate()
    {
        $menu = 'Generate Laporan Bulanan';
        $profil = ProfileSekolah::where('sekolah_id', Auth::user()->sekolah_id)->first();
        $wilayah = Bangunan::where('sekolah_id', Auth::user()->sekolah_id)->first();
        $rombel = Rombel::where('sekolah_id', Auth::user()->sekolah_id)->count();
        $dakl = Dakl::where('sekolah_id', Auth::user()->sekolah_id)->count();
        $sarpras = Sarpras::where('sekolah_id', Auth::user()->sekolah_id)->count();
        $inventaris_sekolah = InventarisSekolah::where('sekolah_id', Auth::user()->sekolah_id)->count();
        $guru = Guru::where('sekolah_id', Auth::user()->sekolah_id)->count();
        $pegawai = Pegawai::where('sekolah_id', Auth::user()->sekolah_id)->count();
        $siswa = Siswa::where('sekolah_id', Auth::user()->sekolah_id)->where('sts_siswa', 'Aktif')->count();
        //Validasi Button Generate
        $profilValid = ProfileSekolah::where('sekolah_id', Auth::user()->sekolah_id)->first();
        $wilayahValid = Bangunan::where('sekolah_id', Auth::user()->sekolah_id)->first();
        $rombelValid = Rombel::where('sekolah_id', Auth::user()->sekolah_id)->get();
        $daklValid = Dakl::where('sekolah_id', Auth::user()->sekolah_id)->get();
        $sarprasValid = Sarpras::where('sekolah_id', Auth::user()->sekolah_id)->get();
        $inventaris_sekolahValid = InventarisSekolah::where('sekolah_id', Auth::user()->sekolah_id)->get();
        $guruValid = Guru::where('sekolah_id', Auth::user()->sekolah_id)->get();
        $pegawaiValid = Pegawai::where('sekolah_id', Auth::user()->sekolah_id)->get();
        $siswaValid = Siswa::where('sekolah_id', Auth::user()->sekolah_id)->where('sts_siswa', 'Aktif')->get();
        return view(
            'admin.generate.data',
            compact(
                'menu',
                'profil',
                'wilayah',
                'rombel',
                'dakl',
                'sarpras',
                'inventaris_sekolah',
                'guru',
                'pegawai',
                'siswa',
                'profilValid',
                'wilayahValid',
                'rombelValid',
                'daklValid',
                'sarprasValid',
                'inventaris_sekolahValid',
                'guruValid',
                'pegawaiValid',
                'siswaValid'
            )
        );
    }
    public function generate()
    {
        $id = Auth::user()->sekolah_id;
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'Hello World !');

        $writer = new Xlsx($spreadsheet);
        // Set locale ke Indonesia
        App::setLocale('id');
        Date::setLocale('id');
        $sekolah = Auth::user()->sekolah->nama_sekolah;
        $currentMonth = Carbon::now()->translatedFormat('F');
        $currentYear = Carbon::now()->year;
        $waktu = date('H:i:s');
        // Simpan file Excel ke buffer
        ob_start();
        $writer->save('php://output');
        $content = ob_get_clean();
        // Kembalikan konten file untuk diunduh
        $response = new Response($content, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
        $response->header('X-Sekolah', $sekolah);
        return $response;
    }
}
