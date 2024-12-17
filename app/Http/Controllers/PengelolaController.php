<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PengelolaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil keyword pencarian dari request
        $search = $request->input('search');

        // Query untuk mencari data pengelola
        $pengelolas = Pengguna::where('role', 'pengelola')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('username', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('nohp', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        // Kirim hasil query dan keyword pencarian ke view
        return view('admin.admin-pengelola.index', compact('pengelolas', 'search'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.admin-pengelola.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|min:3', // Validasi username unik
            'email' => 'required|email|unique:penggunas', // Validasi email unik
            'nohp' => 'nullable|string', // No HP opsional
            'password' => 'required|min:4|confirmed', // Validasi konfirmasi password
        ]);

        // Buat pengguna baru dengan role "pengelola"
        Pengguna::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'nohp' => $validated['nohp'], // No HP jika ada
            'password' => Hash::make($validated['password']), // Hash password
            'role' => 'pengelola', // Set role sebagai pengelola
        ]);

        // Redirect ke halaman daftar pengelola dengan pesan sukses
        return redirect('/admin-pengelola')->with('pesan', 'Pengelola berhasil ditambahkan!');
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
    // Temukan pengelola berdasarkan id
    $pengelola = Pengguna::findOrFail($id);

    // Kirim data pengelola ke view
    return view('admin.admin-pengelola.edit', compact('pengelola'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi data yang dikirim
        $validated = $request->validate([
            'username' => 'required|min:3', // Validasi username
            'nohp' => 'nullable|string|max:15', // Validasi No HP
        ]);

        try {
            // Temukan pengelola yang akan diupdate
            $pengelola = Pengguna::findOrFail($id);

            // Update data pengguna
            $pengelola->username = $validated['username'];
            $pengelola->nohp = $validated['nohp'];

            // Simpan perubahan
            $pengelola->save();

            // Redirect dengan pesan sukses
            return redirect('/admin-pengelola')->with('pesan', 'Pengelola berhasil diperbarui!');
        } catch (\Exception $e) {
            // Tangani error jika ada
            Log::error('Error saat memperbarui data pengelola: ' . $e->getMessage());
            return redirect()->back()->withErrors('Terjadi kesalahan saat memperbarui data. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Pengguna::destroy($id);
        return redirect('admin-pengelola')->with('pesan', 'Data berhasil dihapus');
    }
}
