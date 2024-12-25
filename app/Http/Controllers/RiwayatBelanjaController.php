<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RiwayatBelanjaController extends Controller
{
    public function index(Request $request)
    {
        $query = Checkout::where('user_id', Auth::id()); // Filter berdasarkan user_id

        // Filter berdasarkan tab
        if ($request->filled('tab')) {
            $query->where('status', $request->tab); // Menggunakan nilai tab langsung
        } else {
            // Jika tidak ada tab yang dipilih, tampilkan pesanan diterima sebagai default
            $query->where('status', 'pesanan diterima');
        }

        // Ambil data
        $riwayatBelanja = $query->latest()->paginate(10);

        return view('pelanggan.riwayatBelanja', compact('riwayatBelanja'));
    }

    public function uploadBukti(Request $request, $id)
    {
        // Validasi file bukti transfer
        $validated = $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $checkout = Checkout::findOrFail($id);

        if ($request->hasFile('bukti_transfer')) {
            // Simpan file
            $imageName = time() . '.' . $request->bukti_transfer->extension();
            $request->bukti_transfer->move(public_path('images/buktiTF'), $imageName);
            $filePath = 'images/buktiTF/' . $imageName; // Pastikan path relatif saja yang disimpan

            // Simpan path bukti transfer ke database
            $checkout->bukti_transfer = $filePath;
            $checkout->save();
        }

        // Respons JSON dengan path file
        return response()->json([
            'success' => true,
            'bukti_path' => asset($filePath), // Tidak perlu menambahkan 'images/buktiTF' lagi
        ]);
    }

    public function simpanUlasan(Request $request, $id)
    {
        $validated = $request->validate([
            'ulasan' => 'required|string|max:500',
        ]);

        $checkout = Checkout::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $checkout->ulasan = $validated['ulasan']; // Pastikan kolom 'ulasan' ada di tabel
        $checkout->save();

        return redirect()->back()->with('success', 'Ulasan berhasil disimpan.');
    }
}
