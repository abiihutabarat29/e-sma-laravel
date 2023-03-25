<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        //validate form
        $kredensial =  $request->validate(
            [
                'username' => 'required|min:8',
                'password' => 'required',
            ],
            [
                'username.required' => 'Username tidak boleh kosong.',
                'username.min' => 'Username minimal 8 karakter.',
                'password.required' => 'Password tidak boleh kosong.',
            ]
        );

        if (Auth::attempt($kredensial)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user) {
                return redirect()->intended('dashboard');
            }
            return redirect()->intended('login');
        }
        return back()->withErrors(['username' => 'Maaf username dan password salah!'])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
