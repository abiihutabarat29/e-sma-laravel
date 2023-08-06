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
        $ids = Auth::user()->sekolah_id;
        $spreadsheet = new Spreadsheet();
        //===============start===============
        $profil = ProfileSekolah::where('sekolah_id', $ids)->first();
        $namayss = $profil->namayss == '' ? '*tidak didefinisikan' : $profil->namayss;
        $alamatyss = $profil->alamatyss == '' ? '*tidak didefinisikan' : $profil->alamatyss;
        // Design Table Identitas Sekolah
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'A. Identitas Sekolah');
        $sheet = $spreadsheet->getActiveSheet()->setTitle('A, B, C');
        $sheet->setCellValue('A2', '1.');
        $sheet->setCellValue('A3', '2.');
        $sheet->setCellValue('A4', '3.');
        $sheet->setCellValue('A5', '4.');
        $sheet->setCellValue('A6', '5.');
        $sheet->setCellValue('A7', '6.');
        $sheet->setCellValue('A8', '7.');
        $sheet->setCellValue('A9', '8.');
        $sheet->setCellValue('A10', '9.');
        $sheet->setCellValue('A11', '10.');
        $sheet->setCellValue('A12', '11.');
        $sheet->setCellValue('A13', '12.');
        $sheet->setCellValue('A14', '13.');
        $sheet->setCellValue('A15', '14.');
        $sheet->setCellValue('B2', 'Nama Sekolah');
        $sheet->setCellValue('B3', 'Status');
        $sheet->setCellValue('B4', 'Alamat/Kecamatan/Kode Pos');
        $sheet->setCellValue('B5', 'Telepon/Hp/Email');
        $sheet->setCellValue('B6', 'Tahun Berdiri');
        $sheet->setCellValue('B7', 'Nomor SIOP Terakhir');
        $sheet->setCellValue('B8', 'NPSN');
        $sheet->setCellValue('B9', 'NSS');
        $sheet->setCellValue('B10', 'NDS');
        $sheet->setCellValue('B11', 'Jenjang Akreditasi/Tahun');
        $sheet->setCellValue('B12', 'Standar Sekolah Bertaraf');
        $sheet->setCellValue('B13', 'Nama Yayasan Perguruan/Pendidikan');
        $sheet->setCellValue('B14', 'Alamat Yayasan');
        $sheet->setCellValue('B15', 'Waktu Belajar');
        $sheet->setCellValue('C2', ':');
        $sheet->setCellValue('C3', ':');
        $sheet->setCellValue('C4', ':');
        $sheet->setCellValue('C5', ':');
        $sheet->setCellValue('C6', ':');
        $sheet->setCellValue('C7', ':');
        $sheet->setCellValue('C8', ':');
        $sheet->setCellValue('C9', ':');
        $sheet->setCellValue('C10', ':');
        $sheet->setCellValue('C11', ':');
        $sheet->setCellValue('C12', ':');
        $sheet->setCellValue('C13', ':');
        $sheet->setCellValue('C14', ':');
        $sheet->setCellValue('C15', ':');
        $sheet->setCellValue('D2', $profil->sekolah->nama_sekolah);
        $sheet->setCellValue('D3', $profil->sekolah->status);
        $sheet->setCellValue('D4', $profil->alamat . ', ' .  $profil->kabupaten->kabupaten . ', ' .  $profil->kecamatan->kecamatan . ', ' .  $profil->kodepos);
        $sheet->setCellValue('D5', "$profil->telp, $profil->email");
        $sheet->setCellValue('D6', $profil->thnberdiri);
        $sheet->setCellValue('D7', $profil->nosiop);
        $sheet->setCellValue('D8', $profil->sekolah->npsn);
        $sheet->setCellValue('D9', $profil->nss);
        $sheet->setCellValue('D10', $profil->nds);
        $sheet->setCellValue('D11', $profil->akreditas);
        $sheet->setCellValue('D12', $profil->standar);
        $sheet->setCellValue('D13', $namayss);
        $sheet->setCellValue('D14', $alamatyss);
        $sheet->setCellValue('D15', $profil->waktub);
        // Style Table
        $styleColumnCenter = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
        $styleNumberLeft = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ];
        $styleBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $styleBorderBottom = [
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('D9')->getNumberFormat()->setFormatCode('00000000000');
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A2:A15')->applyFromArray($styleColumnCenter);
        $sheet->getStyle('D6:D10')->applyFromArray($styleNumberLeft);
        // Style Auto Size
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        // ==============================================================================================
        // Export Data Keadaan Siswa dan Agama
        //Fetc Rombel X,XI,XII
        $xmipa = Rombel::where('sekolah_id', $ids)->where('kelas', 'X')->where('jurusan', 'IPA')->count();
        $xiis = Rombel::where('sekolah_id', $ids)->where('kelas', 'X')->where('jurusan', 'IPS')->count();
        $xbhs = Rombel::where('sekolah_id', $ids)->where('kelas', 'X')->where('jurusan', 'BAHASA')->count();
        $ximipa = Rombel::where('sekolah_id', $ids)->where('kelas', 'XI')->where('jurusan', 'IPA')->count();
        $xiiis = Rombel::where('sekolah_id', $ids)->where('kelas', 'XI')->where('jurusan', 'IPS')->count();
        $xibhs = Rombel::where('sekolah_id', $ids)->where('kelas', 'XI')->where('jurusan', 'BAHASA')->count();
        $xiimipa = Rombel::where('sekolah_id', $ids)->where('kelas', 'XII')->where('jurusan', 'IPA')->count();
        $xiiiis = Rombel::where('sekolah_id', $ids)->where('kelas', 'XII')->where('jurusan', 'IPS')->count();
        $xiibhs = Rombel::where('sekolah_id', $ids)->where('kelas', 'XII')->where('jurusan', 'IPS')->count();
        //Laki-laki-X-IPA
        $lxipa = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'X')
                ->where('jurusan', 'IPA')
                ->where('sts_siswa', 'Aktif');
        })->where('gender', 'L')->count();
        //Laki-laki-X-IPS
        $lxiis = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'X')
                ->where('jurusan', 'IPS')
                ->where('sts_siswa', 'Aktif');
        })->where('gender', 'L')->count();
        //Laki-laki-X-BAHASA
        $lxbhs = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'X')
                ->where('jurusan', 'BAHASA')
                ->where('sts_siswa', 'Aktif');
        })->where('gender', 'L')->count();
        //Laki-laki-XI-IPA
        $lxiipa = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XI')
                ->where('jurusan', 'IPA')
                ->where('sts_siswa', 'Aktif');
        })->where('gender', 'L')->count();
        //Laki-laki-XI-IPS
        $lxiiis = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XI')
                ->where('jurusan', 'IPS')
                ->where('sts_siswa', 'Aktif');
        })->where('gender', 'L')->count();
        //Laki-laki-XI-BAHASA
        $lxibhs = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XI')
                ->where('jurusan', 'BAHASA')
                ->where('sts_siswa', 'Aktif');
        })->where('gender', 'L')->count();
        //Laki-laki-XII-IPA
        $lxiiipa = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XII')
                ->where('jurusan', 'IPA')
                ->where('sts_siswa', 'Aktif');
        })->where('gender', 'L')->count();
        //Laki-laki-XII-IPS
        $lxiiiis = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XII')
                ->where('jurusan', 'IPS')
                ->where('sts_siswa', 'Aktif');
        })->where('gender', 'L')->count();
        //Laki-laki-XII-BAHASA
        $lxiibhs = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XII')
                ->where('jurusan', 'BAHASA')
                ->where('sts_siswa', 'Aktif');
        })->where('gender', 'L')->count();
        //Perempuan-X-IPA
        $pxipa = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'X')
                ->where('jurusan', 'IPA')
                ->where('sts_siswa', 'Aktif');
        })->where('gender', 'P')->count();
        //Perempuan-X-IPS
        $pxiis = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'X')
                ->where('jurusan', 'IPS')
                ->where('sts_siswa', 'Aktif');
        })->where('gender', 'P')->count();
        //Perempuan-X-BAHASA
        $pxbhs = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'X')
                ->where('jurusan', 'BAHASA')
                ->where('sts_siswa', 'Aktif');
        })->where('gender', 'P')->count();
        //Perempuan-XI-IPA
        $pxiipa = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XI')
                ->where('jurusan', 'IPA')
                ->where('sts_siswa', 'Aktif');
        })->where('gender', 'P')->count();
        //Perempuan-XI-IPS
        $pxiiis = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XI')
                ->where('jurusan', 'IPS')
                ->where('sts_siswa', 'Aktif');
        })->where('gender', 'P')->count();
        //Perempuan-XI-BAHASA
        $pxibhs = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XI')
                ->where('jurusan', 'BAHASA')
                ->where('sts_siswa', 'Aktif');
        })->where('gender', 'P')->count();
        //Perempuan-XII-IPA
        $pxiiipa = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XII')
                ->where('jurusan', 'IPA')
                ->where('sts_siswa', 'Aktif');
        })->where('gender', 'P')->count();
        //Perempuan-XII-IPS
        $pxiiiis = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XII')
                ->where('jurusan', 'IPS')
                ->where('sts_siswa', 'Aktif');
        })->where('gender', 'P')->count();
        //Perempuan-XII-BAHASA
        $pxiibhs = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XII')
                ->where('jurusan', 'BAHASA')
                ->where('sts_siswa', 'Aktif');
        })->where('gender', 'P')->count();
        //X-IPA-Kristen Protestan
        $xipai = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'X')
                ->where('jurusan', 'IPA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Islam');
        })->count();
        //X-IPS-Islam
        $xiisi = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'X')
                ->where('jurusan', 'IPS')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Islam');
        })->count();
        //X-BAHASA-Islam
        $xbhsi = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'X')
                ->where('jurusan', 'BAHASA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Islam');
        })->count();
        //XI-IPA-Islam
        $xiipai = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XI')
                ->where('jurusan', 'IPA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Islam');
        })->count();
        //XI-IPS-Islam
        $xiiisi = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XI')
                ->where('jurusan', 'IPS')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Islam');
        })->count();
        //XI-BAHASA-Islam
        $xibhsi = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XI')
                ->where('jurusan', 'BAHASA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Islam');
        })->count();
        //XII-IPA-Islam
        $xiiipai = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XII')
                ->where('jurusan', 'IPA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Islam');
        })->count();
        //XII-IPS-Islam
        $xiiiisi = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XII')
                ->where('jurusan', 'IPS')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Islam');
        })->count();
        //XII-BAHASA-Islam
        $xiibhsi = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XII')
                ->where('jurusan', 'BAHASA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Islam');
        })->count();
        //X-IPA-Kristen Protestan
        $xipakp = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'X')
                ->where('jurusan', 'IPA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Kristen Protestan');
        })->count();
        //X-IPS-Kristen Protestan
        $xiiskp = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'X')
                ->where('jurusan', 'IPS')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Kristen Protestan');
        })->count();
        //X-BAHASA-Kristen Protestan
        $xbhskp = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'X')
                ->where('jurusan', 'BAHASA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Kristen Protestan');
        })->count();
        //XI-IPA-Kristen Protestan
        $xiipakp = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XI')
                ->where('jurusan', 'IPA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Kristen Protestan');
        })->count();
        //XI-IPS-Kristen Protestan
        $xiiiskp = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XI')
                ->where('jurusan', 'IPS')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Kristen Protestan');
        })->count();
        //XI-BAHASA-Kristen Protestan
        $xibhskp = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XI')
                ->where('jurusan', 'BAHASA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Kristen Protestan');
        })->count();
        //XII-IPA-Kristen Protestan
        $xiiipakp = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XII')
                ->where('jurusan', 'IPA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Kristen Protestan');
        })->count();
        //XII-IPS-Kristen Protestan
        $xiiiiskp = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XII')
                ->where('jurusan', 'IPS')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Kristen Protestan');
        })->count();
        //XII-BAHASA-Kristen Protestan
        $xiibhskp = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XII')
                ->where('jurusan', 'BAHASA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Kristen Protestan');
        })->count();
        //X-IPA-Kristen Katholik
        $xipakk = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'X')
                ->where('jurusan', 'IPA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Kristen Katholik');
        })->count();
        //X-IPS-Kristen Katholik
        $xiiskk = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'X')
                ->where('jurusan', 'IPS')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Kristen Katholik');
        })->count();
        //X-BAHASA-Kristen Katholik
        $xbhskk = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'X')
                ->where('jurusan', 'BAHASA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Kristen Katholik');
        })->count();
        //XI-IPA-Kristen Katholik
        $xiipakk = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XI')
                ->where('jurusan', 'IPA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Kristen Katholik');
        })->count();
        //XI-IPS-Kristen Katholik
        $xiiiskk = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XI')
                ->where('jurusan', 'IPS')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Kristen Katholik');
        })->count();
        //XI-BAHASA-Kristen Katholik
        $xibhskk = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XI')
                ->where('jurusan', 'BAHASA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Kristen Katholik');
        })->count();
        //XII-IPA-Kristen Katholik
        $xiiipakk = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XII')
                ->where('jurusan', 'IPA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Kristen Katholik');
        })->count();
        //XII-IPS-Kristen Katholik
        $xiiiiskk = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XII')
                ->where('jurusan', 'IPS')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Kristen Katholik');
        })->count();
        //XII-BAHASA-Kristen Katholik
        $xiibhskk = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XII')
                ->where('jurusan', 'BAHASA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Kristen Katholik');
        })->count();
        //X-IPA-Hindu
        $xipah = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'X')
                ->where('jurusan', 'IPA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Hindu');
        })->count();
        //X-IPS-Hindu
        $xiish = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'X')
                ->where('jurusan', 'IPS')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Hindu');
        })->count();
        //X-BAHASA-Hindu
        $xbhsh = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'X')
                ->where('jurusan', 'BAHASA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Hindu');
        })->count();
        //XI-IPA-Hindu
        $xiipah = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XI')
                ->where('jurusan', 'IPA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Hindu');
        })->count();
        //XI-IPS-Hindu
        $xiiish = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XI')
                ->where('jurusan', 'IPS')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Hindu');
        })->count();
        //XI-BAHASA-Hindu
        $xibhsh = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XI')
                ->where('jurusan', 'BAHASA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Hindu');
        })->count();
        //XII-IPA-Hindu
        $xiiipah = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XII')
                ->where('jurusan', 'IPA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Hindu');
        })->count();
        //XII-IPS-Hindu
        $xiiiish = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XII')
                ->where('jurusan', 'IPS')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Hindu');
        })->count();
        //XII-BAHASA-Hindu
        $xiibhsh = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XII')
                ->where('jurusan', 'BAHASA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Hindu');
        })->count();
        //X-IPA-Budha
        $xipab = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'X')
                ->where('jurusan', 'IPA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Budha');
        })->count();
        //X-IPS-Budha
        $xiisb = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'X')
                ->where('jurusan', 'IPS')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Budha');
        })->count();
        //X-BAHASA-Budha
        $xbhsb = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'X')
                ->where('jurusan', 'BAHASA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Budha');
        })->count();
        //XI-IPA-Budha
        $xiipab = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XI')
                ->where('jurusan', 'IPA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Budha');
        })->count();
        //XI-IPS-Budha
        $xiiisb = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XI')
                ->where('jurusan', 'IPS')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Budha');
        })->count();
        //XI-BAHASA-Budha
        $xibhsb = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XI')
                ->where('jurusan', 'BAHASA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Budha');
        })->count();
        //XII-IPA-Budha
        $xiiipab = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XII')
                ->where('jurusan', 'IPA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Budha');
        })->count();
        //XII-IPS-Budha
        $xiiiisb = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XII')
                ->where('jurusan', 'IPS')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Budha');
        })->count();
        //XII-BAHASA-Budha
        $xiibhsb = Siswa::whereHas('kelas', function ($query) use ($ids) {
            $query->where('sekolah_id', $ids)
                ->where('kelas', 'XII')
                ->where('jurusan', 'BAHASA')
                ->where('sts_siswa', 'Aktif')
                ->where('agama', 'Budha');
        })->count();
        //==============================================
        $sheet->setCellValue('F1', 'B. Data Keadaan Siswa dan Bangunan');
        $sheet->setCellValue('F2', 'No');
        $sheet->setCellValue('F4', '1.');
        $sheet->setCellValue('F5', '2.');
        $sheet->setCellValue('F6', '3.');
        $sheet->setCellValue('F7', '4.');
        $sheet->setCellValue('F8', '5.');
        $sheet->setCellValue('F9', '6.');
        $sheet->setCellValue('F10', '7.');
        $sheet->setCellValue('F11', '8.');
        $sheet->setCellValue('F12', '9.');
        $sheet->setCellValue('F13', 'JUMLAH');
        $sheet->setCellValue('G2', 'Kelas/Program');
        $sheet->setCellValue('G4', 'X-IPA');
        $sheet->setCellValue('G5', 'XI-IPA');
        $sheet->setCellValue('G6', 'XII-IPA');
        $sheet->setCellValue('G7', 'X-IPS');
        $sheet->setCellValue('G8', 'XI-IPS');
        $sheet->setCellValue('G9', 'XII-IPS');
        $sheet->setCellValue('G10', 'X-Bahasa');
        $sheet->setCellValue('G11', 'XI-Bahasa');
        $sheet->setCellValue('G12', 'XII-Bahasa');
        $sheet->setCellValue('H2', 'SISWA');
        $sheet->setCellValue('H3', 'L');
        $sheet->setCellValue('H4', $lxipa);
        $sheet->setCellValue('H5', $lxiipa);
        $sheet->setCellValue('H6', $lxiiipa);
        $sheet->setCellValue('H7', $lxiis);
        $sheet->setCellValue('H8', $lxiiis);
        $sheet->setCellValue('H9', $lxiiiis);
        $sheet->setCellValue('H10', $lxbhs);
        $sheet->setCellValue('H11', $lxibhs);
        $sheet->setCellValue('H12', $lxiibhs);
        $sheet->setCellValue('H13', '=SUM(H4:H12)');
        $sheet->setCellValue('I3', 'P');
        $sheet->setCellValue('I4', $pxipa);
        $sheet->setCellValue('I5', $pxiipa);
        $sheet->setCellValue('I6', $pxiiipa);
        $sheet->setCellValue('I7', $pxiis);
        $sheet->setCellValue('I8', $pxiiis);
        $sheet->setCellValue('I9', $pxiiiis);
        $sheet->setCellValue('I10', $pxbhs);
        $sheet->setCellValue('I11', $pxibhs);
        $sheet->setCellValue('I12', $pxiibhs);
        $sheet->setCellValue('I13', '=SUM(I4:I12)');
        $sheet->setCellValue('J2', 'Jumlah Siswa');
        $sheet->setCellValue('J4', '=H4+I4');
        $sheet->setCellValue('J5', '=H5+I5');
        $sheet->setCellValue('J6', '=H6+I6');
        $sheet->setCellValue('J7', '=H7+I7');
        $sheet->setCellValue('J8', '=H8+I8');
        $sheet->setCellValue('J9', '=H9+I9');
        $sheet->setCellValue('J10', '=H10+I10');
        $sheet->setCellValue('J11', '=H11+I11');
        $sheet->setCellValue('J12', '=H12+I12');
        $sheet->setCellValue('J13', '=SUM(J4:J12)');
        $sheet->setCellValue('K2', 'Jumlah Kelas (Rombel)');
        $sheet->setCellValue('K4', $xmipa);
        $sheet->setCellValue('K5', $ximipa);
        $sheet->setCellValue('K6', $xiimipa);
        $sheet->setCellValue('K7', $xiis);
        $sheet->setCellValue('K8', $xiiis);
        $sheet->setCellValue('K9', $xiiiis);
        $sheet->setCellValue('K10', $xbhs);
        $sheet->setCellValue('K11', $xibhs);
        $sheet->setCellValue('K12', $xiibhs);
        $sheet->setCellValue('K13', '=SUM(K4:K12)');
        $sheet->setCellValue('L2', 'Agama');
        $sheet->setCellValue('L3', 'Islam');
        $sheet->setCellValue('L4', $xipai);
        $sheet->setCellValue('L5', $xiipai);
        $sheet->setCellValue('L6', $xiiipai);
        $sheet->setCellValue('L7', $xiisi);
        $sheet->setCellValue('L8', $xiiisi);
        $sheet->setCellValue('L9', $xiiiisi);
        $sheet->setCellValue('L10', $xbhsi);
        $sheet->setCellValue('L11', $xibhsi);
        $sheet->setCellValue('L12', $xiibhsi);
        $sheet->setCellValue('L13', '=SUM(L4:L12)');
        $sheet->setCellValue('M3', 'Kristen Protestan');
        $sheet->setCellValue('M4', $xipakp);
        $sheet->setCellValue('M5', $xiipakp);
        $sheet->setCellValue('M6', $xiiipakp);
        $sheet->setCellValue('M7', $xiiskp);
        $sheet->setCellValue('M8', $xiiiskp);
        $sheet->setCellValue('M9', $xiiiiskp);
        $sheet->setCellValue('M10', $xbhskp);
        $sheet->setCellValue('M11', $xiibhskp);
        $sheet->setCellValue('M12', $xiibhskp);
        $sheet->setCellValue('M13', '=SUM(M4:M12)');
        $sheet->setCellValue('N3', 'Kristen Katholik');
        $sheet->setCellValue('N4', $xipakk);
        $sheet->setCellValue('N5', $xiipakk);
        $sheet->setCellValue('N6', $xiiipakk);
        $sheet->setCellValue('N7', $xiiskk);
        $sheet->setCellValue('N8', $xiiiskk);
        $sheet->setCellValue('N9', $xiiiiskk);
        $sheet->setCellValue('N10', $xbhskk);
        $sheet->setCellValue('N11', $xibhskk);
        $sheet->setCellValue('N12', $xiibhskk);
        $sheet->setCellValue('N13', '=SUM(N4:N12)');
        $sheet->setCellValue('O3', 'Hindu');
        $sheet->setCellValue('O4', $xipah);
        $sheet->setCellValue('O5', $xiipah);
        $sheet->setCellValue('O6', $xiiipah);
        $sheet->setCellValue('O7', $xiish);
        $sheet->setCellValue('O8', $xiiish);
        $sheet->setCellValue('O9', $xiiiish);
        $sheet->setCellValue('O10', $xbhsh);
        $sheet->setCellValue('O11', $xibhsh);
        $sheet->setCellValue('O12', $xiibhsh);
        $sheet->setCellValue('O13', '=SUM(O4:O12)');
        $sheet->setCellValue('P3', 'Budha');
        $sheet->setCellValue('P4', $xipab);
        $sheet->setCellValue('P5', $xiipab);
        $sheet->setCellValue('P6', $xiiipab);
        $sheet->setCellValue('P7', $xiisb);
        $sheet->setCellValue('P8', $xiiisb);
        $sheet->setCellValue('P9', $xiiiisb);
        $sheet->setCellValue('P10', $xbhsb);
        $sheet->setCellValue('P11', $xibhsb);
        $sheet->setCellValue('P12', $xiibhsb);
        $sheet->setCellValue('P13', '=SUM(P4:P12)');
        $sheet->setCellValue('Q3', 'Jumlah');
        $sheet->setCellValue('Q4', '=SUM(L4:P4)');
        $sheet->setCellValue('Q5', '=SUM(L5:P5)');
        $sheet->setCellValue('Q6', '=SUM(L6:P6)');
        $sheet->setCellValue('Q7', '=SUM(L7:L7)');
        $sheet->setCellValue('Q8', '=SUM(L8:L8)');
        $sheet->setCellValue('Q9', '=SUM(L9:L9)');
        $sheet->setCellValue('Q10', '=SUM(L10:L10)');
        $sheet->setCellValue('Q11', '=SUM(L11:L11)');
        $sheet->setCellValue('Q12', '=SUM(L12:L12)');
        $sheet->setCellValue('Q13', '=SUM(Q4:Q12)');
        //Marge left
        $sheet->mergeCells('F1:Q1');
        $sheet->mergeCells('F13:G13');
        $sheet->mergeCells('H2:I2');
        $sheet->mergeCells('L2:Q2');
        //Marge down
        $sheet->mergeCells('F2:F3');
        $sheet->mergeCells('G2:G3');
        $sheet->mergeCells('J2:J3');
        $sheet->mergeCells('K2:K3');
        //=========================
        $sheet->getStyle('F1')->getFont()->setBold(true);
        $sheet->getStyle('F2:Q13')->applyFromArray($styleColumnCenter);
        $sheet->getStyle('F2:Q13')->applyFromArray($styleBorder);
        $sheet->getStyle('G4:G12')->applyFromArray($styleNumberLeft);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setWidth(25, 'pt');
        $sheet->getColumnDimension('I')->setWidth(25, 'pt');
        $sheet->getColumnDimension('J')->setWidth(70, 'pt');
        $sheet->getColumnDimension('K')->setWidth(110, 'pt');
        $sheet->getColumnDimension('M')->setWidth(110, 'pt');
        $sheet->getColumnDimension('N')->setWidth(110, 'pt');
        // ==============================================================================================
        //===============end===============
        $writer = new Xlsx($spreadsheet);
        $sekolah = Auth::user()->sekolah->nama_sekolah;
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
