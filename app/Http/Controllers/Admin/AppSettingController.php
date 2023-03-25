<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;


class AppSettingController extends Controller
{

    public function index()
    {
        $menu = 'Setting Aplikasi';
        $appsetting = AppSetting::first();

        return view('admin.app-setting.data', compact('menu', 'appsetting'));
    }

    public function create(Request $request)

    {
        $menu = 'Isi Data';
        return view('admin.app-setting.create', compact('menu'));
    }

    public function store(Request $request, AppSetting $appsetting)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'nama_aplikasi.required' => 'Nama Aplikasi harus diisi.',
            'keterangan_aplikasi.required' => 'Keterangan Aplikasi harus diisi.',
            'visi.required' => 'Visi harus diisi.',
            'misi.required' => 'Misi harus diisi.',
            'gambar.required' => 'Gambar harus diupload.',
            'gambar.images' => 'File harus image.',
            'gambar.mimes' => 'Foto harus jpeg,png,jpg.',
            'gambar.max' => 'File maksimal 1MB.',
        );
        //validate form
        $validator = Validator::make($request->all(), [
            'nama_aplikasi' => 'required|string|max:255',
            'keterangan_aplikasi' => 'required|max:255',
            'visi' => 'required',
            'misi' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:1024',
        ], $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        //check if image & logo is uploaded
        if ($request->hasFile('gambar')) {
            // upload new image and new logo
            $img = $request->file('gambar');
            $img->storeAs('public/logo', $img->hashName());
            // delete old image and old logo
            Storage::delete('public/logo/' . $appsetting->gambar);
            // update sambutan with img & logo
            $appsetting->create([
                'nama_aplikasi' => $request->nama_aplikasi,
                'keterangan_aplikasi' => $request->keterangan_aplikasi,
                'visi' => $request->visi,
                'misi' => $request->misi,
                'gambar' => $img->hashName(),
            ]);
        }

        //redirect to index
        return redirect()->route('appsetting.index')->with(['toast_success' => 'Data Berhasil Disimpan!']);
    }

    public function edit($id)
    {
        $menu = 'Edit Setting Aplikasi';
        $appsetting = AppSetting::find(Crypt::decryptString($id));
        return view('admin.app-setting.edit', compact('menu', 'appsetting'));
    }

    public function update(Request $request, $id)
    {
        $appsetting = AppSetting::find(Crypt::decryptString($id));
        //Translate Bahasa Indonesia
        $message = array(
            'nama_aplikasi.required' => 'Nama Aplikasi harus diisi.',
            'keterangan_aplikasi.required' => 'Keterangan Aplikasi harus diisi.',
            'visi.required' => 'Visi harus diisi.',
            'misi.required' => 'Misi harus diisi.',
            'gambar.required' => 'Gambar harus diupload.',
            'gambar.images' => 'File harus image.',
            'gambar.mimes' => 'Foto harus jpeg,png,jpg.',
            'gambar.max' => 'File maksimal 1MB.',
        );
        //validate form
        $this->validate($request, [
            'nama_aplikasi' => 'required|string|max:255',
            'keterangan_aplikasi' => 'required|max:255',
            'visi' => 'required',
            'misi' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg|max:1024',
        ], $message);
        //check if image & logo is uploaded
        if ($request->hasFile('gambar')) {
            // upload new image and new logo
            $img = $request->file('gambar');
            $img->storeAs('public/logo', $img->hashName());
            // delete old image and old logo
            Storage::delete('public/logo/' . $appsetting->gambar);
            // update sambutan with img & logo
            $appsetting->update([
                'nama_aplikasi' => $request->nama_aplikasi,
                'keterangan_aplikasi' => $request->keterangan_aplikasi,
                'visi' => $request->visi,
                'misi' => $request->misi,
                'gambar' => $img->hashName(),
            ]);
        } else {
            //update sambutan without image img & logo
            $appsetting->update([
                'nama_aplikasi' => $request->nama_aplikasi,
                'keterangan_aplikasi' => $request->keterangan_aplikasi,
                'visi' => $request->visi,
                'misi' => $request->misi,
            ]);
        }
        //redirect to index
        return redirect()->route('appsetting.index')->with(['toast_success' => 'Data Berhasil Diupdate!']);
    }
}
