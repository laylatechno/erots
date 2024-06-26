<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function index()
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

        $infologin = $request->only('email', 'password');

        if (Auth::attempt($infologin)) {
            $request->session()->regenerate();
            return redirect('/dashboard');
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
