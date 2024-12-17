<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Log;

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

//     public function cetakPdf(Request $request)
// {
//     Log::info('Masuk ke metode cetakPdf');

//     $tahun = $request->input('tahun');
//     $bulan = $request->input('bulan');

//     // Validasi input
//     if (!$tahun || !$bulan) {
//         return redirect()->back()->with('error', 'Tahun dan bulan harus dipilih.');
//     }

//     // Ambil data penjualan berdasarkan tahun dan bulan
//     $checkouts = Checkout::whereYear('tanggal_pemesanan', $tahun)
//         ->whereMonth('tanggal_pemesanan', $bulan)
//         ->where('status', 'selesai')
//         ->get();

//     // Jika data tidak ditemukan
//     if ($checkouts->isEmpty()) {
//         return redirect()->back()->with('error', 'Tidak ada data penjualan pada bulan dan tahun yang dipilih.');
//     }

//     // Log untuk memastikan data yang diambil
//     Log::info('Data Checkouts: ', $checkouts->toArray());

//     // Generate PDF menggunakan view
//     $pdf = PDF::loadView('admin.admin-penjualan.cetakPdf', [
//         'checkouts' => $checkouts,
//         'tahun' => $tahun,
//         'bulan' => $bulan,
//     ]);

//     // Tampilkan PDF di browser
//     return $pdf->stream("Laporan_Penjualan_{$tahun}_{$bulan}.pdf");
// }

public function cetakPdf(){
    $pdf = PDF::loadView('admin.admin-penjualan.cetakPdf', ['checkouts' => Checkout::all()]);
    return $pdf->stream('Laporan-Penjualan.pdf');
    //return $pdf->download('Laporan-Data-Mahasiswa.pdf');
}


}
