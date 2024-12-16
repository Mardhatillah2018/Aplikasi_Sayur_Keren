@extends('admin.layouts.main')
@section('title', 'Penjualan')
@section('navAdm', 'active')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <!-- Tombol cetak riwayat penjualan dengan modal -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#cetakModal" style="background-color: #2a6ec8; border-color: #0B773D; white-space: nowrap;">
        <i class="bi bi-printer"></i> Cetak Riwayat Penjualan
    </button>
</div>

<div class="card col-span-2 xl:col-span-1">
    <div class="card-header bg-success text-white">Penjualan</div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-success text-center">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>User ID</th>
                    <th>Total Harga</th>
                    <th>Alamat</th>
                    <th>Tools</th>
                </tr>
            </thead>
            <tbody>
                @foreach($checkouts as $checkout)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($checkout->tanggal_pemesanan)->format('d-m-Y') }}</td>
                    <td>{{ $checkout->user_id }}</td>
                    <td>Rp {{ number_format($checkout->total_harga, 0, ',', '.') }}</td>
                    <td>{{ $checkout->alamat_pengiriman }}</td>
                    <td class="text-center">
                        <a href="/admin-penjualan/{{ $checkout->id }}" class="btn btn-success btn-sm">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center">
    {{ $checkouts->links() }}
</div>

<!-- Modal untuk memilih tahun dan bulan -->
<div class="modal fade" id="cetakModal" tabindex="-1" aria-labelledby="cetakModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="cetakModalLabel">Cetak Riwayat Penjualan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin-penjualan.cetakPdf') }}" method="GET" target="_blank">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Pilih Tahun</label>
                        <select name="tahun" id="tahun" class="form-select">
                            @for ($i = date('Y'); $i >= date('Y') - 10; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="bulan" class="form-label">Pilih Bulan</label>
                        <select name="bulan" id="bulan" class="form-select">
                            @foreach ([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
