<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UsersCabdis;
use App\Models\Sekolah;
use App\Models\Timeline;
use Yajra\Datatables\Datatables;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menu = 'User Sekolah';
        $sekolah = Sekolah::latest()->get();
        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('sekolah', function ($data) {
                    return $data->sekolah->nama_sekolah;
                })
                ->addColumn('foto', function ($data) {
                    if ($data->profile->foto != null) {
                        $foto = '<center><img src="' . url("storage/foto-user/" . $data->profile->foto) . '" width="30px" class="img rounded"><center>';
                    } else {
                        $foto = '<center><img src="' . url("storage/foto-user/blank.png") . '" width="30px" class="img rounded"><center>';
                    }
                    return $foto;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editUser"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteUser"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['foto', 'action'])
                ->make(true);
        }
        return view('admin.user.data', compact('menu', 'sekolah'));
    }

    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'sekolah_id.required' => 'Sekolah harus dipilih.',
            'sekolah_id.unique' => 'Sekolah sudah terdaftar.',
            'nik.required' => 'NIK harus diisi.',
            'nik.numeric' => 'NIK harus angka.',
            'nik.max' => 'NIK maksimal 16 digit.',
            'nik.min' => 'NIK minimal 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'nama.required' => 'Nama harus diisi.',
            'nohp.required' => 'Nomor Handphone harus diisi.',
            'nohp.numeric' => 'Nomor Handphone harus angka.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Penulisan email tidak benar.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'repassword.required' => 'Harap konfirmasi password.',
            'repassword.same' => 'Password harus sama.',
            'repassword.min' => 'Password minimal 8 karakter.',
        );
        //Check If Field Unique
        if (!$request->user_id) {
            //rule tambah data tanpa user_id
            $ruleSekolah = 'required|unique:users,sekolah_id';
            $ruleNik = 'required|max:16|min:16|unique:users,nik';
            $ruleEmail = 'required|email|unique:users,email';
        } else {
            //rule edit jika tidak ada user_id
            $lastSekolah = User::where('id', $request->user_id)->first();
            if ($lastSekolah->sekolah_id == $request->sekolah_id) {
                $ruleSekolah = 'required';
            } else {
                $ruleSekolah = 'required|unique:users,sekolah_id';
            }
            $lastNik = User::where('id', $request->user_id)->first();
            if ($lastNik->nik == $request->nik) {
                $ruleNik = 'required|max:16|min:16';
            } else {
                $ruleNik = 'required|max:16|min:16|unique:users,nik';
            }
            $lastEmail = User::where('id', $request->user_id)->first();
            if ($lastEmail->email == $request->email) {
                $ruleEmail = 'required|email';
            } else {
                $ruleEmail = 'required|email|unique:users,email';
            }
        }
        $validator = Validator::make($request->all(), [
            'sekolah_id' => $ruleSekolah,
            'nik' => $ruleNik,
            'nama' => 'required|max:255',
            'nohp' => 'required|numeric',
            'email' => $ruleEmail,
            'password' => 'required|min:8',
            'repassword' => 'required|same:password|min:8',
        ], $message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        User::updateOrCreate(
            [
                'id' => $request->user_id
            ],
            [
                'sekolah_id' => $request->sekolah_id,
                'nik' => $request->nik,
                'nama' => $request->nama,
                'nohp' => $request->nohp,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 2,
                'status' => 1,
            ]
        );
        $usersid  = User::orderBy('id', 'DESC')->first();
        ProfileUsers::create(
            [
                'user_id' => $usersid->id,
                'nama' => $request->nama,
                'email' => $request->email,
                'nik' => $request->nik,
                'nohp' => $request->nohp,
            ]
        );
        if (!$request->user_id) {
            Timeline::create(
                [
                    'user_id' => $usersid->id,
                    'status' => 'Bergabung',
                    'pesan' => 'Membuat Akun Baru',
                ]
            );
        } else {
            Timeline::create(
                [
                    'user_id' => $request->user_id,
                    'status' => 'Update Akun',
                    'pesan' => 'Memperbaharui Akun',
                ]
            );
        }
        return response()->json(['success' => 'User saved successfully.']);
    }
    public function edit($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function destroy(User $user)
    {
        Storage::delete('public/foto-user/' . $user->profile->foto);
        $user->delete();
        return response()->json(['success' => 'User deleted successfully.']);
    }

    public function profil()
    {
        $menu = 'Profil Saya';
        $id = Auth::user()->id;
        if (Auth::user()->role == 1) {
            $user = UsersCabdis::where('id', $id)->first();
        } else {
            $user = User::where('id', $id)->first();
        }
        return view('admin.profil.data', compact('user', 'menu'));
    }
    public function updateprofil(Request $request, User $user)
    {
        $lastEmail = User::where('id', $request->id)->first();
        if ($lastEmail->email == $request->email) {
            $ruleEmail = 'required|email';
        } else {
            $ruleEmail = 'required|email|unique:users,email';
        }
        //validate form
        $this->validate($request, [
            'nama' => 'required|max:255',
            'nohp' => 'required|numeric',
            'email' => $ruleEmail,
        ]);
        $user->update(
            [
                'nama' => $request->nama,
                'nohp' => $request->nohp,
                'email' => $request->email,
            ]
        );
        ProfileUsers::where("id", $request->id)->update([
            'gender' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'alamat' => $request->alamat,
        ]);
        Timeline::create(
            [
                'user_id' => $request->id,
                'status' => 'Update Akun',
                'pesan' => 'Memperbaharui Profil',
            ]
        );
        //redirect to index
        return redirect()->route('profil.index')->with(['status' => 'Profil Berhasil Diupdate!']);
    }
    public function updatepassword(Request $request, User $user)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'npassword.required' => 'Password harus diisi.',
            'npassword.min' => 'Password minimal 8.',
            'nrepassword.required' => 'Harap konfirmasi password.',
            'nrepassword.same' => 'Password harus sama.',
            'nrepassword.min' => 'Password minimal 8.',
        );
        //validate form
        $this->validate($request, [
            'npassword' => 'required|min:8',
            'nrepassword' => 'required|same:npassword|min:8',
        ], $message);
        $user->update(
            [
                'password' => Hash::make($request->npassword),
            ]
        );
        Timeline::create(
            [
                'user_id' => $request->id,
                'status' => 'Update Akun',
                'pesan' => 'Memperbaharui Password Baru',
            ]
        );
        //redirect to index
        return redirect()->route('profil.index')->with(['status' => 'Password Berhasil Diupdate!']);
    }
    public function updatefoto(Request $request, $id)
    {
        $user = ProfileUsers::where("id", $id)->first();
        //Translate Bahasa Indonesia
        $message = array(
            'foto.images' => 'File harus image.',
            'foto.mimes' => 'Foto harus jpeg,png,jpg.',
            'foto,max' => 'File maksimal 1MB.',
        );
        $this->validate($request, [
            'foto' => 'image|mimes:jpeg,png,jpg|max:1024'
        ], $message);
        $img = $request->file('foto');
        $img->storeAs('public/foto-user/', $img->hashName());
        //delete old
        Storage::delete('public/foto-user/' . $user->foto);
        $user->update([
            'foto' => $img->hashName(),
        ]);
        Timeline::create(
            [
                'user_id' => $id,
                'status' => 'Update Akun',
                'pesan' => 'Memperbaharui Foto Profil',
            ]
        );
        //redirect to index
        return redirect()->route('profil.index')->with(['status' => 'Foto Berhasil Diupdate!']);
    }
}
