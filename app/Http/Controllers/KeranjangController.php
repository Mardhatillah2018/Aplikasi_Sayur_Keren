<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjangs = Keranjang::with('produk')->where('pengguna_id', Auth::id())->get();
        $totalHarga = $keranjangs->sum(function ($keranjang) {
            return $keranjang->jumlah * $keranjang->harga;
        });

        // Kirim data keranjang ke view
        return view('pelanggan.keranjang', compact('keranjangs', 'totalHarga'));
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
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        $produkId = $request->produk_id;
        $jumlah = $request->jumlah;

        $produk = Produk::find($produkId);
        $harga = $produk->harga;

        $keranjang = Keranjang::where('pengguna_id', $userId)->where('produk_id', $produkId)->first();

        if ($keranjang) {
            $keranjang->jumlah += $jumlah;
            $keranjang->save();
        } else {
            Keranjang::create([
                'pengguna_id' => $userId,
                'produk_id' => $produkId,
                'jumlah' => $jumlah,
                'harga' => $harga,
            ]);
        }

        // Perbarui session keranjangs
        $keranjangs = Keranjang::with('produk')->where('pengguna_id', $userId)->get();
        session()->put('keranjangs', $keranjangs);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function show()
    {
        $keranjangs = Keranjang::where('pengguna_id', Auth::id())->get();
        $totalHarga = $keranjangs->sum(function ($keranjang) {
            return $keranjang->jumlah * $keranjang->harga;
        });

        return view('pelanggan.keranjang', compact('keranjangs', 'totalHarga'));
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

    public function destroy(string $id)
    {
        // Hapus produk dari keranjang
        Keranjang::where('id', $id)->where('pengguna_id', Auth::id())->delete();

        // Ambil data keranjang yang diperbarui dari database
        $keranjangs = Keranjang::with('produk')->where('pengguna_id', Auth::id())->get();

        // Simpan data keranjang yang diperbarui ke sesi
        session()->put('keranjangs', $keranjangs);

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
