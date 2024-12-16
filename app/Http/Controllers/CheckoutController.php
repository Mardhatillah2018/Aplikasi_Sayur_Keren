<?php

namespace App\Http\Controllers;

use App\Models\BatchStok;
use App\Models\Checkout;
use App\Models\Keranjang;
use App\Models\Promo;
use App\Models\Stok;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout
     */
    public function index()
    {
        $checkouts = Checkout::latest()->paginate(10); // Gunakan paginate untuk hasil paginasi
        return view('pengelola.pesanan', compact('checkouts'));
    }

    public function showPesanan()
    {
        // Memfilter pesanan yang statusnya bukan 'dikirim' atau 'selesai'
        $checkouts = Checkout::whereNotIn('status', ['dikirim', 'selesai'])
                            ->latest() // Menampilkan berdasarkan urutan terbaru
                            ->paginate(10); // Menggunakan paginate untuk mendukung pagination

        return view('pengelola.pesanan', compact('checkouts')); // Kirim data ke view
    }


    // Menampilkan daftar pesanan untuk pengantar
    public function showPesananPengantar()
    {
        // Ambil pesanan dengan status 'dikirim' dan urutkan berdasarkan waktu terbaru
        $checkouts = Checkout::where('status', 'dikirim')
                            ->with('pengguna') // Memuat relasi pengguna agar kita bisa mengambil nohp
                            ->latest()
                            ->paginate(10); // Gunakan paginate untuk mendukung pagination

        // Kirimkan data ke view 'pengantar.listpesanan'
        return view('pengantar.pesananMasuk', compact('checkouts'));
    }


    // Konfirmasi pesanan
    public function confirm(Request $request, $id)
   {
       $checkout = Checkout::findOrFail($id);
       $checkout->status = 'diproses'; // Update status ke 'diproses'
       $checkout->catatan_admin = $request->input('catatan_admin'); // Opsional
       $checkout->save();

       // Logika untuk mengarahkan ke rute berbeda jika diperlukan
       if ($request->user()->role === 'pengelola') {
           return redirect()->route('pengelola.pesanan')->with('success', 'Pesanan berhasil dikonfirmasi.');
       } elseif ($request->user()->role === 'pengantar') {
           return redirect()->route('pengantar.pesanan-masuk')->with('success', 'Pesanan berhasil dikonfirmasi.');
       }
   }

    //update status pesanan
    public function updateStatus(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'status' => 'required|string'
        ]);

        // Cari pesanan berdasarkan ID
        $checkout = Checkout::findOrFail($id);

        // Perbarui status pesanan
        $checkout->status = $request->status;
        $checkout->save(); // Simpan perubahan ke database

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function sendMessage(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'catatan_admin' => 'required|string|max:255', // Validasi pesan
        ]);

        // Cari pesanan berdasarkan ID
        $checkout = Checkout::findOrFail($id);

        // Tambahkan pesan baru ke catatan_admin (atau jika pesan sudah ada, tambahkan ke pesan yang ada)
        $checkout->catatan_admin = $checkout->catatan_admin . "\n" . $request->input('catatan_admin');
        $checkout->save(); // Simpan perubahan ke database

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Pesan berhasil dikirim.');
    }

        /**
         * Store a newly created resource in storage.
         */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'alamat' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'ongkir' => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0',
        ]);

        $user = Auth::user();
        $keranjangs = Keranjang::where('pengguna_id', $user->id)->get();

        // Cek apakah keranjang kosong
        if ($keranjangs->isEmpty()) {
            return redirect()->route('keranjang.show')->with('error', 'Keranjang Anda kosong!');
        }

        // Hitung total harga produk
        $totalHargaProduk = $keranjangs->sum(function ($keranjang) {
            return $keranjang->jumlah * $keranjang->harga;
        });

        // Ambil promo aktif
        $promo = Promo::where('tanggal_mulai', '<=', Carbon::now('Asia/Jakarta')->toDateTimeString())
                    ->where('tanggal_berakhir', '>=', Carbon::now('Asia/Jakarta')->toDateTimeString())
                    ->first();

        // Hitung diskon
        $diskonAmount = 0;
        if ($promo) {
            $diskonPersentase = $promo->diskon / 100; // Hitung persentase diskon
            $diskonAmount = $totalHargaProduk * $diskonPersentase; // Hitung diskon berdasarkan promo
        }

        // Total harga akhir: Total Harga Produk + Ongkir - Diskon
        $totalHarga = $totalHargaProduk + $request->ongkir - $diskonAmount;

        // Persiapkan detail produk untuk disimpan
        $produkDetails = $keranjangs->map(function ($item) {
            return [
                'nama' => $item->produk->nama,
                'jumlah' => $item->jumlah,
                'harga' => $item->harga,
                'total' => $item->jumlah * $item->harga,
            ];
        });

        // Simpan checkout
        $checkout = Checkout::create([
            'user_id' => $user->id,
            'alamat_pengiriman' => $request->alamat,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'ongkir' => $request->ongkir,
            'diskon' => $diskonAmount,
            'total_harga' => $totalHarga,
            'produk_details' => $produkDetails->toJson(),
            'status' => 'pesanan diterima',
        ]);

        // Kurangi stok produk berdasarkan jumlah yang dipesan
        foreach ($keranjangs as $keranjang) {
            $jumlahDibutuhkan = $keranjang->jumlah;

            $batchStoks = BatchStok::where('produk_id', $keranjang->produk_id)
                ->orderBy('tgl_kadaluarsa', 'asc')
                ->get();

            foreach ($batchStoks as $batchStok) {
                if ($jumlahDibutuhkan <= 0) {
                    break;
                }

                if ($batchStok->jumlah >= $jumlahDibutuhkan) {
                    $batchStok->jumlah -= $jumlahDibutuhkan;
                    $batchStok->save();
                    $jumlahDibutuhkan = 0;
                } else {
                    $jumlahDibutuhkan -= $batchStok->jumlah;
                    $batchStok->jumlah = 0;
                    $batchStok->save();
                }
            }

            $stok = Stok::where('produk_id', $keranjang->produk_id)->first();
            if ($stok) {
                $stok->jumlah -= $keranjang->jumlah;
                $stok->save();
            }
        }

        // Hapus keranjang setelah checkout
        Keranjang::where('pengguna_id', $user->id)->delete();

        // Redirect ke halaman detail checkout
        return redirect()->route('checkout.detail', $checkout->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show()
    {
        $user = Auth::user();
        $keranjangs = Keranjang::where('pengguna_id', $user->id)->get();

        // Hitung total harga produk
        $totalHargaProduk = $keranjangs->sum(function ($keranjang) {
            return $keranjang->jumlah * $keranjang->harga;
        });

        // Ambil promo aktif
        $promo = Promo::where('tanggal_mulai', '<=', Carbon::now('Asia/Jakarta')->toDateTimeString())
                    ->where('tanggal_berakhir', '>=', Carbon::now('Asia/Jakarta')->toDateTimeString())
                    ->first();

        // Hitung diskon
        $diskonAmount = 0;
        if ($promo) {
            $diskonPersentase = $promo->diskon / 100; // Hitung persentase diskon
            $diskonAmount = $totalHargaProduk * $diskonPersentase; // Hitung diskon berdasarkan promo
        }

        // Total harga setelah diskon
        $totalHarga = $totalHargaProduk - $diskonAmount;

        // Ongkir (dapat diambil dari request atau diatur di sini)
        $ongkir = 0; // Ganti dengan nilai ongkir yang sesuai jika diperlukan

        // Total pembayaran
        $totalPembayaran = $totalHarga + $ongkir;

        return view('pelanggan.checkout', compact('user', 'keranjangs', 'totalHargaProduk', 'ongkir', 'diskonAmount', 'totalPembayaran', 'promo'));
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

   public function detail($id)
    {
        $checkout = Checkout::with('pengguna')->findOrFail($id);
        $produkDetails = json_decode($checkout->produk_details);

        // Hitung total belanja dari produk
        $totalBelanja = collect($produkDetails)->sum(function($p) {
            return $p->total;
        });

        // Ambil promo aktif
        $promo = Promo::where('tanggal_mulai', '<=', Carbon::now('Asia/Jakarta')->toDateTimeString())
                    ->where('tanggal_berakhir', '>=', Carbon::now('Asia/Jakarta')->toDateTimeString())
                    ->first();

        // Hitung diskon
        $diskonAmount = 0;
        if ($promo) {
            $diskonPersentase = $promo->diskon / 100;
            $diskonAmount = $totalBelanja * $diskonPersentase;
        }

        // Hitung total harga akhir: Total Belanja + Ongkir - Diskon
        $totalHargaAkhir = $totalBelanja + $checkout->ongkir - $diskonAmount;

        return view('pelanggan.detailPesanan', [
            'checkout' => $checkout,
            'produkDetails' => $produkDetails,
            'ongkir' => $checkout->ongkir,
            'totalBelanja' => $totalBelanja,
            'diskonAmount' => $diskonAmount,
            'totalHargaAkhir' => $totalHargaAkhir,
        ]);
    }

    // Fungsi untuk menghitung jarak antara dua titik (latitude, longitude)
    private function calculateDistance($loc1, $loc2)
    {
        $earthRadius = 6371; // radius bumi dalam km

        $latFrom = deg2rad($loc1[0]);
        $lonFrom = deg2rad($loc1[1]);
        $latTo = deg2rad($loc2[0]);
        $lonTo = deg2rad($loc2[1]);

        $latDiff = $latTo - $latFrom;
        $lonDiff = $lonTo - $lonFrom;

        $a = sin($latDiff / 2) * sin($latDiff / 2) +
            cos($latFrom) * cos($latTo) *
            sin($lonDiff / 2) * sin($lonDiff / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c; // dalam kilometer
        return $distance;
    }

    // Fungsi untuk menghitung ongkir berdasarkan jarak
    private function calculateOngkir($distance)
    {
        // Tentukan tarif ongkir per km
        $ratePerKm = 1000; // Rp 1000 per km

        // Membulatkan ongkir
        if ($distance < 0.5) {
            $ongkir = ceil($distance * $ratePerKm / 500) * 500;
        } else {
            $ongkir = ceil($distance * $ratePerKm / 1000) * 1000;
        }

        return $ongkir;
    }
}
