<?php

namespace App\Http\Controllers;

use App\Models\BatchStok;
use App\Models\Produk;
use App\Models\Stok;
use Carbon\Carbon;
use Illuminate\Bus\Batch;
use Illuminate\Http\Request;
use Illuminate\Queue\Console\BatchesTableCommand;

class BatchStokController extends Controller
{
    // Menampilkan list batch stok
    public function index(Request $request)
    {
        $produkId = $request->query('produk_id');

        $batchStoks = BatchStok::when($produkId, function ($query, $produkId) {
            return $query->where('produk_id', $produkId);
        })->latest()->paginate(10); // untuk menampilkan 10 data per halaman

        return view('admin.batchStok.index', compact('batchStoks'));
    }

    // Halaman create batch stok
    public function create()
    {
        return view('admin.batchStok.create', ['batchStoks' => BatchStok::all()]);
    }

    // simpan data batch stok baru
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        // Menghitung tanggal kadaluarsa berdasarkan masa tahan produk
        $tgl_kadaluarsa = Carbon::now()->addDays($produk->masa_tahan);

        BatchStok::create([
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah,
            'tgl_kadaluarsa' => $tgl_kadaluarsa,
        ]);

        return redirect('/admin-batchStok')->with('pesan', 'Data Stok Berhasil Disimpan');

    }

    // tampilan detail batch stok
     public function show($id)
     {
         $batchStoks = BatchStok::where('produk_id', $id)
                                ->where('jumlah', '>', 0) // Menggunakan kolom jumlah
                                ->latest()
                                ->paginate(10); // Menambahkan paginate
         return view('admin.batchStok.index', compact('batchStoks'));
     }

    // menampilkan halaman edit
    public function edit($id)
    {
        $batch_stok = BatchStok::find($id);
        if (!$batch_stok) {
            abort(404, 'Batch stock not found');
        }
        return view('admin.batchStok.edit', compact('batch_stok'));
    }

    // update data batch stok
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'jumlah' => 'required|integer',
        ]);

        $batchStok = BatchStok::findOrFail($id);

        // Ambil produk yang terkait dengan batch stok
        $produk = Produk::findOrFail($batchStok->produk_id);

        // Hitung selisih antara jumlah baru dan jumlah lama batch stok
        $selisih = $validated['jumlah'] - $batchStok->jumlah;

        // Update batch stok
        $batchStok->update($validated);

        // Cari stok produk terkait
        $stok = Stok::where('produk_id', $produk->id)->first();

        if ($stok) {
            $stok->jumlah += $selisih;
            $stok->save();
        } else {
            Stok::create([
                'produk_id' => $produk->id,
                'jumlah' => $validated['jumlah'],
            ]);
        }

        // Redirect ke halaman batch stok berdasarkan produk ID
        return redirect('/admin-batchStok?produk_id=' . $produk->id)
            ->with('success', 'Stok berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BatchStok $batchStok)
    {
        //
    }
}
