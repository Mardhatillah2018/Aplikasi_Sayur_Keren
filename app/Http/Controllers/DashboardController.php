<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Pelanggan;  // pastikan model Pelanggan ada
use App\Models\Pemesanan;  // pastikan model Pemesanan ada
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung jumlah produk
        $jumlahProduk = Produk::count();

        // Menghitung jumlah kategori
        $jumlahKategori = Kategori::count();

        // Menghitung jumlah pelanggan (role 'pelanggan')
        $jumlahPelanggan = Pengguna::where('role', 'pelanggan')->count();

        // Menghitung jumlah pesanan yang sudah diproses
        $jumlahPesananDiproses = Checkout::where('status', 'diproses')->count();

        // Mengirim data ke view dashboard
        return view('admin.dashboard', compact('jumlahProduk', 'jumlahKategori', 'jumlahPelanggan', 'jumlahPesananDiproses'));
    }
}
