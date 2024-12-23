<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $now = now(); // Waktu saat ini
        $endOfDay = now()->endOfDay(); // Akhir hari ini (23:59:59)

        $promosBerlaku = Promo::where('tanggal_berakhir', '>=', $now)
                            ->orderByDesc('tanggal_mulai')
                            ->paginate(10, ['*'], 'berlaku'); // Promo yang masih berlaku sampai akhir hari

        $promosHabis = Promo::where('tanggal_berakhir', '<', $now)
                            ->orderByDesc('tanggal_mulai')
                            ->paginate(10, ['*'], 'habis'); // Promo yang sudah habis sebelum sekarang

        return view('admin.promo.index', compact('promosBerlaku', 'promosHabis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.promo.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'diskon' => 'required|numeric|min:0|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // Tambahkan waktu akhir hari jika tidak ada waktu dalam input
        $validated['tanggal_berakhir'] = \Carbon\Carbon::parse($validated['tanggal_berakhir'])->endOfDay();

        Promo::create($validated);

        return redirect('/admin-promo')->with('pesan', 'Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Promo $promo)
    {
        //
    }

    public function edit(string $id)
    {
        $promo = Promo::find($id);
        return view('admin.promo.edit', compact('promo')); // Menampilkan form edit
    }

    public function update(Request $request, String $id)
    {
        $promo = Promo::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'diskon' => 'required|numeric|min:0|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // Tambahkan waktu akhir hari jika tidak ada waktu dalam input
        $validated['tanggal_berakhir'] = \Carbon\Carbon::parse($validated['tanggal_berakhir'])->endOfDay();

        $promo->update($validated);

        return redirect('/admin-promo')->with('success', 'Promo berhasil diperbarui');
    }


    public function destroy(string $id)
    {
        Promo::destroy($id);
        return redirect('admin-promo')->with('pesan', 'Data berhasil dihapus');
    }
}
