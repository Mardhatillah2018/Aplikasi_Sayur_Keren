<?php

use App\Http\Controllers\BatchStokController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PengantarController;
use App\Http\Controllers\PengelolaController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\RiwayatBelanjaController;
use App\Http\Controllers\StokController;
use App\Models\Produk;

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard.index');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware(['auth', 'role:admin']);

Route::get('/semuaproduk', [FrontendController::class, 'index'])->name('semuaproduk');
Route::get('/semuaproduk/search', [FrontendController::class, 'search'])->name('frontend.search');

Route::get('/promo', function () {
    return view('landing_page.promo');
});

Route::get('/terlaris', function () {
    return view('landing_page.terlaris');
});

// Route::get('/kategori', function () {
//     return view('landing_page.kategori');
// });

// Route::get('/terbaru', function () {
//     return view('landing_page.terbaru');
// });
Route::get('/terbaru', [FrontendController::class, 'terbaru']);


Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::post('/logout', [LoginController::class, 'logout']);

//DETAIL PELANGGAN
Route::get('/detailpelanggan', function () {
    return view('pelanggan.detailpelanggan');
})->middleware(['auth', 'role:pelanggan']);

//EDIT PROFILE PELANGGAN
Route::get('/editprofile', function () {
    return view('pelanggan.editprofile');
})->middleware(['auth', 'role:pelanggan']);
Route::get('/edit-profile', [PenggunaController::class, 'edit'])->name('edit-profile')->middleware(['auth', 'role:pelanggan']);
Route::put('/edit-profile', [PenggunaController::class, 'update'])->name('update-profile')->middleware(['auth', 'role:pelanggan']);

//KERANJANG
Route::middleware(['auth'])->group(function () {
    Route::resource('keranjangs', KeranjangController::class);
})->middleware(['auth', 'role:pelanggan']);
Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->middleware(['auth', 'role:pelanggan']);
Route::get('/keranjang', [KeranjangController::class, 'show'])->name('keranjang.show')->middleware(['auth', 'role:pelanggan']);

//STOK
Route::resource('/admin-batchStok', BatchStokController::class)->middleware(['auth', 'role:admin']);
Route::get('/admin-stok/{id}/tambahStok', [StokController::class, 'tambahStok'])->name('admin-stok.tambahStok')->middleware(['auth', 'role:admin']);
Route::get('/admin-batchStok/{produk_id}', [BatchStokController::class, 'show'])->name('batchstok.show')->middleware(['auth', 'role:admin']);
Route::get('/admin-batchStok/{id}/edit', [BatchStokController::class, 'edit'])->name('admin-batchStok.edit')->middleware(['auth', 'role:admin']);
Route::put('/admin-batchStok/{id}', [BatchStokController::class, 'update'])->name('admin-batchStok.update')->middleware(['auth', 'role:admin']);

//CHECKOUT
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show')->middleware(['auth', 'role:pelanggan']);
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store')->middleware(['auth', 'role:pelanggan']);
Route::get('/checkout/{id}/detail', [CheckoutController::class, 'detail'])->name('checkout.detail')->middleware(['auth', 'role:pelanggan']);

//ADMIN
Route::resource('/admin-kategori', KategoriController::class)->middleware(['auth', 'role:admin']);
Route::resource('/admin-stok', StokController::class)->middleware(['auth', 'role:admin']);
Route::resource('/admin-produk', ProdukController::class)->middleware('auth');
Route::get('/admin-pelanggan', [PenggunaController::class, 'index'])->name('admin.admin-pelanggan.index')->middleware(['auth', 'role:admin']);
Route::delete('/admin-pelanggan/{id}', [PenggunaController::class, 'destroy'])->name('admin.admin-pelanggan.destroy')->middleware(['auth', 'role:admin']);
Route::resource('/admin-promo', PromoController::class)->middleware(['auth', 'role:admin']);
Route::resource('/admin-pengelola', PengelolaController::class)->middleware(['auth', 'role:admin']);
Route::resource('/admin-pengantar', PengantarController::class)->middleware(['auth', 'role:admin']);

//RIWAYAT BELANJA
Route::post('/riwayat-belanja/{id}/ulasan', [RiwayatBelanjaController::class, 'simpanUlasan'])->name('riwayatBelanja.simpanUlasan');
Route::get('/riwayat-belanja', [RiwayatBelanjaController::class, 'index'])->name('riwayat-belanja')->middleware(['auth', 'role:pelanggan']);
Route::post('/upload-bukti/{id}', [RiwayatBelanjaController::class, 'uploadBukti'])->name('upload.bukti')->middleware(['auth', 'role:pelanggan']);

//PENJUALAN
Route::resource('/admin-penjualan', PenjualanController::class)->middleware(['auth', 'role:admin']);
//Route::get('/admin-penjualan/cetak-pdf', [PenjualanController::class, 'cetakPdf'])->name('admin-penjualan.cetakPdf');
Route::get('/cetak-pdf/penjualan', [PenjualanController::class, 'cetakPdf']);


// PENGELOLA
Route::get('/pesanan', [CheckoutController::class, 'showPesanan'])->middleware(['auth', 'role:pengelola']);
// Route::put('/checkouts/{id}/update-status', [CheckoutController::class, 'updateStatus'])->name('checkouts.updateStatus')->middleware(['auth', 'role:pengelola']);
Route::post('/checkouts/{id}/send-message', [CheckoutController::class, 'sendMessage'])->name('checkouts.sendMessage');
//Route::get('/pesanan', [CheckoutController::class, 'index'])->name('checkouts.index')->middleware(['auth', 'role:pengelola']);
Route::get('/pesanan/{id}', [CheckoutController::class, 'show'])->name('checkouts.show')->middleware(['auth', 'role:pengelola']);
Route::post('/pesanan/{id}/confirm', [CheckoutController::class, 'confirm'])->name('checkouts.confirm')->middleware(['auth', 'role:pengelola']);

//UBAH STATUS PESANAN OLEH PENGELOLA DAN PENGANTAR
Route::put('/checkouts/{id}/update-status', [CheckoutController::class, 'updateStatus'])
    ->name('checkouts.updateStatus')
    ->middleware(['auth', 'role:pengelola,pengantar']);

// PENGANTAR
Route::get('/pesanan-masuk', [CheckoutController::class, 'index'])->name('checkouts.index')->middleware(['auth', 'role:pengantar']);
Route::get('/pesanan-masuk/{id}', [CheckoutController::class, 'show'])->name('checkouts.show')->middleware(['auth', 'role:pengantar']);
Route::post('/pesanan-masuk/{id}/confirm', [CheckoutController::class, 'confirm'])->name('checkouts.confirm')->middleware(['auth', 'role:pengantar']);
Route::get('/pesanan-masuk', [CheckoutController::class, 'showPesananPengantar'])->middleware(['auth', 'role:pengantar']);





