<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Pegawai;
use App\Models\ProfileSekolah;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileSekolahController extends Controller
{
    public function index()
    {
        $menu = 'Profil Sekolah';
        $guru = Guru::where('sekolah_id', Auth::user()->sekolah_id)->count();
        $pegawai = Pegawai::where('sekolah_id', Auth::user()->sekolah_id)->count();
        $siswa = Siswa::where('sekolah_id', Auth::user()->sekolah_id)->count();
        $profil = ProfileSekolah::where('sekolah_id', Auth::user()->sekolah_id)->first();
        return view('admin.profil-sekolah.data', compact('profil', 'menu', 'guru', 'pegawai', 'siswa'));
    }
    public function create()
    {
        $menu = 'Profil Sekolah';
        return view('admin.profil-sekolah.create', compact('menu'));
    }
    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'nip.max' => 'NIP maksimal 18 angka.',
            'nip.unique' => 'NIP Kepsek sudah terdaftar.',
            'nss.required' => 'NSS harus diisi.',
            'nss.max' => 'NSS maksimal 12 angka.',
            'nss.unique' => 'NSS sudah terdaftar.',
            'nds.required' => 'NDS harus diisi.',
            'nds.max' => 'NDS maksimal 8 angka.',
            'nds.unique' => 'NDS sudah terdaftar.',
            'nosiop.required' => 'Nomor SIOP harus diisi.',
            'akreditas.required' => 'Akreditas harus dipilih.',
            'thnberdiri.required' => 'Tahun Berdiri harus diisi.',
            'thnberdiri.max' => 'Tahun Berdiri maksimal 4 angka.',
            'nosk.required' => 'Nomor SK Pendirian harus diisi.',
            'tglsk.required' => 'Tanggal SK harus diisi.',
            'standar.required' => 'Standar Sekolah Bertaraf harus dipilih.',
            'waktub.required' => 'Waktu Belajar harus dipilih.',
            'kabupaten_id.required' => 'Kabupaten harus dipilih.',
            'kecamatan_id.required' => 'Kecamatan harus dipilih.',
            'desa_id.required' => 'Desa harus dipilih.',
            'kodepos.required' => 'Kode Pos harus diisi.',
            'kodepos.max' => 'Kode Pos maksimal 5 angka.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.max' => 'Alamat melebihi batas maksimal karakter.',
            'telp.required' => 'Nomor Handphone harus diisi.',
            'telp.min' => 'Nomor Handphone minimal 11 angka.',
            'telp.max' => 'Nomor Handphone maksimal 12 angka.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Penulisan email tidak benar.',
            'nama_kepsek.required' => 'Nama Kepsek harus diisi.',
            'fotosekolah.image' => 'Foto harus gambar.',
            'fotosekolah.mimes' => 'Foto harus jpeg,png,jpg.',
            'fotosekolah.max' => 'Foto maksimal 2MB.',
            'fotokepsek.image' => 'Foto harus gambar.',
            'fotokepsek.mimes' => 'Foto harus jpeg,png,jpg.',
            'fotokepsek.max' => 'Foto maksimal 2MB.',
        );
        if ($request->nip == null) {
            $ruleNip = 'max:18';
        } else {
            $ruleNip = 'max:18|unique:profile_sekolah,nip';
        }
        $validator = Validator::make($request->all(), [
            'nss' => 'required|max:12|unique:profile_sekolah,nss',
            'nds' => 'required|max:8|unique:profile_sekolah,nds',
            'nosiop' => 'required',
            'akreditas' => 'required',
            'thnberdiri' => 'required|max:4',
            'nosk' => 'required',
            'tglsk' => 'required',
            'standar' => 'required',
            'waktub' => 'required',
            'kabupaten_id' => 'required',
            'kecamatan_id' => 'required',
            'desa_id' => 'required',
            'kodepos' => 'required|max:5',
            'alamat' => 'required|max:255',
            'telp' => 'required|min:11|max:12',
            'email' => 'required|email',
            'nip' => $ruleNip,
            'nama_kepsek' => 'required',
            'foto_kepsek' => 'image|mimes:jpeg,png,jpg|max:2024',
            'foto_sekolah' => 'image|mimes:jpeg,png,jpg|max:2024'
        ], $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $imgSekolah = $request->file('fotosekolah');
        $imgKepsek = $request->file('fotokepsek');
        if ($imgSekolah != null) {
            $fileNameSekolah = $imgSekolah->hashName();
            $imgSekolah->storeAs('public/foto-sekolah/', $fileNameSekolah);
        } else {
            $fileNameSekolah = null;
        }
        if ($imgKepsek != null) {
            $fileNameKepsek = $imgKepsek->hashName();
            $imgKepsek->storeAs('public/foto-kepsek/', $fileNameKepsek);
        } else {
            $fileNameKepsek = null;
        }
        ProfileSekolah::create(
            [
                'sekolah_id' => Auth::user()->sekolah_id,
                'nss' =>  $request->nss,
                'nds' => $request->nds,
                'nosiop' => $request->nosiop,
                'akreditas' => $request->akreditas,
                'thnberdiri' => $request->thnberdiri,
                'nosk' => $request->nosk,
                'tglsk' => $request->tglsk,
                'standar' => $request->standar,
                'waktub' => $request->waktub,
                'kabupaten_id' => $request->kabupaten_id,
                'kecamatan_id' => $request->kecamatan_id,
                'desa_id' => $request->desa_id,
                'kodepos' => $request->kodepos,
                'alamat' => $request->alamat,
                'telp' => $request->telp,
                'email' => $request->email,
                'website' => $request->website,
                'nip' => $request->nip,
                'kepsek' => $request->nama_kepsek,
                'foto_kepsek' =>  $fileNameKepsek,
                'foto_sekolah' => $fileNameSekolah
            ]
        );
        return redirect()->route('profile-sekolah.index')->with('toast_success', 'Profil saved successfully.');
    }
    public function edit($id)
    {
        $menu = 'Edit Profil Sekolah';
        $profil = ProfileSekolah::where('sekolah_id', Auth::user()->sekolah_id)->find(Crypt::decryptString($id));
        return view('admin.profil-sekolah.edit', compact('menu', 'profil'));
    }
    public function update(Request $request, $id)
    {
        $profil = ProfileSekolah::find(Crypt::decryptString($id));
        //Translate Bahasa Indonesia
        $message = array(
            'nip.max' => 'NIP maksimal 18 angka.',
            'nip.unique' => 'NIP Kepsek sudah terdaftar.',
            'nss.required' => 'NSS harus diisi.',
            'nss.max' => 'NSS maksimal 12 angka.',
            'nss.unique' => 'NSS sudah terdaftar.',
            'nds.required' => 'NDS harus diisi.',
            'nds.max' => 'NDS maksimal 8 angka.',
            'nds.unique' => 'NDS sudah terdaftar.',
            'nosiop.required' => 'Nomor SIOP harus diisi.',
            'akreditas.required' => 'Akreditas harus dipilih.',
            'thnberdiri.required' => 'Tahun Berdiri harus diisi.',
            'thnberdiri.max' => 'Tahun Berdiri maksimal 4 angka.',
            'nosk.required' => 'Nomor SK Pendirian harus diisi.',
            'tglsk.required' => 'Tanggal SK harus diisi.',
            'standar.required' => 'Standar Sekolah Bertaraf harus dipilih.',
            'waktub.required' => 'Waktu Belajar harus dipilih.',
            'kabupaten_id.required' => 'Kabupaten harus dipilih.',
            'kecamatan_id.required' => 'Kecamatan harus dipilih.',
            'desa_id.required' => 'Desa harus dipilih.',
            'kodepos.required' => 'Kode Pos harus diisi.',
            'kodepos.max' => 'Kode Pos maksimal 5 angka.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.max' => 'Alamat melebihi batas maksimal karakter.',
            'telp.required' => 'Nomor Handphone harus diisi.',
            'telp.min' => 'Nomor Handphone minimal 11 angka.',
            'telp.max' => 'Nomor Handphone maksimal 12 angka.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Penulisan email tidak benar.',
            'nama_kepsek.required' => 'Nama Kepsek harus diisi.',
            'fotosekolah.image' => 'Foto harus gambar.',
            'fotosekolah.mimes' => 'Foto harus jpeg,png,jpg.',
            'fotosekolah.max' => 'Foto maksimal 2MB.',
            'fotokepsek.image' => 'Foto harus gambar.',
            'fotokepsek.mimes' => 'Foto harus jpeg,png,jpg.',
            'fotokepsek.max' => 'Foto maksimal 2MB.',
        );
        if ($profil->nss == $request->nss) {
            $ruleNss = 'required|max:12';
        } else {
            $ruleNss = 'required|max:12|unique:profile_sekolah,nss';
        }
        if ($profil->nds == $request->nds) {
            $ruleNds = 'required|max:12';
        } else {
            $ruleNds = 'required|max:12|unique:profile_sekolah,nds';
        }
        if ($profil->nip == $request->nip) {
            $ruleNip = 'max:18';
        } else {
            $ruleNip = 'max:18|unique:profile_sekolah,nip';
        }
        $validator = Validator::make($request->all(), [
            'nss' => $ruleNss,
            'nds' => $ruleNds,
            'nosiop' => 'required',
            'akreditas' => 'required',
            'thnberdiri' => 'required|max:4',
            'nosk' => 'required',
            'tglsk' => 'required',
            'standar' => 'required',
            'waktub' => 'required',
            'kabupaten_id' => 'required',
            'kecamatan_id' => 'required',
            'desa_id' => 'required',
            'kodepos' => 'required|max:5',
            'alamat' => 'required|max:255',
            'telp' => 'required|min:11|max:12',
            'email' => 'required|email',
            'nip' => $ruleNip,
            'nama_kepsek' => 'required',
            'foto_kepsek' => 'image|mimes:jpeg,png,jpg|max:2024',
            'foto_sekolah' => 'image|mimes:jpeg,png,jpg|max:2024'
        ], $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $imgSekolah = $request->file('fotosekolah');
        $imgKepsek = $request->file('fotokepsek');
        if ($imgSekolah != null) {
            $fileNameSekolah = $imgSekolah->hashName();
            $imgSekolah->storeAs('public/foto-sekolah/',  $fileNameSekolah);
            //delete old
            Storage::delete('public/foto-sekolah/' . $profil->foto_sekolah);
        } else {
            $fileNameSekolah = $profil->foto_sekolah;
        }
        if ($imgKepsek != null) {
            $fileNameKepsek = $imgKepsek->hashName();
            $imgKepsek->storeAs('public/foto-kepsek/',  $fileNameKepsek);
            //delete old
            Storage::delete('public/foto-kepsek/' . $profil->foto_kepsek);
        } else {
            $fileNameKepsek = $profil->foto_kepsek;
        }
        $profil->update(
            [
                'nss' =>  $request->nss,
                'nds' => $request->nds,
                'nosiop' => $request->nosiop,
                'akreditas' => $request->akreditas,
                'thnberdiri' => $request->thnberdiri,
                'nosk' => $request->nosk,
                'tglsk' => $request->tglsk,
                'standar' => $request->standar,
                'waktub' => $request->waktub,
                'kabupaten_id' => $request->kabupaten_id,
                'kecamatan_id' => $request->kecamatan_id,
                'desa_id' => $request->desa_id,
                'kodepos' => $request->kodepos,
                'alamat' => $request->alamat,
                'telp' => $request->telp,
                'email' => $request->email,
                'website' => $request->website,
                'nip' => $request->nip,
                'kepsek' => $request->nama_kepsek,
                'foto_kepsek' =>  $fileNameKepsek,
                'foto_sekolah' => $fileNameSekolah
            ]
        );
        return redirect()->route('profile-sekolah.index')->with('toast_success', 'Profil updated successfully.');
    }
}
