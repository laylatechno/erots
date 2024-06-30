<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        return view('back.auth');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email Wajib diisi',
            'password.required' => 'Password Wajib diisi'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->status == 'Aktif') {
                $request->session()->regenerate();
                return redirect('/dashboard');
            } else {
                Auth::logout();
                return back()->withErrors([
                    'loginError' => 'Akun Anda belum aktif. Silahkan hubungi call center tertera.'
                ]);
            }
        }

        return back()->withErrors([
            'loginError' => 'Email atau password yang dimasukkan tidak sesuai !!!'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/auth');
    }
}
