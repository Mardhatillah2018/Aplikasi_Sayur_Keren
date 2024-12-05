<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RiwayatBelanjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Checkout::where('user_id', Auth::id());

    // Filter berdasarkan status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Filter berdasarkan bulan
    if ($request->filled('bulan')) {
        $query->whereMonth('tanggal_pemesanan', $request->bulan);
    }

    // Filter berdasarkan tahun
    if ($request->filled('tahun')) {
        $query->whereYear('tanggal_pemesanan', $request->tahun);
    }

    // Ambil data
    $riwayatBelanja = $query->latest()->paginate(10);

    return view('pelanggan.riwayatBelanja', compact('riwayatBelanja'));
}


    /**
     * Update the specified resource in storage.
     */
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
