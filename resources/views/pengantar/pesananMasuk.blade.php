@extends('pengantar.layouts.main')
@section('title', 'Data Produk')
@section('navAdm', 'active')

@section('content')
<div class="d-flex justify-content-center align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3 class="text-center" style="color: #0B773D; font-size: 25px;">PESANAN</h3>
</div>
<div class="container-fluid container-custom mt-4">
    <div class="card shadow-sm card-custom">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">📦 Pesanan Diantar</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-success">
                    <tr>
                        <th>No</th>
                        <th>Alamat Pengiriman</th>
                        <th>No HP</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($checkouts as $checkout)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($checkout->alamat_pengiriman) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="d-block text-decoration-none text-primary">
                                {{ $checkout->alamat_pengiriman }}
                            </a>
                        </td>
                        <td>
                            <!-- Menampilkan No Hp dari pengguna -->
                            <a href="tel:{{ $checkout->pengguna->nohp }}" class="d-block text-decoration-none text-success">
                                {{ $checkout->pengguna->nohp }}
                            </a>
                        </td>

                        <td><span>Rp {{ number_format($checkout->total_harga, 2) }}</span></td>

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
                                <!-- Tombol bawah -->
                                <div class="d-flex gap-1">
                                    <button type="submit" name="status" value="selesai"
                                        class="btn btn-sm {{ $checkout->status == 'selesai' ? 'btn-success' : 'btn-outline-success' }}"
                                        {{ $checkout->status == 'selesai' ? 'disabled' : '' }}
                                        title="Selesai">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                            </form>
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
