@extends('pengelola.layouts.main')
@section('title', 'Data Produk')
@section('navAdm', 'active')

@section('content')
<div class="container-fluid container-custom mt-4">
    <div class="card shadow-sm card-custom">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">📦 Pesanan Masuk</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-success">
                    <tr>
                        <th>No</th>
                        <th>Alamat Pengiriman</th>
                        <th>Total Harga</th>
                        <th>Bukti Transfer</th>
                        <th>Status</th>
                        <th>Aksi</th>
                        <th>Pesan</th> <!-- Kolom Pesan -->
                    </tr>
                </thead>
                <tbody>
                    @forelse ($checkouts as $checkout)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <span class="d-block">{{ $checkout->alamat_pengiriman }}</span>
                        </td>
                        <td><span class="text-success">Rp {{ number_format($checkout->total_harga, 2) }}</span></td>
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
                            <span class="badge
                                {{ $checkout->status == 'pesanan diterima' ? 'bg-primary' : '' }}
                                {{ $checkout->status == 'diproses' ? 'bg-warning text-dark' : '' }}
                                {{ $checkout->status == 'dikirim' ? 'bg-info text-dark' : '' }}
                                {{ $checkout->status == 'selesai' ? 'bg-success' : '' }}">
                                {{ ucfirst($checkout->status) }}
                            </span>
                        </td>

                        <td>
                            <form action="{{ route('checkouts.updateStatus', $checkout->id) }}" method="POST" class="d-flex flex-column gap-2">
                                @csrf
                                @method('PUT')
                                <!-- Tombol atas -->
                                <div class="d-flex gap-1">
                                    {{-- <button type="submit" name="status" value="pesanan diterima"
                                        class="btn btn-sm {{ $checkout->status == 'pesanan diterima' ? 'btn-primary' : 'btn-outline-primary' }} {{ in_array($checkout->status, ['diproses', 'dikirim', 'selesai']) ? 'disabled' : '' }} "
                                        title="Diterima">
                                        <i class="fas fa-check-circle"></i>
                                    </button> --}}
                                    <button type="submit" name="status" value="diproses"
                                        class="btn btn-sm {{ $checkout->status == 'diproses' ? 'btn-warning' : 'btn-outline-warning' }} {{ in_array($checkout->status, ['dikirim', 'selesai']) ? 'disabled' : '' }}"
                                        title="Diproses">
                                        <i class="fas fa-spinner"></i>
                                    </button>
                                </div>
                                <!-- Tombol bawah -->
                                <div class="d-flex gap-1">
                                    <button type="submit" name="status" value="dikirim"
                                        class="btn btn-sm {{ $checkout->status == 'dikirim' ? 'btn-info' : 'btn-outline-info' }} {{ $checkout->status == 'selesai' ? 'disabled' : '' }}"
                                        title="Dikirim">
                                        <i class="fas fa-shipping-fast"></i>
                                    </button>
                                    {{-- <button type="submit" name="status" value="selesai"
                                        class="btn btn-sm {{ $checkout->status == 'selesai' ? 'btn-success' : 'btn-outline-success' }} "
                                        {{ $checkout->status == 'selesai' ? 'disabled' : '' }}
                                        title="Selesai">
                                        <i class="fas fa-check"></i>
                                    </button> --}}
                                </div>
                            </form>
                        </td>

                        <!-- Kolom Pesan -->
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

                            <!-- Tombol untuk membuka modal pesan -->
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#messageModal{{ $checkout->id }}" title="Kirim Pesan">
                                <i class="fas fa-comment"></i> Pesan
                            </button>
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

                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Tidak ada pesanan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $checkouts->links() }}
    </div>
</div>

@endsection

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
