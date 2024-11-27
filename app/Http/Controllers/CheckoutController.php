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
     * Display a listing of the resource.
     */
    public function index()
    {
        $checkouts = Checkout::paginate(10); // Gunakan paginate untuk hasil paginasi
        return view('pengelola.pesanan', compact('checkouts'));
    }

    public function showPesanan()
    {
        $checkouts = Checkout::paginate(10); // Gunakan paginate untuk mendukung pagination
        return view('pengelola.pesanan', compact('checkouts')); // Kirim data ke view
    }

    // Konfirmasi pesanan
    public function confirm(Request $request, $id)
    {
        $checkout = Checkout::findOrFail($id);
        $checkout->status = 'diproses'; // Update status ke 'diproses'
        $checkout->catatan_admin = $request->input('catatan_admin'); // Opsional
        $checkout->save();

        return redirect()->route('pengelola.pesanan')->with('success', 'Pesanan berhasil dikonfirmasi.');
    }

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
        ]);

        $user = Auth::user(); // Ambil data pengguna yang sedang login
        $keranjangs = Keranjang::where('pengguna_id', $user->id)->get();

        if ($keranjangs->isEmpty()) {
            return redirect()->route('keranjang.show')->with('error', 'Keranjang Anda kosong!');
        }

        // Hitung total harga produk
        $totalHargaProduk = $keranjangs->sum(function ($keranjang) {
            return $keranjang->jumlah * $keranjang->harga;
        });

        // Ambil promo aktif menggunakan scope
        $promo = Promo::where('tanggal_mulai', '<=', Carbon::now())
                      ->where('tanggal_berakhir', '>=', Carbon::now())
                      ->first();

        $diskonAmount = 0; // Jumlah diskon yang dihitung
        if ($promo) {
            $diskon = $promo->persentase_diskon / 100;
            $diskonAmount = $totalHargaProduk * $diskon;
            $totalHargaProduk -= $diskonAmount;
        }

        $totalHarga = $totalHargaProduk + $request->ongkir;

        // Persiapkan detail produk dalam format JSON
        $produkDetails = $keranjangs->map(function ($item) {
            return [
                'nama' => $item->produk->nama,
                'jumlah' => $item->jumlah,
                'harga' => $item->harga,
                'total' => $item->jumlah * $item->harga,
            ];
        });

        // Simpan ke tabel checkouts
        $checkout = Checkout::create([
            'user_id' => $user->id,
            'alamat_pengiriman' => $request->alamat,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'ongkir' => $request->ongkir,
            'diskon' => $diskonAmount, // Simpan nilai diskon ke database
            'total_harga' => $totalHarga, // Total harga sudah termasuk diskon dan ongkir
            'produk_details' => $produkDetails->toJson(),
            'status' => 'pesanan diterima',
        ]);

        // Proses pengurangan stok
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

        // Hapus keranjang pengguna
        Keranjang::where('pengguna_id', $user->id)->delete();

        // Redirect ke halaman detail pesanan
        return redirect()->route('checkout.detail', $checkout->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show()
    {
        // Mengambil data pengguna yang sedang login
        $user = Auth::user(); // Menggunakan Auth untuk mengambil data pengguna yang sedang login

        // Mengambil produk yang ada di keranjang milik pengguna
        $keranjangs = Keranjang::where('pengguna_id', $user->id)->get();

        // Menghitung total harga dari semua produk yang ada di keranjang
        $totalHargaProduk = $keranjangs->sum(function($keranjang) {
            return $keranjang->jumlah * $keranjang->harga;
        });

        // Ambil promo aktif menggunakan scope
        $promo = Promo::where('tanggal_mulai', '<=', Carbon::now())
                      ->where('tanggal_berakhir', '>=', Carbon::now())
                      ->first();

        $diskon = 0;
        if ($promo) {
            $diskon = $promo->persentase_diskon / 100;
            $totalHargaProduk = $totalHargaProduk - ($totalHargaProduk * $diskon);
        }

        // Hitung total harga setelah diskon dan ongkir
        $totalHarga = $totalHargaProduk;

        // Kirim data ke view
        return view('pelanggan.checkout', compact('user', 'keranjangs', 'totalHarga'));
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
        // Ambil data checkout dengan relasi pengguna
        $checkout = Checkout::with('pengguna')->findOrFail($id);

        // Decode produk details dari JSON
        $produkDetails = json_decode($checkout->produk_details);

        // Data langsung diambil dari tabel `checkouts`
        $ongkir = $checkout->ongkir;
        $totalHargaAkhir = $checkout->total_harga; // Total harga sudah termasuk diskon dan ongkir
        $diskonAmount = $checkout->diskon; // Ambil nilai diskon dari database

        // Hitung total belanja produk (tanpa diskon, hanya sebagai informasi tambahan jika diperlukan)
        $totalBelanja = collect($produkDetails)->sum(function ($produk) {
            return $produk->harga * $produk->jumlah;
        });

        // Render ke view dengan data lengkap
        return view('pelanggan.detailPesanan', compact(
            'checkout',
            'produkDetails',
            'ongkir',
            'totalBelanja',
            'diskonAmount',
            'totalHargaAkhir'
        ));
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
