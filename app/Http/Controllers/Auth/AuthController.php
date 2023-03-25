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
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email tidak boleh kosong.',
                'email.email' => 'Penulisan email tidak benar.',
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
        return back()->withErrors(['email' => 'Maaf email dan password salah!'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
