<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menu = 'Schedule';
        $setting = Setting::first();
        return view('admin.setting.data', compact('setting', 'menu'));
    }
    public function store(Request $request)
    {
        $message = array(
            'judul.required' => 'Judul harus diisi.',
            'tglm.required' => 'Tanggal mulai harus dipilih.',
            'tgls.required' => 'Tanggal selesai harus dipilih.',
            'jamm.required' => 'Jam mulai harus diisi',
            'jams.required' => 'Jam selesai harus diisi',
        );
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'tglm' => 'required',
            'jamm' => 'required',
            'tgls' => 'required',
            'jams' => 'required',
        ], $message);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }
        if ($request->tglm < date('Y-m-d')) {
            return redirect()->route('setting.index')->with(['toast_error' => 'Tanggal mulai harus diatas Tanggal hari ini!'])->withInput();
        } elseif ($request->tgls < date('Y-m-d')) {
            return redirect()->route('setting.index')->with(['toast_error' => 'Tanggal selesai harus diatas Tanggal hari ini!'])->withInput();
        } elseif ($request->jamm > $request->jams) {
            return redirect()->route('setting.index')->with(['toast_error' => 'Jam tidak masuk akal'])->withInput();
        } else {
            Setting::create(
                [
                    'judul' => $request->judul,
                    'tgl_mulai' => $request->tglm,
                    'jam_mulai' => $request->jamm,
                    'tgl_selesai' => $request->tgls,
                    'jam_selesai' => $request->jams,
                ]
            );
            //redirect to index
            return redirect()->route('setting.index')->with(['toast_success' => 'Data Berhasil Disimpan!']);
        }
    }
    public function update(Request $request, Setting $set)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'judul.required' => 'Judul harus diisi.',
        );
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
        ], $message);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }
        if ($request->tglm < date('Y-m-d')) {
            return redirect()->route('setting.index')->with(['toast_error' => 'Tanggal mulai harus diatas Tanggal hari ini!'])->withInput();
        } elseif ($request->tgls < date('Y-m-d')) {
            return redirect()->route('setting.index')->with(['toast_error' => 'Tanggal selesai harus diatas Tanggal hari ini!'])->withInput();
        } elseif ($request->jamm > $request->jams) {
            return redirect()->route('setting.index')->with(['toast_error' => 'Jam tidak masuk akal'])->withInput();
        } else {
            $set->update(
                [
                    'judul' => $request->judul,
                    'tgl_mulai' => $request->tglm,
                    'jam_mulai' => $request->jamm,
                    'tgl_selesai' => $request->tgls,
                    'jam_selesai' => $request->jams,
                ]
            );
            //redirect to index
            return redirect()->route('setting.index')->with(['toast_success' => 'Data Berhasil Diupdate!']);
        }
    }
}
