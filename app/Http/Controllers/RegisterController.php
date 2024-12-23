<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|min:3|unique:penggunas', // Memastikan username unik
            'email' => 'required|email|unique:penggunas', // Memastikan email unik
            'nohp' => 'nullable|string', // No HP opsional
            'password' => 'required|min:4|confirmed', // Memastikan password terkonfirmasi
            // Tambahkan validasi untuk captcha jika perlu
            // 'captcha' => 'required|captcha'
        ]);

        // Buat pengguna baru dengan role "pelanggan"
        Pengguna::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'nohp' => $validated['nohp'], // No HP jika ada
            'password' => Hash::make($validated['password']), // Hash password
            'role' => 'pelanggan', // Set role sebagai pelanggan
        ]);

        // Redirect ke halaman login dengan pesan sukses
        return redirect('/login')->with('pesan', 'Berhasil Registrasi! Silakan login.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
