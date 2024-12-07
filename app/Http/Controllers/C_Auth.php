<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna;

class C_Auth extends Controller
{
    public function showLoginForm()
    {
        return view('welcome'); 
    }

    public function login(Request $request)
    {
        // Validasi input untuk memastikan username dan password diisi
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Username harus diisi.',
            'password.required' => 'Password harus diisi.',
        ]);

        // Jika user ada, lakukan pengecekan password
        if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            // Jika password salah
            return back()->with('error', 'Incorrect username or password')->withInput();
        }
        $data = Auth::user();
        session()->put('user', $data);
        // Jika username dan password benar, redirect ke halaman yang diinginkan
        return redirect()->intended('dashboard')->with('success', 'Login berhasil!');
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
