<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Simpan informasi pengguna ke session
            $user = Auth::user();
            $request->session()->put('username', $user->username);
            $request->session()->put('email', $user->email);
            $request->session()->put('nohp', $user->nohp);

            // Ambil data keranjang dari database
            $keranjangs = Keranjang::with('produk')->where('pengguna_id', Auth::id())->get();
            session()->put('keranjangs', $keranjangs); // Simpan ke session

            // Periksa peran pengguna dan arahkan sesuai
            if ($user->role === 'pelanggan') {
                return redirect()->intended('/detailpelanggan');
            } elseif ($user->role === 'admin') {
                return redirect()->intended('/dashboard');
            } elseif ($user->role === 'pengelola') {
                return redirect()->intended('/pesanan');
            } elseif ($user->role === 'pengantar') {
                return redirect()->intended('/pesanan-masuk');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Hapus informasi dari session
        $request->session()->forget(['username', 'email', 'nohp']); // Hapus informasi pengguna dari session

        return redirect('/');
    }
}
