<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Stok;
use App\Models\BatchStok;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        // Memuat stok produk dengan relasi ke produk
        $stoks = Stok::with('produk')->latest()->paginate(10);
        return view('admin.stok.index', ['stoks' => $stoks]);
    }

    public function create()
    {
        return view('admin.stok.create', ['produks' => Produk::all()]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Mendapatkan produk untuk menghitung tanggal kadaluarsa berdasarkan masa tahan
        $produk = Produk::findOrFail($validated['produk_id']);

        // Menambahkan tanggal kadaluarsa otomatis berdasarkan masa tahan produk
        $validated['tgl_kadaluarsa'] = Carbon::now()->addDays($produk->masa_tahan);

        // Cek apakah sudah ada stok untuk produk ini
        $existingStok = Stok::where('produk_id', $validated['produk_id'])->first();

        if ($existingStok) {
            // Jika sudah ada, tambahkan jumlah stok yang baru
            $existingStok->jumlah += $validated['jumlah'];
            // $existingStok->tgl_kadaluarsa = $validated['tgl_kadaluarsa']; // Update tanggal kadaluarsa jika diperlukan
            $existingStok->save();
        } else {
            // Jika belum ada stok, simpan data baru
            $existingStok = Stok::create(array_merge($validated, ['tgl_stok' => Carbon::now()]));
        }

        // Menyimpan data ke tabel batchstok hanya dengan produk_id dan tgl_kadaluarsa
        BatchStok::create([
            'produk_id' => $validated['produk_id'],
            'tgl_kadaluarsa' => $validated['tgl_kadaluarsa'],
            'jumlah' => $validated['jumlah'] // tambahkan nilai jumlah di sini
        ]);

        // Redirect ke halaman daftar stok dengan pesan sukses
        return redirect('/admin-stok')->with('pesan', 'Data Stok Berhasil Disimpan');
    }

    public function tambahStok($id)
    {
        $stok = Stok::findOrFail($id);
        $produks = Produk::all(); // Ambil semua produk
        return view('admin.stok.tambahStok', compact('stok', 'produks'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Stok $stok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stok $stok)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stok $stok)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stok $stok)
    {
        //
    }

}
