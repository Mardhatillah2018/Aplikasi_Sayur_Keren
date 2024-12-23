<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function getKategori()
    {
        return Kategori::select('nama_kategori', 'gambar_kategori')->get(); // Ambil nama dan gambar kategori
    }

    public function index(Request $request)
    {
        // Ambil keyword pencarian dari request
        $search = $request->input('search');  // Ganti dari 'keyword' ke 'search'

        // Cek apakah ada keyword pencarian
        if ($search) {
            // Jika ada, cari kategori berdasarkan nama kategori
            $kategoris = \App\Models\Kategori::where('nama_kategori', 'like', '%' . $search . '%')
                                            ->latest()
                                            ->paginate(10);
        } else {
            // Jika tidak ada, ambil semua kategori terbaru dengan pagination
            $kategoris = \App\Models\Kategori::latest()->paginate(10);
        }

        return view('admin.kategori.index', ['kategoris' => $kategoris, 'search' => $search]);  // Ganti 'keyword' dengan 'search'
    }

    public function create()
    {
        return view('admin.kategori.create',['kategoris' =>Kategori::all()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|min:3',
            'gambar_kategori' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
         ]);

         //dd($validated);
         if ($request->hasFile('gambar_kategori')) {
            $imageName = time().'.'.$request->gambar_kategori->extension();
            $request->gambar_kategori->move(public_path('images/kategori'), $imageName);
            $validated['gambar_kategori'] = $imageName;
        }

         Kategori::create($validated);
         return redirect('/admin-kategori')->with('pesan','Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        //
    }

    public function edit(string $id)
    {
        $kategori = Kategori::find($id);
        // Memastikan data produk yang benar diambil
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, String $id)
    {
        $kategori = Kategori::findOrFail($id);
        $validated = $request->validate([
            'nama_kategori' => 'required|min:3',
            'gambar_kategori' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Cek apakah ada gambar baru yang diunggah
        if ($request->hasFile('gambar_kategori')) {
            // Hapus gambar lama jika ada
            if ($kategori->gambar_kategori && file_exists(public_path('images/kategori/' . $kategori->gambar_kategori))) {
                unlink(public_path('images/kategori/' . $kategori->gambar_kategori));
            }
            // Simpan gambar baru
            $imageName = time() . '.' . $request->gambar_kategori->extension();
            $request->gambar_kategori->move(public_path('images/kategori'), $imageName);
            $validated['gambar_kategori'] = $imageName;
        }
        else {
            // Pertahankan gambar lama jika tidak ada unggahan baru
            $validated['gambar_kategori'] = $kategori->gambar_kategori;
        }

        // Update Kategori
        $kategori->update($validated);

        return redirect('/admin-kategori')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        Kategori::destroy($id);
        return redirect('admin-kategori')->with('pesan', 'Data berhasil dihapus');
    }
}
