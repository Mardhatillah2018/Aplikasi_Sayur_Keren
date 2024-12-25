<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    // Menampilkan list banner
    public function index()
    {
        $banners = Banner::latest()->paginate(10); // Pagination dengan 10 data per halaman
        return view('admin.banner.index', [
            'banners' => $banners,
        ]);
    }

    // Menampilkan halaman create banner
    public function create()
    {
        return view('admin.banner.create',['banners' =>Banner::all()]);
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'gambar_banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
         ]);

         //dd($validated);
         if ($request->hasFile('gambar_banner')) {
            $imageName = time().'.'.$request->gambar_banner->extension();
            $request->gambar_banner->move(public_path('images/bannerSlide'), $imageName);
            $validated['gambar_banner'] = $imageName;
        }

         Banner::create($validated);
         return redirect('/admin-banner')->with('pesan','Data Berhasil Disimpan');
    }

    public function show(Banner $banner)
    {
        //
    }

    // Menampilkan halaman edit banner
    public function edit(String $id)
    {
        $banner = Banner::find($id);
        // Memastikan data produk yang benar diambil
        return view('admin.banner.edit', compact('banner'));
    }

    // Update banner
    public function update(Request $request, String $id)
    {
        $banner = Banner::findOrFail($id);
        $validated = $request->validate([
            'gambar_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Cek apakah ada gambar baru yang diunggah
        if ($request->hasFile('gambar_banner')) {
            // Hapus gambar lama jika ada
            if ($banner->gambar_banner && file_exists(public_path('images/bannerSlide/' . $banner->gambar_banner))) {
                unlink(public_path('images/bannerSlide/' . $banner->gambar_banner));
            }
            // Simpan gambar baru
            $imageName = time() . '.' . $request->gambar_banner->extension();
            $request->gambar_banner->move(public_path('images/bannerSlide'), $imageName);
            $validated['gambar_banner'] = $imageName;
        }
        else {
            // Pertahankan gambar lama jika tidak ada unggahan baru
            $validated['gambar_banner'] = $banner->gambar_banner;
        }

        // Update Kategori
        $banner->update($validated);

        return redirect('/admin-banner')->with('success', 'Banner berhasil diperbarui');
    }

    // Hapus banner
    public function destroy(string $id)
    {
        Banner::destroy($id);
        return redirect('admin-banner')->with('pesan', 'Data berhasil dihapus');
    }
}
