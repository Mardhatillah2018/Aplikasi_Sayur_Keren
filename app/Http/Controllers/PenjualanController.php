<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use Carbon\Carbon;
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

    // Load view dengan data terfilter
    $pdf = PDF::loadView('admin.admin-penjualan.cetakPdf', [
        'checkouts' => $checkouts,
        'tahun' => $tahun,
        'bulan' => Carbon::create(null, $bulan, 1)->translatedFormat('F'), // Konversi nama bulan
    ]);

    return $pdf->stream('Laporan-Penjualan.pdf');
}


}
