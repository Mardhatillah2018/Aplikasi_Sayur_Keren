<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {
        // Mengambil data checkout dengan status 'selesai'
        $checkouts = Checkout::where('status', 'selesai')
            ->select('id', 'user_id', 'alamat_pengiriman', 'total_harga', 'tanggal_pemesanan', 'status')
            ->paginate(10); // Dengan pagination

        return view('admin.admin-penjualan.daftarPenjualan', compact('checkouts'));
    }

    public function show($id)
    {
        // Mengambil detail checkout berdasarkan ID
        $checkout = Checkout::findOrFail($id);

        return view('admin.admin-penjualan.detailPenjualan', compact('checkout'));
    }
}
