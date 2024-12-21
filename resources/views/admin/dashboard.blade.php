<link rel="stylesheet" type="text/css" href="css/dashboard.css">
<script src="js/scripts.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.12.1/css/pro.min.css">
@extends('admin.layouts.main')

@section('content')

<!-- strat content -->
<div class="bg-gray-100 flex-1 p-6 md:mt-16">
    @if (session('username')) <!-- Periksa apakah username ada di session -->
        <a href="" style="color: #07582d; font-size: 20px; text-decoration: none;">
            <span class="me-2" style="font-size: 24px; font-weight: bold;"> <!-- Memperbesar ukuran teks -->
                Selamat Datang,
                <span style="font-size: 24px; font-weight: bold;"> <!-- Memperbesar username -->
                    {{ session('username') }}
                </span>
            </span>
        </a>
        <br>
        <!-- Menambahkan jarak antara teks dan card -->
        <div style="margin-top: 20px;"></div>
    @else
        <button class="btn-login" style="border-color: #07582d; transition: background-color 0.3s, color 0.3s;" onclick="window.location.href='/login';">
            <i class="bi bi-person-fill"></i> Login
        </button>
    @endif

    <!-- General Report -->
    <div class="grid grid-cols-4 gap-6 xl:grid-cols-1">
        <!-- Card untuk jumlah kategori -->
        <div class="report-card">
            <a href="{{ route('admin-kategori.index') }}" class="text-decoration-none">
                <div class="card">
                    <div class="card-body flex flex-col">
                        <!-- top -->
                        <div class="d-flex justify-between align-items-center">
                            <!-- Ikon kategori di sebelah kiri -->
                            <div class="px-3 py-2 rounded bg-green-600 text-white mr-3">
                                <i class="fad fa-th-large"></i> <!-- Ikon kategori -->
                            </div>
                            <!-- Jumlah kategori dan tulisan di sebelah kanan -->
                            <div class="text-end">
                                <h1 class="h3 num-4">
                                    {{ $jumlahKategori }}
                                </h1>
                                <p style="color: #07582d;">Jumlah Kategori</p> <!-- Tulisan jumlah kategori dengan warna #07582d -->
                            </div>
                        </div>
                        <!-- end top -->
                    </div>
                </div>
            </a>
            <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
        </div>

        <!-- Card untuk jumlah produk -->
        <div class="report-card">
            <a href="{{ route('admin-produk.index') }}" class="text-decoration-none">
                <div class="card">
                    <div class="card-body flex flex-col">
                        <!-- top -->
                        <div class="d-flex justify-between align-items-center">
                            <!-- Ikon produk atau keranjang di sebelah kiri -->
                            <div class="px-3 py-2 rounded bg-yellow-600 text-white mr-3">
                                <i class="fas fa-carrot"></i> <!-- Ikon produk atau kotak -->
                            </div>
                            <!-- Jumlah produk dan tulisan di sebelah kanan -->
                            <div class="text-end">
                                <h1 class="h3 num-4">
                                    {{ $jumlahProduk }}
                                </h1>
                                <p style="color: #07582d;">Jumlah Produk</p> <!-- Tulisan jumlah produk dengan warna #07582d -->
                            </div>
                        </div>
                        <!-- end top -->
                    </div>
                </div>
            </a>
            <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
        </div>
        <!-- Card untuk jumlah pelanggan -->
        <div class="report-card">
            <a href="{{ route('admin.admin-pelanggan.index') }}" class="text-decoration-none">
                <div class="card">
                    <div class="card-body flex flex-col">
                        <!-- top -->
                        <div class="d-flex justify-between align-items-center">
                            <!-- Ikon pelanggan di sebelah kiri -->
                            <div class="px-3 py-2 rounded bg-pink-600 text-white mr-3">
                                <i class="fad fa-users"></i> <!-- Ikon produk atau kotak -->
                            </div>
                            <!-- Jumlah pelanggan dan tulisan di sebelah kanan -->
                            <div class="text-end">
                                <h1 class="h3 num-4">
                                    {{ $jumlahPelanggan }}
                                </h1>
                                <p style="color: #07582d;">Jumlah Pelanggan</p>
                            </div>
                        </div>
                        <!-- end top -->
                    </div>
                </div>
            </a>
            <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
        </div>

        <!-- Card untuk jumlah pesanan diproses -->
        <div class="report-card">
            <a href="#" class="text-decoration-none">
                <div class="card">
                    <div class="card-body flex flex-col">
                        <!-- top -->
                        <div class="d-flex justify-between align-items-center">
                            <!-- Ikon pesanan diproses di sebelah kiri -->
                            <div class="px-3 py-2 rounded text-white mr-3" style="background-color: #007bff;">
                                <i class="fas fa-spinner fa-spin"></i> <!-- Ikon produk atau kotak -->
                            </div>
                            <!-- Jumlah pesanan diproses dan tulisan di sebelah kanan -->
                            <div class="text-end">
                                <h1 class="h3 num-4">
                                    {{ $jumlahPesananDiproses }}
                                </h1>
                                <p style="color: #07582d;">Pesanan Diproses</p>
                            </div>
                        </div>
                        <!-- end top -->
                    </div>
                </div>
            </a>
            <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
        </div>

    </div>
    <!-- End General Report -->

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-bold mb-4" style="color: #07582d;">Grafik Penjualan 7 Hari Terakhir</h2>
        <canvas id="grafikPenjualan"></canvas>
    </div>
    <div class="bg-white p-6 rounded shadow mt-6">
        <h2 class="text-lg font-bold mb-4" style="color: #07582d;">
            <i class="fas fa-money-bill-wave" style="color: #28a745; margin-right: 8px;"></i> <!-- Ikon uang -->
            Total Penjualan Bulan Ini
        </h2>
        <h3 class="text-2xl font-bold" style="color: #07582d;">
            Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
        </h3>
    </div>

  </div>
  <!-- end content -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('grafikPenjualan').getContext('2d');
    const data = {
        labels: {!! json_encode($pesananPerHari->pluck('tanggal')) !!},
        datasets: [{
            label: 'Pesanan Selesai',
            data: {!! json_encode($pesananPerHari->pluck('total')) !!},
            backgroundColor: 'rgba(7, 88, 45, 0.2)', // Warna hijau dengan transparansi
            borderColor: 'rgba(7, 88, 45, 1)',
            borderWidth: 1
        }]
    };
    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };
    new Chart(ctx, config);
</script>

@endsection


