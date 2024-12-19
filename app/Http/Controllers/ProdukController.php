<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil input pencarian dari request
        $search = $request->input('search');

        // Ambil produk dengan relasi stok, dan jika ada pencarian, filter berdasarkan nama produk atau nama kategori
        $produks = Produk::with('stok', 'kategori') // Pastikan relasi kategori ada
                        ->when($search, function ($query, $search) {
                            return $query->where('nama', 'like', '%' . $search . '%')  // Mencari berdasarkan nama produk
                                        ->orWhereHas('kategori', function ($query) use ($search) {
                                            $query->where('nama_kategori', 'like', '%' . $search . '%'); // Mencari berdasarkan nama kategori
                                        });
                        })
                        ->latest() // Mengurutkan produk berdasarkan yang terbaru
                        ->paginate(10); // Menampilkan 10 produk per halaman

        return view('admin.produk.index', compact('produks'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.produk.create',['kategoris' =>Kategori::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|min:3',
            'harga' => 'required|numeric',
            'masa_tahan' => 'required|integer',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kategori_id' => 'required|exists:kategoris,id',
            'keterangan' => 'nullable|string',
        ]);

        if ($request->hasFile('gambar')) {
            $imageName = time().'.'.$request->gambar->extension();
            $request->gambar->move(public_path('images/produk'), $imageName);
            $validated['gambar'] = $imageName;
        }

        // Simpan produk terlebih dahulu
        $produk = Produk::create($validated);

        // Tambahkan stok baru untuk produk ini
        $produk->stok()->create(['jumlah' => 0]); // Atur jumlah stok awal sesuai kebutuhan

        return redirect('/admin-produk')->with('pesan', 'Data Berhasil Disimpan');
    }


    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        $produk = Produk::find($id);
        // Memastikan data produk yang benar diambil
        return view('admin.produk.edit', ['produk' => $produk, 'kategoris' => Kategori::all()]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        // Cari produk berdasarkan ID
        $produk = Produk::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|min:3',
            'harga' => 'required|numeric',
            'masa_tahan' => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,id',
            'keterangan' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Cek apakah ada gambar baru yang diunggah
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($produk->gambar && file_exists(public_path('images/produk/' . $produk->gambar))) {
                unlink(public_path('images/produk/' . $produk->gambar));
            }
            // Simpan gambar baru
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images/produk'), $imageName);
            $validated['gambar'] = $imageName;
        } else {
            // Pertahankan gambar lama jika tidak ada unggahan baru
            $validated['gambar'] = $produk->gambar;
        }

        // Update produk
        $produk->update($validated);

        // Redirect setelah update
        return redirect('/admin-produk')->with('pesan', 'Data produk berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Produk::destroy($id);
        return redirect('admin-produk')->with('pesan', 'Data berhasil dihapus');
    }

    // ProdukController.php

    public function jumlahProduk()
    {
        $jumlahProduk = Produk::count(); // Menghitung total produk
        return view('admin.dashboard', compact('jumlahProduk'));
    }

}
