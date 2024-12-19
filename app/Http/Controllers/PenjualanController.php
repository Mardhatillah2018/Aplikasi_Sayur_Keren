<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PenjualanController extends Controller
{
    public function index(Request $request)
{
    // Ambil parameter tahun dan bulan dari request
    $tahun = $request->input('tahun');
    $bulan = $request->input('bulan');

    // Query checkout dengan status 'selesai'
    $query = Checkout::where('status', 'selesai')
        ->select('id', 'user_id', 'alamat_pengiriman', 'total_harga', 'tanggal_pemesanan', 'status');

    // Filter berdasarkan tahun jika dipilih
    if ($tahun) {
        $query->whereYear('tanggal_pemesanan', $tahun);
    }

    // Filter berdasarkan bulan jika dipilih
    if ($bulan) {
        $query->whereMonth('tanggal_pemesanan', $bulan);
    }

    // Eksekusi query dengan pagination
    $checkouts = $query->latest()->paginate(10);

    // Kirim data ke view
    return view('admin.admin-penjualan.daftarPenjualan', compact('checkouts', 'tahun', 'bulan'));
}



    public function show($id)
    {
        // Mengambil detail checkout berdasarkan ID
        $checkout = Checkout::findOrFail($id);

        return view('admin.admin-penjualan.detailPenjualan', compact('checkout'));
    }

    public function cetakPdf(Request $request)
{
    // Tangkap input tahun dan bulan
    $tahun = $request->input('tahun');
    $bulan = $request->input('bulan');

    // Filter data berdasarkan tahun dan bulan jika ada
    $checkouts = Checkout::when($tahun, function ($query, $tahun) {
                            return $query->whereYear('tanggal_pemesanan', $tahun);
                        })
                        ->when($bulan, function ($query, $bulan) {
                            return $query->whereMonth('tanggal_pemesanan', $bulan);
                        })
                        ->where('status', 'selesai') // Hanya data dengan status "selesai"
                        ->get();

    // Jika tidak ada penjualan, tampilkan pesan
    $message = $checkouts->isEmpty() ? 'Maaf, penjualan tidak tersedia.' : null;

    // Konversi nama bulan
    $namaBulan = $bulan ? Carbon::create(null, $bulan)->translatedFormat('F') : 'Semua Bulan';

    // Hitung total penjualan
    $totalPenjualan = $checkouts->sum('total_harga');

    // Load view dengan data terfilter untuk PDF
    $pdf = PDF::loadView('admin.admin-penjualan.cetakPdf', [
        'checkouts' => $checkouts,
        'tahun' => $tahun ?: 'Semua Tahun',
        'bulan' => $namaBulan,
        'message' => $message,
        'totalPenjualan' => $totalPenjualan, // Kirim total penjualan ke view
    ]);

    return $pdf->stream('Laporan-Penjualan.pdf');
}



}
