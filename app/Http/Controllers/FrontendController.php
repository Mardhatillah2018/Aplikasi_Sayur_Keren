<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        $kategoriId = $request->get('kategori');
        $search = $request->get('search'); // Ambil query search

        // Query produk dengan relasi stok
        $produks = Produk::with('stok');

        // Filter berdasarkan kategori jika ada
        if ($kategoriId) {
            $produks->where('kategori_id', $kategoriId);
        }

        // Filter berdasarkan pencarian nama produk atau harga
        if ($search) {
            $produks->where('nama', 'like', "%{$search}%")
                    ->orWhere('harga', 'like', "%{$search}%");
        }

        return view('landing_page.semuaproduk', [
            'produks' => $produks->get(),
            'kategoris' => Kategori::all(),
        ]);
    }

    public function terbaru(Request $request)
    {
        // Ambil 10 produk terbaru berdasarkan created_at
        $produks = Produk::with('stok')
                        ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal dibuat terbaru
                        ->take(10) // Ambil 10 produk
                        ->get();

        return view('landing_page.terbaru', [
            'produks' => $produks, // Kirim data produk terbaru ke view
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        // Melakukan pencarian produk berdasarkan nama atau harga
        $produk = Produk::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")
                        ->orWhere('harga', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(10);

        return view('landing_page.semuaproduk', [
            'produks' => $produk,
            'kategoris' => Kategori::all(), // Menambahkan kategoris di sini
        ]);
    }
}
