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

        if (Auth::guard('admincbd')->attempt($kredensial)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        } elseif (Auth::guard('user')->attempt($kredensial)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
        return back()->withErrors(['email' => 'Maaf email dan password salah!'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('admincbd')->check()) {

            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Auth::guard('admincbd')->logout();
        } elseif (Auth::guard('user')->check()) {

            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Auth::guard('user')->logout();
        }
        return redirect('/login');
    }
}
