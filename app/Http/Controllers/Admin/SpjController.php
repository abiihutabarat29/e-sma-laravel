<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Rekening;
use Illuminate\Http\Request;
use App\Models\SPJ;
use App\Models\User;
use App\Models\Subkegiatan;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class SpjController extends Controller
{

    public function index(Request $request)
    {
        $menu = 'Pengajuan SPJ';
        if ($request->ajax()) {
            $data = SPJ::where('bagian_id', '=', Auth::user()->bagian_id)->whereIn('status', [1, 2, 5])
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('tanggal', function ($data) {
                    return  \Carbon\Carbon::createFromFormat('Y-m-d', $data->tanggal)->format('d/m/Y');
                })
                ->addColumn('kegiatan', function ($data) {
                    $link = $data->kegiatan->nama_kegiatan;
                    return $link;
                })
                ->addColumn('subkeg', function ($data) {
                    $link = $data->subkegiatan->nama_sub;
                    return $link;
                })
                ->addColumn('rekening', function ($data) {
                    $link = $data->rekening->nama_rekening;
                    return $link;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        $btn = '<center><span class="badge badge-primary badge-xs">Belum dikirim</span></center>';
                    } elseif ($row->status == 2) {
                        $btn = '<center><span class="badge badge-info badge-xs">Menunggu Verifikasi</span></center>';
                    } elseif ($row->status == 3) {
                        $btn = '<center><span class="badge badge-success badge-xs">Diterima</span></center>';
                    } elseif ($row->status == 4) {
                        $btn = '<center><span class="badge badge-danger badge-xs text-white">Ditolak</span></center>';
                    } else {
                        $btn = '<center><span class="badge badge-warning badge-xs text-white">Dikembalikan</span></center>';
                    }
                    return $btn;
                })
                ->addColumn('action', function ($row) {
                    if ($row->status == 1) {
                        $btn = '<center>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item kirim" href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Kirim">Kirim</i></a>
                                <a class="dropdown-item delete" href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete">Delete</a>
                            </div>
                        </div>
                    </center>';
                    } elseif ($row->status == 2) {
                        $btn = '<center><i>no action</i></center>';
                    } elseif ($row->status == 5) {
                        $btn = '<center>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="' . route('spj.show',  Crypt::encryptString($row->id)) . '">Review</a>
                                <a class="dropdown-item" href="' . route('spj.edit',  Crypt::encryptString($row->id)) . '">Edit Ulang</a>
                                <a class="dropdown-item delete" href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete">Delete</a>
                            </div>
                        </div>
                    </center>';
                    } else {
                        $btn = '';
                    }
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.spj.data', compact('menu'));
    }

    public function create()
    {
        $menu = 'Pengajuan SPJ';
        $setting = Setting::first();
        $kegiatan = Kegiatan::where('bagian_id', Auth::user()->bagian_id)->get();
        return view('admin.spj.create', compact('menu', 'kegiatan', 'setting'));
    }

    public function getSubkeg(Request $request)
    {
        $data['subkeg'] = Subkegiatan::where("kegiatan_id", $request->kegiatan_id)->get(["nama_sub", "id"]);
        return response()->json($data);
    }

    public function getRekening(Request $request)
    {
        $data['rekening'] = Rekening::where("subkegiatan_id", $request->subkeg_id)->get(["nama_rekening", "id"]);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        //Translate Bahasa Indonesia
        $message = array(
            'kegiatan_id.required' => 'Kegiatan harus dipilih.',
            'subkegiatan_id.required' => 'Sub Kegiatan harus dipilih.',
            'rekening_id.required' => 'Rekening harus dipilih.',
            'uraian.required' => 'Uraian harus diisi.',
            'uraian.max' => 'Uraian maksimal 500 karakter.',
            'kwitansi.required' => 'Kwitansi harus diisi.',
            'nama_penerima.required' => 'Nama Penerima harus diisi.',
            'alamat_penerima.required' => 'Alamat harus diisi.',
            'alamat_penerima.max' => 'Alamat maksimal 500 karakter.',
            'jenis_spm.required' => 'Jenis SPM harus dipilih.',
            'file.required' => 'File harus diupload.',
            'file.mimes' => 'File harus .pdf',
            'file.max' => 'File maksimal 5MB.',
        );
        $validator = Validator::make($request->all(), [
            'kegiatan_id' => 'required',
            'subkegiatan_id' => 'required',
            'rekening_id' => 'required',
            'uraian' => 'required|max:500',
            'kwitansi' => 'required',
            'nama_penerima' => 'required',
            'alamat_penerima' => 'required|max:500',
            'jenis_spm' => 'required',
            'file' => 'required|mimes:pdf,application/pdf|max:5120',
        ], $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->tanggal == '') {
            $tanggal = Carbon::now()->format('Y-m-d');
        } else {
            $tanggal = $request->tanggal;
        }
        $total =  preg_replace('/[^0-9]/', '', $request->kwitansi);
        $rek = Rekening::where('id', $request->rekening_id)->first();
        if ($total > $rek->sisa_rekening) {
            return redirect()->route('spj.index')->with(['toast_error' => 'Maaf, anggaran tidak mencukupi!' . "\n" . 'Sisa anggaran : Rp.' . number_format($rek->sisa_rekening, 0, ',', '.')]);
        }
        $fileName = time() . '.' . $request->file->extension();
        $request->file->storeAs('public/file', $fileName);
        SPJ::create([
            'gu' =>  $request->gu,
            'tanggal' => $tanggal,
            'bagian_id' => Auth::user()->bagian_id,
            'kegiatan_id' => $request->kegiatan_id,
            'subkegiatan_id' => $request->subkegiatan_id,
            'rekening_id' => $request->rekening_id,
            'uraian' => $request->uraian,
            'kwitansi' => $total,
            'nama_penerima' => $request->nama_penerima,
            'alamat_penerima' => $request->alamat_penerima,
            'jenis_spm' => $request->jenis_spm,
            'file' => $fileName,
            'status' => '1',
        ]);
        return redirect()->route('spj.index')->with('toast_success', 'SPJ Berhasil ditambah');
    }
    public function kirim(SPJ $spj)
    {
        $spj->update(['status' => '2']);
        return response()->json(['toast_success' => 'SPJ Berhasil dikirim']);
    }

    public function destroy(SPJ $spj)
    {
        if ($spj->file) {
            Storage::delete('public/file/' . $spj->file);
        }
        $spj->delete();
        return response()->json(['success' => 'SPJ deleted successfully.']);
    }
    public function destroyback(SPJ $spj)
    {
        $spj->update([
            'status' => '5',
        ]);
        $kwitansi = $spj->kwitansi;

        // Update Rekening
        $sisa_rekening = Rekening::where('id', $spj->rekening_id)->value('sisa_rekening');
        $tambahkan_rekening = Rekening::find($spj->rekening_id);
        $tambahkan_rekening->sisa_rekening = $sisa_rekening + $kwitansi;
        $tambahkan_rekening->save();

        // Update Kegiatan
        $sisa_kegiatan = Kegiatan::where('id', $spj->kegiatan_id)->value('sisa_kegiatan');
        $update_sisa_kegiatan = Kegiatan::find($spj->kegiatan_id);
        $update_sisa_kegiatan->sisa_kegiatan = $sisa_kegiatan + $kwitansi;
        $update_sisa_kegiatan->save();

        // Update Sub Kegiatan
        $sisa_subkegiatan = Subkegiatan::where('id', $spj->subkegiatan_id)->value('sisa_sub');
        $update_sisa_subkegiatan = Subkegiatan::find($spj->subkegiatan_id);
        $update_sisa_subkegiatan->sisa_sub = $sisa_subkegiatan + $kwitansi;
        $update_sisa_subkegiatan->save();

        return response()->json(['success' => 'SPJ deleted & returned to user successfully.']);
    }

    public function verifikasi(Request $request)
    {
        $menu = 'Verifikasi SPJ';
        if ($request->ajax()) {
            $data = SPJ::where('status', 2)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('tanggal', function ($data) {
                    return  \Carbon\Carbon::createFromFormat('Y-m-d', $data->tanggal)->format('d/m/Y');
                })
                ->addColumn('bagian', function ($data) {
                    $link = $data->bagian->nama_bagian;
                    return $link;
                })
                ->addColumn('nilai', function ($data) {
                    $link = $data->kwitansi;
                    $link = 'Rp. ' . number_format($link, 0, ',', '.');
                    return $link;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<center><a class="btn btn-success btn-xs" href="' . route('spj.verify', Crypt::encryptString($row->id)) . '"><i class="fa fa-check-double"></i> Verifikasi</span></a></center>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.spj.verifikasi', compact('menu'));
    }
    public function verify($id)
    {
        $spj = SPJ::find(Crypt::decryptString($id));
        $user = User::join('spj', 'users.bagian_id', '=', 'spj.bagian_id')
            ->where('spj.status', '=', 2)->first();
        // dd($user);
        $menu = 'Verifikasi SPJ';
        return view('admin.spj.verif', compact('menu', 'spj', 'user'));
    }
    public function show($id)
    {
        $spj = SPJ::find(Crypt::decryptString($id));
        if (Auth::user()->level == 1) {
            $user = User::join('spj', 'users.bagian_id', '=', 'spj.bagian_id')
                ->where('spj.id', '=', Crypt::decryptString($id))->first();
            // dd($user);
        } else {
            $user = User::join('spj', 'users.bagian_id', '=', 'spj.bagian_id')
                ->where('spj.id', '=',  Crypt::decryptString($id))->first();
        }
        // dd($user);
        $menu = 'SPJ';
        return view('admin.spj.review', compact('menu', 'user', 'spj'));
    }

    public function terima($id)
    {
        $spj = SPJ::find($id);
        if ($spj->alasan != null) {
            $spj->update(['alasan' => null]);
        }
        $spj->update(['status' => '3']);
        $kwitansi = $spj->kwitansi;

        // Update Rekening
        $sisa_rekening = Rekening::where('id', $spj->rekening_id)->value('sisa_rekening');
        $kurangkan_rekening = Rekening::find($spj->rekening_id);
        $kurangkan_rekening->sisa_rekening = $sisa_rekening - $kwitansi;
        $kurangkan_rekening->save();

        // Update Kegiatan
        $sisa_kegiatan = Kegiatan::where('id', $spj->kegiatan_id)->value('sisa_kegiatan');
        $update_sisa_kegiatan = Kegiatan::find($spj->kegiatan_id);
        $update_sisa_kegiatan->sisa_kegiatan = $sisa_kegiatan - $kwitansi;
        $update_sisa_kegiatan->save();

        // Update Sub Kegiatan
        $sisa_subkegiatan = Subkegiatan::where('id', $spj->subkegiatan_id)->value('sisa_sub');
        $update_sisa_subkegiatan = Subkegiatan::find($spj->subkegiatan_id);
        $update_sisa_subkegiatan->sisa_sub = $sisa_subkegiatan - $kwitansi;
        $update_sisa_subkegiatan->save();

        return response()->json(['success' => 'SPJ Berhasil diterima']);
    }

    public function diterima(Request $request)
    {
        $menu = 'SPJ Diterima';
        if ($request->ajax()) {
            $user = Auth::user()->bagian_id;
            if (Auth::user()->level == 1) {
                $data = SPJ::where('status', 3)->get();
            } else {
                $data = SPJ::where('status', 3)->where('bagian_id', $user)->get();
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('tanggal', function ($data) {
                    return  \Carbon\Carbon::createFromFormat('Y-m-d', $data->tanggal)->format('d/m/Y');
                })
                ->addColumn('kegiatan', function ($data) {
                    $link = $data->kegiatan->nama_kegiatan;
                    return $link;
                })
                ->addColumn('subkeg', function ($data) {
                    $link = $data->subkegiatan->nama_sub;
                    return $link;
                })
                ->addColumn('rekening', function ($data) {
                    $link = $data->rekening->nama_rekening;
                    return $link;
                })
                ->addColumn('nilai', function ($data) {
                    $link = $data->kwitansi;
                    $link = 'Rp. ' . number_format($link, 0, ',', '.');
                    return $link;
                })
                ->addColumn('action', function ($row) {
                    if (Auth::user()->level == 1) {
                        $btn = '<center>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" href="' . route('spj.view', Crypt::encryptString($row->id)) . '">Review</a>
                            <a class="dropdown-item delete" href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete">Delete</a>
                               </div>
                               </div>
                           </center>';
                    } else {
                        $btn = '<center>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" href="' . route('spj.show', Crypt::encryptString($row->id)) . '">Review</a>
                           </div>
                           </div>
                       </center>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        if (Auth::user()->level == 1) {
            $export = SPJ::where('status', '=', 3)->get();
            // dd($ex);
            return view('admin.spj.diterima', compact('menu', 'export'));
        } else {
            return view('admin.spj.diterimausr', compact('menu'));
        }
    }
    public function ditolak(Request $request)
    {
        $menu = 'SPJ Ditolak';
        if ($request->ajax()) {
            $user = Auth::user()->bagian_id;
            if (Auth::user()->level == 1) {
                $data = SPJ::where('status', 4)->get();
            } else {
                $data = SPJ::where('status', 4)->where('bagian_id', $user)->get();
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('tanggal', function ($data) {
                    return  \Carbon\Carbon::createFromFormat('Y-m-d', $data->tanggal)->format('d/m/Y');
                })
                ->addColumn('kegiatan', function ($data) {
                    $link = $data->kegiatan->kode_kegiatan;
                    $link = $link . ' ' . $data->kegiatan->nama_kegiatan;
                    return $link;
                })
                ->addColumn('subkeg', function ($data) {
                    $link = $data->subkegiatan->kode_sub;
                    $link = $link . ' ' . $data->subkegiatan->nama_sub;
                    return $link;
                })
                ->addColumn('rekening', function ($data) {
                    $link = $data->rekening->kode_rekening;
                    $link = $link . ' ' . $data->rekening->nama_rekening;
                    return $link;
                })
                ->addColumn('nilai', function ($data) {
                    $link = $data->kwitansi;
                    $link = 'Rp. ' . number_format($link, 0, ',', '.');
                    return $link;
                })
                ->addColumn('action', function ($row) {
                    if (Auth::user()->level == 1) {
                        $btn = '<center>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" href="' . route('spj.view', Crypt::encryptString($row->id)) . '">Review</a>
                            <a class="dropdown-item delete" href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete">Delete</a>
                               </div>
                               </div>
                           </center>';
                    } else {
                        $btn = '<center>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" href="' . route('spj.show', Crypt::encryptString($row->id)) . '">Review</a>
                           </div>
                           </div>
                       </center>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        if (Auth::user()->level == 1) {
            return view('admin.spj.ditolak', compact('menu'));
        } else {
            return view('admin.spj.ditolakusr', compact('menu'));
        }
    }
    public function edit($id)
    {
        $spj = SPJ::find(Crypt::decryptString($id));
        $menu = 'Pengajuan SPJ';
        $setting = Setting::first();
        $kegiatan = Kegiatan::where('bagian_id', Auth::user()->bagian_id)->get();
        return view('admin.spj.edit', compact('spj', 'menu', 'kegiatan', 'setting'));
    }
    public function update(Request $request, $id)
    {
        $spj = SPJ::find(Crypt::decryptString($id));
        //Translate Bahasa Indonesia
        $message = array(
            'kegiatan_id.required' => 'Kegiatan harus dipilih.',
            'subkegiatan_id.required' => 'Sub Kegiatan harus dipilih.',
            'rekening_id.required' => 'Rekening harus dipilih.',
            'uraian.required' => 'Uraian harus diisi.',
            'uraian.max' => 'Uraian maksimal 500 karakter.',
            'kwitansi.required' => 'Kwitansi harus diisi.',
            'nama_penerima.required' => 'Nama Penerima harus diisi.',
            'alamat_penerima.required' => 'Alamat harus diisi.',
            'alamat_penerima.max' => 'Alamat maksimal 500 karakter.',
            'jenis_spm.required' => 'Jenis SPM harus dipilih.',
            'file.mimes' => 'File harus .pdf',
            'file.max' => 'File maksimal 5MB.',
        );
        $validator = Validator::make($request->all(), [
            'kegiatan_id' => 'required',
            'subkegiatan_id' => 'required',
            'rekening_id' => 'required',
            'uraian' => 'required|max:500',
            'kwitansi' => 'required',
            'nama_penerima' => 'required',
            'alamat_penerima' => 'required|max:500',
            'jenis_spm' => 'required',
            'file' => 'mimes:pdf,application/pdf|max:5120',
        ], $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->tanggal == '') {
            $tanggal = Carbon::now()->format('Y-m-d');
        } else {
            $tanggal = $request->tanggal;
        }
        $total =  preg_replace('/[^0-9]/', '', $request->kwitansi);
        $rek = Rekening::where('id', $request->rekening_id)->first();
        if ($total > $rek->sisa_rekening) {
            return redirect()->route('spj.index')->with(['toast_error' => 'Maaf, anggaran tidak mencukupi!' . "\n" . 'Sisa anggaran : Rp.' . $rek->sisa_rekening]);
        }
        if ($request->hasFile('file')) {
            $berkas = time() . '.' . $request->file->extension();
            $request->file->storeAs('public/file', $berkas);
            Storage::delete('public/file/' . $spj->file);
            $spj->update([
                'tanggal' => $tanggal,
                'bagian_id' => Auth::user()->bagian_id,
                'kegiatan_id' => $request->kegiatan_id,
                'subkegiatan_id' => $request->subkegiatan_id,
                'rekening_id' => $request->rekening_id,
                'uraian' => $request->uraian,
                'kwitansi' => $total,
                'nama_penerima' => $request->nama_penerima,
                'alamat_penerima' => $request->alamat_penerima,
                'jenis_spm' => $request->jenis_spm,
                'file' => $berkas,
                'status' => 1,
            ]);
        } else {
            $spj->update([
                'tanggal' => $tanggal,
                'bagian_id' => Auth::user()->bagian_id,
                'kegiatan_id' => $request->kegiatan_id,
                'subkegiatan_id' => $request->subkegiatan_id,
                'rekening_id' => $request->rekening_id,
                'uraian' => $request->uraian,
                'kwitansi' => $total,
                'nama_penerima' => $request->nama_penerima,
                'alamat_penerima' => $request->alamat_penerima,
                'jenis_spm' => $request->jenis_spm,
                'status' => 1,
            ]);
        }
        return redirect()->route('spj.index')->with('toast_success', 'SPJ Berhasil diedit');
    }

    public function kembalikan(Request $request, SPJ $spj)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'alasan.required' => 'Mohon isi alasan.',
        );
        $validator = Validator::make($request->all(), [
            'alasan' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $spj->update([
            'status' => '5',
            'alasan' => $request->alasan
        ]);
        return response()->json(['success' => 'SPJ Berhasil dikembalikan']);
    }

    public function tolak(Request $request, SPJ $spj)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'alasan.required' => 'Mohon isi alasan.',
        );
        $validator = Validator::make($request->all(), [
            'alasan' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $spj->update([
            'status' => '4',
            'alasan' => $request->alasan
        ]);
        return response()->json(['success' => 'SPJ Berhasil ditolak']);
    }
    public function export()
    {
        // Fetch Data SPJ
        $data = SPJ::where('status', '=', 3)->get();
        // Design Table
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle('SPJ Exported');
        $sheet->setCellValue('A2', 'NO');
        $sheet->setCellValue('B2', 'NO. BKU');
        $sheet->setCellValue('C2', 'JENIS KEGIATAN');
        $sheet->setCellValue('D2', 'URAIAN KEGIATAN');
        $sheet->setCellValue('E2', 'KODE SUB KEGIATAN');
        $sheet->setCellValue('F2', 'KODE REKENING');
        $sheet->setCellValue('G2', 'NAMA SUB KEGIATAN');
        $sheet->setCellValue('H2', 'NAMA REKENING');
        $sheet->setCellValue('I2', 'NILAI KWITANSI');
        $sheet->setCellValue('J2', 'PENERIMA PEMBAYARAN');
        $sheet->setCellValue('J3', 'NAMA REKANAN');
        $sheet->setCellValue('K3', 'ALAMAT');
        $no =  1;
        $row = 4;
        foreach ($data as $r) :
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, '');
            $sheet->setCellValue('C' . $row, '');
            $sheet->setCellValue('D' . $row, $r->uraian);
            $sheet->setCellValue('E' . $row, $r->subkegiatan->kode_sub);
            $sheet->setCellValue('F' . $row, $r->rekening->kode_rekening);
            $sheet->setCellValue('G' . $row, $r->subkegiatan->nama_sub);
            $sheet->setCellValue('H' . $row, $r->rekening->nama_rekening);
            $sheet->setCellValue('I' . $row, $r->kwitansi);
            $sheet->setCellValue('J' . $row, $r->nama_penerima);
            $sheet->setCellValue('K' . $row, $r->alamat_penerima);
            //Style
            $styleBorder = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];
            $styleColumnCenter = [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ];
            $sheet->getStyle('A2:K' . $row)->applyFromArray($styleBorder);
            $sheet->getStyle('A2:A' . $row)->applyFromArray($styleColumnCenter);
            $sheet->getStyle('A2:K' . $row)->applyFromArray($styleColumnCenter);
            $no++;
            $row++;
        endforeach;
        $sheet->mergeCells('A1:K1');
        $sheet->mergeCells('A2:A3');
        $sheet->mergeCells('B2:B3');
        $sheet->mergeCells('C2:C3');
        $sheet->mergeCells('D2:D3');
        $sheet->mergeCells('E2:E3');
        $sheet->mergeCells('F2:F3');
        $sheet->mergeCells('G2:G3');
        $sheet->mergeCells('H2:H3');
        $sheet->mergeCells('I2:I3');
        $sheet->mergeCells('J2:K2');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setWidth(200, 'pt');
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setWidth(150, 'pt');
        $sheet->getColumnDimension('K')->setWidth(200, 'pt');
        // Export
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . time() . '_SPJ Exported.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }
}
