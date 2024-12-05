<?php

use App\Http\Controllers\BatchStokController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PengantarController;
use App\Http\Controllers\PengelolaController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\RiwayatBelanjaController;
use App\Http\Controllers\StokController;
use App\Models\Produk;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('home');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::get('/dashboard', function () {
//     return view('admin.dashboard');
// });

// // Rute untuk dashboard
// Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard.index');
//     })->name('dashboard.index');
// });
// Route::get('/dashboard', [ProdukController::class, 'jumlahProduk'])->name('dashboard');

// Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
//     Route::get('/dashboard', [ProdukController::class, 'jumlahProduk'])->name('dashboard.index');
// });

Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard.index');
});

// Rute untuk jumlah produk (misalnya: /dashboard/produk)
Route::get('/dashboard', [ProdukController::class, 'jumlahProduk'])->name('dashboard.produk')->middleware(['auth', 'role:admin']);

Route::get('/semuaproduk', function () {
    // Ambil semua produk beserta stoknya
    $produks = Produk::with('stok')->get();
    // Kirim data ke view
    return view('landing_page.semuaproduk', compact('produks'));
});


Route::get('/promo', function () {
    return view('landing_page.promo');
});

Route::get('/terlaris', function () {
    return view('landing_page.terlaris');
});

Route::get('/kategori', function () {
    return view('landing_page.kategori');
});
// Route::get('/kategori', [KategoriController::class, 'index']);


Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/detailpelanggan', function () {
    return view('pelanggan.detailpelanggan');
})->middleware(['auth', 'role:pelanggan']);

// Route::post('/update-profile', [PenggunaController::class, 'update'])->name('update-profile');
Route::get('/editprofile', function () {
    return view('pelanggan.editprofile');
})->middleware(['auth', 'role:pelanggan']);

Route::get('/edit-profile', [PenggunaController::class, 'edit'])->name('edit-profile')->middleware(['auth', 'role:pelanggan']);
Route::put('/edit-profile', [PenggunaController::class, 'update'])->name('update-profile')->middleware(['auth', 'role:pelanggan']);


Route::middleware(['auth'])->group(function () {
    Route::resource('keranjangs', KeranjangController::class);
})->middleware(['auth', 'role:pelanggan']);

// web.php
Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->middleware(['auth', 'role:pelanggan']);
Route::get('/keranjang', [KeranjangController::class, 'show'])->name('keranjang.show')->middleware(['auth', 'role:pelanggan']);

Route::resource('/admin-kategori', KategoriController::class)->middleware(['auth', 'role:admin']);
Route::resource('/admin-stok', StokController::class)->middleware(['auth', 'role:admin']);
Route::resource('/admin-batchStok', BatchStokController::class)->middleware(['auth', 'role:admin']);
Route::get('/admin-stok/{id}/tambahStok', [StokController::class, 'tambahStok'])->name('admin-stok.tambahStok')->middleware(['auth', 'role:admin']);

Route::resource('/admin-produk', ProdukController::class)->middleware('auth');
Route::get('/admin-batchStok/{produk_id}', [BatchStokController::class, 'show'])->name('batchstok.show')->middleware(['auth', 'role:admin']);
Route::get('/admin-batchStok/{id}/edit', [BatchStokController::class, 'edit'])->name('admin-batchStok.edit')->middleware(['auth', 'role:admin']);
Route::put('/admin-batchStok/{id}', [BatchStokController::class, 'update'])->name('admin-batchStok.update')->middleware(['auth', 'role:admin']);

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show')->middleware(['auth', 'role:pelanggan']);
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store')->middleware(['auth', 'role:pelanggan']);
Route::get('/checkout/{id}/detail', [CheckoutController::class, 'detail'])->name('checkout.detail')->middleware(['auth', 'role:pelanggan']);

Route::get('/riwayat-belanja', [RiwayatBelanjaController::class, 'index'])->name('riwayat-belanja')->middleware(['auth', 'role:pelanggan']);
Route::post('/upload-bukti/{id}', [RiwayatBelanjaController::class, 'uploadBukti'])->name('upload.bukti')->middleware(['auth', 'role:pelanggan']);


Route::get('/admin-pelanggan', [PenggunaController::class, 'index'])->name('admin.admin-pelanggan.index')->middleware(['auth', 'role:admin']);
Route::delete('/admin-pelanggan/{id}', [PenggunaController::class, 'destroy'])->name('admin.admin-pelanggan.destroy')->middleware(['auth', 'role:admin']);

Route::resource('/admin-promo', PromoController::class)->middleware(['auth', 'role:admin']);

Route::resource('/admin-pengelola', PengelolaController::class)->middleware(['auth', 'role:admin']);
Route::resource('/admin-pengantar', PengantarController::class)->middleware(['auth', 'role:admin']);

Route::get('/pesanan', function () {
    return view('pengelola.pesanan');
})->middleware(['auth', 'role:pengelola']);

Route::get('/pesanan', [CheckoutController::class, 'index'])->name('checkouts.index')->middleware(['auth', 'role:pengelola']);
Route::get('/pesanan/{id}', [CheckoutController::class, 'show'])->name('checkouts.show')->middleware(['auth', 'role:pengelola']);
Route::post('/pesanan/{id}/confirm', [CheckoutController::class, 'confirm'])->name('checkouts.confirm')->middleware(['auth', 'role:pengelola']);

Route::get('/pesanan', [CheckoutController::class, 'showPesanan'])->middleware(['auth', 'role:pengelola']);
// Route::put('/pesanan/{id}/update-status', [CheckoutController::class, 'updateStatus'])->name('checkouts.updateStatus');
Route::put('/checkouts/{id}/update-status', [CheckoutController::class, 'updateStatus'])->name('checkouts.updateStatus')->middleware(['auth', 'role:pengelola']);
Route::post('/checkouts/{id}/send-message', [CheckoutController::class, 'sendMessage'])->name('checkouts.sendMessage');

Route::get('/pesanan-masuk', function () {
    return view('pengantar.pesananMasuk');
})->middleware(['auth', 'role:pengantar']);

Route::post('/riwayat-belanja/{id}/ulasan', [RiwayatBelanjaController::class, 'simpanUlasan'])->name('riwayatBelanja.simpanUlasan');


