<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PenggunaController extends Controller
{
    public function index()
    {
        $penggunas = Pengguna::where('role', 'pelanggan')->paginate(10);
        return view('admin.admin-pelanggan.index', compact('penggunas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengguna $pengguna)
    {
        //
    }

    public function edit()
    {
        $pengguna = Auth::user(); // Mengambil data pengguna yang sedang login
        if (!$pengguna) {
            return redirect()->route('login')->withErrors('Please log in to access this page.');
        }
        return view('pelanggan.editprofile', compact('pengguna'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:penggunas,email,' . Auth::id(),
            'nohp' => 'required|string|max:15',
        ]);

        try {
            // Update user information directly in the database
            Pengguna::where('id', Auth::id())->update($validated);

            // Update session variables with the new data
            $request->session()->put('username', $validated['username']);
            $request->session()->put('email', $validated['email']);
            $request->session()->put('nohp', $validated['nohp']);

        } catch (\Exception $e) {
            Log::error('Error saat menyimpan data pengguna: ' . $e->getMessage());
            return redirect()->back()->withErrors('Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }

        return redirect('/detailpelanggan')->with('success', 'Profil berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        Pengguna::destroy($id);
        return redirect('admin-pelanggan')->with('pesan', 'Data berhasil dihapus');
    }
}
