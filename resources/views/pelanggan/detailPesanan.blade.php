@extends('layouts.main')

@section('content')
    <section class="mt-5">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-md-10 col-lg-8 mb-4">
                    <div class="card shadow-lg rounded" style="border: none;">
                        <div class="card-body">
                            <div class="table-responsive">
                            <h4 class="mt-1 text-center" style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #0B773D; font-size: 1rem;">Detail Pesanan</h4>
                            <div class="mb-4">
                                <p style="font-size: 0.975rem;"><strong>Tanggal Pemesanan:</strong> {{ \Carbon\Carbon::parse($checkout->tanggal_pemesanan)->format('d F Y') }}</p>
                            </div>

                            <hr style="border-top: 2px solid #0B773D; margin-bottom: 20px;">

                            <!-- Data Pelanggan -->
                            <div class="mb-4">
                                <h5 class="font-weight-bold" style="font-size: 0.975rem;">Data Pelanggan</h5>
                                @if($checkout->pengguna)
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td style="font-size: 0.875rem;"><strong>Username:</strong></td>
                                                <td style="font-size: 0.875rem;">{{ $checkout->pengguna->username }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 0.875rem;"><strong>No. HP:</strong></td>
                                                <td style="font-size: 0.875rem;">{{ $checkout->pengguna->nohp }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 0.875rem;"><strong>Alamat Pengiriman:</strong></td>
                                                <td style="font-size: 0.875rem;">{{ $checkout->alamat_pengiriman }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @else
                                    <p>User tidak ditemukan!</p>
                                @endif
                            </div>

                            <hr style="border-top: 2px solid #0B773D; margin-bottom: 20px;">

                            <!-- Data Produk yang Dibeli -->
                            <div class="mb-4">
                                <h5 class="font-weight-bold" style="font-size: 0.975rem;">Data Produk</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center" style="font-size: 0.875rem;">Produk</th>
                                            <th scope="col" class="text-center" style="font-size: 0.875rem;">Jumlah</th>
                                            <th scope="col" class="text-center" style="font-size: 0.875rem;">Harga</th>
                                            <th scope="col" class="text-center" style="font-size: 0.875rem;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($produkDetails as $produk)
                                        <tr>
                                            <td style="font-size: 0.875rem;">{{ $produk->nama }}</td>
                                            <td style="font-size: 0.875rem;">{{ $produk->jumlah }}</td>
                                            <td style="font-size: 0.875rem;">Rp {{ number_format($produk->harga, 2, ',', '.') }}</td>
                                            <td style="font-size: 0.875rem;">Rp {{ number_format($produk->total, 2, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <hr style="border-top: 2px solid #0B773D; margin-bottom: 20px;">

                            <div class="mb-4 text-left">
                                <h6 class="font-weight-bold" style="font-size: 0.975rem;">Belanja: <span>Rp {{ number_format($totalBelanja, 0, ',', '.') }}</span></h6>
                            </div>

                            <!-- Ongkir -->
                            <div class="mb-4 text-left">
                                <h6 class="font-weight-bold" style="font-size: 0.975rem;">Ongkir: <span>Rp {{ number_format($ongkir, 0, ',', '.') }}</span></h6>
                            </div>

                            <!-- Diskon -->
                            <h6 class="font-weight-bold" style="font-size: 0.975rem;">
                                Diskon: <span style="color: #D32F2F;">
                                    Rp {{ number_format($diskonAmount, 0, ',', '.') }}
                                </span>
                            </h6>


                            <hr style="border-top: 2px solid #0B773D; margin-bottom: 20px;">

                            <!-- Total Pembayaran -->
                            <div class="mb-4 text-left">
                                <h5 class="font-weight-bold" style="color: #0B773D;">Total Pembayaran: <span style="color: #0B773D;">Rp {{ number_format($totalHargaAkhir, 0, ',', '.') }}</span></h5>
                            </div>

                            <!-- Informasi Pembayaran -->
                            <div class="mb-3 d-flex justify-content-center">
                                <div class="border p-2" style="width: 80%; max-width: 600px; background-color: #f9f9f9; border-radius: 8px; border: 3px solid #0B773D; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                    <p class="mb-2">Bayar: <span style="font-weight: bold; color: #0B773D;">Mandiri</span> a/n <span style="font-weight: bold; color: #0B773D;">Kelompok B</span>, No Rekening: <span style="font-weight: bold; color: #0B773D;">1120290091890</span></p>
                                    <p style="font-size: 0.75rem; color: red;">
                                        <a href="/riwayat-belanja" style="color: red; text-decoration: none;" title="Riwayat Belanja">*Klik untuk mengirim bukti pembayaran</a>
                                    </p>
                                </div>
                            </div>

                            <!-- Footer Struk -->
                            <div class="text-center mt-3">
                                <p><small>Terima kasih telah berbelanja di Sayur Keren!</small></p>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tombol Kembali -->
            <div>
                <a href="/riwayat-belanja" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </section>
@endsection

<style>
    body {
        display: flex;
        flex-direction: column;
        height: 100vh; /* Membuat body mengisi seluruh tinggi layar */
        margin: 0;
    }

    main {
        flex-grow: 1; /* Membuat main mengambil ruang sisa */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container-fluid {
        margin-bottom: 0;
    }

    .card {
        margin-top: 10px; /* Mengurangi jarak atas dari card */
        margin-bottom: 20px; /* Mengurangi jarak bawah dari card */
    }

    .card-body {
        padding: 1rem;
    }

    .mb-4 {
        margin-bottom: 15px;
    }

    .text-center {
        margin-top: 20px;
    }

        /* Styling untuk Data Pelanggan */
    .table td, .table th {
        vertical-align: middle;
        text-align: left;
    }

    .table th {
        background-color: #f8f9fa;
        color: #0B773D;
    }

    /* Border pada tabel dan kolom */
    .table-bordered {
        border: 1px solid #dee2e6;
    }

    .table-bordered td, .table-bordered th {
        border: 1px solid #dee2e6;
    }

    /* Styling untuk memastikan garis tabel terlihat baik */
    .table-bordered th, .table-bordered td {
        border-top: 1px solid #dee2e6; /* Garis horizontal di atas setiap sel */
        border-bottom: 1px solid #dee2e6; /* Garis horizontal di bawah setiap sel */
    }

    .table-bordered td {
        border-left: 1px solid #dee2e6; /* Garis vertikal di kiri setiap sel */
        border-right: 1px solid #dee2e6; /* Garis vertikal di kanan setiap sel */
    }
</style>
