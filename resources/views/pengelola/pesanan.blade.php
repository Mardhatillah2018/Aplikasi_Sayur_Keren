@extends('pengelola.layouts.main')
@section('title', 'Data Pesanan')
@section('navAdm', 'active')

@section('content')
<div class="container-fluid container-custom mt-4">
    <div class="card shadow-sm card-custom">

        <!-- Tab Navigation -->
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ request('tab') === 'diproses' ? '' : 'active' }}" href="?tab=pesanan diterima">Pesanan Diterima</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('tab') === 'diproses' ? 'active' : '' }}" href="?tab=diproses">Pesanan Diproses</a>
            </li>
        </ul>

        <!-- Tabel Pesanan Berdasarkan Tab -->
        @if(request('tab') === 'diproses')
        <!-- Pesanan Diproses -->
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">📦 Pesanan Diproses</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle table-responsive">
                    <thead class="table-warning">
                        <tr>
                            {{-- <th>No</th> --}}
                            <th>Alamat Pengiriman</th>
                            <th>Pesanan</th>
                            <th>Total</th>
                            <th>Bukti Transfer</th>
                            <th>Status</th>
                            <th>Aksi</th>
                            <th>Pesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checkouts as $checkout)
                        @if($checkout->status == 'diproses')
                        <tr>
                            <td>{{ $checkout->alamat_pengiriman }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $checkout->id }}">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                            </td>
                            <td>Rp {{ number_format($checkout->total_harga, 2) }}</td>
                            <td>
                                @if ($checkout->bukti_transfer)
                                    <a href="{{ asset($checkout->bukti_transfer) }}" target="_blank">
                                        <img src="{{ asset($checkout->bukti_transfer) }}" alt="Bukti Transfer" width="100">
                                    </a>
                                @else
                                    <span class="text-danger">Belum ada bukti</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-warning text-dark">{{ ucfirst($checkout->status) }}</span>
                            </td>
                            <td>
                                <form action="{{ route('checkouts.updateStatus', $checkout->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" name="status" value="dikirim" class="btn btn-sm btn-outline-info" onclick="return confirm('Kirim Pesanan ini?')">
                                        <i class="fas fa-shipping-fast"></i> Dikirim
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div>
                                    @if ($checkout->catatan_admin)
                                        <div class="alert alert-info">
                                            <strong>Pesan:</strong>
                                            <p>{{ $checkout->catatan_admin }}</p>
                                        </div>
                                    @else
                                        <span class="text-muted">Belum ada pesan</span>
                                    @endif
                                </div>

                                <!-- Tombol untuk membuka modal pesan hanya jika belum ada pesan -->
                                @if (!$checkout->catatan_admin)
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#messageModal{{ $checkout->id }}" title="Kirim Pesan">
                                        <i class="fas fa-comment"></i> Pesan
                                    </button>
                                @endif
                            </td>
                        </tr>
                        <!-- Modal Pesan -->
                        <div class="modal fade" id="messageModal{{ $checkout->id }}" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="messageModalLabel">Kirim Pesan ke Pelanggan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('checkouts.sendMessage', $checkout->id) }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="message" class="form-label">Pesan</label>
                                                <textarea class="form-control" id="message" name="catatan_admin" rows="4" required>{{ $checkout->catatan_admin }}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Detail Produk -->
                        <div class="modal fade" id="detailModal{{ $checkout->id }}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailModalLabel">Detail Pesanan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @php
                                            $details = json_decode($checkout->produk_details, true);
                                            $totalBelanja = 0;
                                            $diskon = $checkout->diskon;  // Misal diskon diambil dari $checkout->diskon
                                            $ongkir = $checkout->ongkir;  // Misal ongkir diambil dari $checkout->ongkir
                                        @endphp
                                        @foreach ($details as $index => $detail)
                                            @php
                                                $subtotal = $detail['jumlah'] * $detail['harga'];
                                                $totalBelanja += $subtotal;
                                            @endphp
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between">
                                                    <span><strong>Nama:</strong> {{ $detail['nama'] }}</span>
                                                    <span><strong>Jumlah:</strong> {{ $detail['jumlah'] }}</span>
                                                    <span><strong>Total:</strong> Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        @endforeach

                                        <!-- Garis Pemisah untuk Diskon dan Ongkir -->
                                        <hr>

                                        <!-- Menampilkan Diskon dan Ongkir -->
                                        <div class="d-flex justify-content-between mt-3">
                                            <span><strong>Diskon:</strong></span>
                                            <span>Rp{{ number_format($diskon, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mt-2">
                                            <span><strong>Ongkir:</strong></span>
                                            <span>Rp{{ number_format($ongkir, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-between">
                                        <h5 class="m-0">Total Belanja: <strong>Rp{{ number_format($totalBelanja - $diskon + $ongkir, 0, ',', '.') }}</strong></h5>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Tidak ada pesanan diproses.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <!-- Pesanan Diterima -->
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">📦 Pesanan Diterima</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle table-responsive">
                    <thead class="table-primary">
                        <tr>
                            <th>Alamat Pengiriman</th>
                            <th>Pesanan</th>
                            <th>Total</th>
                            <th>Bukti Transfer</th>
                            <th>Status</th>
                            <th>Aksi</th>
                            <th>Pesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checkouts as $checkout)
                        @if($checkout->status == 'pesanan diterima')
                        <tr>
                            <td>{{ $checkout->alamat_pengiriman }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $checkout->id }}">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                            </td>
                            <td>Rp {{ number_format($checkout->total_harga, 2) }}</td>
                            <td>
                                @if ($checkout->bukti_transfer)
                                    <a href="{{ asset($checkout->bukti_transfer) }}" target="_blank">
                                        <img src="{{ asset($checkout->bukti_transfer) }}" alt="Bukti Transfer" width="100">
                                    </a>
                                @else
                                    <span class="text-danger">Belum ada bukti</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ ucfirst($checkout->status) }}</span>
                            </td>
                            <td>
                                <form action="{{ route('checkouts.updateStatus', $checkout->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" name="status" value="diproses" class="btn btn-sm btn-outline-warning" onclick="return confirm('Proses Pesanan ini?')">
                                        <i class="fas fa-spinner"></i> Proses
                                    </button>
                                </form>
                            </td>
                            <td>
                                <!-- Menampilkan pesan yang sudah ada -->
                                <div>
                                    @if ($checkout->catatan_admin)
                                        <div class="alert alert-info">
                                            <strong>Pesan:</strong>
                                            <p>{{ $checkout->catatan_admin }}</p>
                                        </div>
                                    @else
                                        <span class="text-muted">Belum ada pesan</span>
                                    @endif
                                </div>

                                <!-- Tombol untuk membuka modal pesan hanya jika belum ada pesan -->
                                @if (!$checkout->catatan_admin)
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#messageModal{{ $checkout->id }}" title="Kirim Pesan">
                                        <i class="fas fa-comment"></i> Pesan
                                    </button>
                                @endif
                            </td>
                        </tr>
                        <!-- Modal Pesan -->
                        <div class="modal fade" id="messageModal{{ $checkout->id }}" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="messageModalLabel">Kirim Pesan ke Pelanggan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('checkouts.sendMessage', $checkout->id) }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="message" class="form-label">Pesan</label>
                                                <textarea class="form-control" id="message" name="catatan_admin" rows="4" required>{{ $checkout->catatan_admin }}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Detail Produk -->
                        <div class="modal fade" id="detailModal{{ $checkout->id }}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailModalLabel">Detail Pesanan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @php
                                            $details = json_decode($checkout->produk_details, true);
                                            $totalBelanja = 0;
                                            $diskon = $checkout->diskon;  // Misal diskon diambil dari $checkout->diskon
                                            $ongkir = $checkout->ongkir;  // Misal ongkir diambil dari $checkout->ongkir
                                        @endphp
                                        @foreach ($details as $index => $detail)
                                            @php
                                                $subtotal = $detail['jumlah'] * $detail['harga'];
                                                $totalBelanja += $subtotal;
                                            @endphp
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between">
                                                    <span><strong>Nama:</strong> {{ $detail['nama'] }}</span>
                                                    <span><strong>Jumlah:</strong> {{ $detail['jumlah'] }}</span>
                                                    <span><strong>Total:</strong> Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        @endforeach

                                        <!-- Garis Pemisah untuk Diskon dan Ongkir -->
                                        <hr>

                                        <!-- Menampilkan Diskon dan Ongkir -->
                                        <div class="d-flex justify-content-between mt-3">
                                            <span><strong>Diskon:</strong></span>
                                            <span>Rp{{ number_format($diskon, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mt-2">
                                            <span><strong>Ongkir:</strong></span>
                                            <span>Rp{{ number_format($ongkir, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-between">
                                        <h5 class="m-0">Total Belanja: <strong>Rp{{ number_format($totalBelanja - $diskon + $ongkir, 0, ',', '.') }}</strong></h5>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Tidak ada pesanan diterima.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $checkouts->links() }}
    </div>
</div>
@endsection

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
