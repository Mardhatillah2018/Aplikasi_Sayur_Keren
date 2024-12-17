<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PengantarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //ambil keyword pencarian
        $search = $request->input('search');
        //query mencari data pengantar
        $pengantars = Pengguna::where('role', 'pengantar')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('username', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('nohp', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.admin-pengantar.index', compact('pengantars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.admin-pengantar.create');
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

        // Buat pengguna baru dengan role "Pengantar"
        Pengguna::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'nohp' => $validated['nohp'], // No HP jika ada
            'password' => Hash::make($validated['password']), // Hash password
            'role' => 'pengantar', // Set role sebagai pengantar
        ]);

        // Redirect ke halaman daftar pengantar dengan pesan sukses
        return redirect('/admin-pengantar')->with('pesan', 'Pengantar berhasil ditambahkan!');
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
        // Temukan pengantar berdasarkan id
        $pengantar = Pengguna::findOrFail($id);

        // Kirim data pengantar ke view
        return view('admin.admin-pengantar.edit', compact('pengantar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi data yang dikirim
        $validated = $request->validate([
            'username' => 'required|min:3', // Validasi username
            'nohp' => 'nullable|string|max:15', // Validasi No HP
        ]);

        try {
            // Temukan pengantar yang akan diupdate
            $pengantar = Pengguna::findOrFail($id);

            // Update data pengguna
            $pengantar->username = $validated['username'];
            $pengantar->nohp = $validated['nohp'];

            // Simpan perubahan
            $pengantar->save();

            // Redirect dengan pesan sukses
            return redirect('/admin-pengantar')->with('pesan', 'Pengantar berhasil diperbarui!');
        } catch (\Exception $e) {
            // Tangani error jika ada
            Log::error('Error saat memperbarui data pengantar: ' . $e->getMessage());
            return redirect()->back()->withErrors('Terjadi kesalahan saat memperbarui data. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Pengguna::destroy($id);
        return redirect('admin-pengantar')->with('pesan', 'Data berhasil dihapus');
    }
}
