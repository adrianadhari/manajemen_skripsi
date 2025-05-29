<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role === 'Mahasiswa') {
                return redirect('/mahasiswa');
            } elseif ($role === 'Dosen') {
                return redirect('/dosen');
            } elseif ($role === 'Program Studi') {
                return redirect('/program-studi');
            } elseif ($role === 'Admin') {
                return redirect('/admin');
            }
        }
        return view('login');

    }

    public function login(Request $request)
    {
        $request->validate([
            'no_induk' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('no_induk', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            if ($role === 'Mahasiswa') {
                return redirect('/mahasiswa');
            } elseif ($role === 'Dosen') {
                return redirect('/dosen');
            } elseif ($role === 'Program Studi') {
                return redirect('/program-studi');
            } elseif ($role === 'Admin') {
                return redirect('/admin');
            }
        }

        return back()->withErrors([
            'password' => 'No Induk atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
