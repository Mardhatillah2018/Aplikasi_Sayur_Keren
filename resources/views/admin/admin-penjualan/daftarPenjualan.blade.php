@extends('admin.layouts.main')
@section('title', 'Penjualan')
@section('navAdm', 'active')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <!-- Tombol cetak riwayat penjualan tanpa modal -->
    <a href="/cetak-pdf/penjualan" class="btn btn-success mb-3" style="background-color: #2a6ec8; border-color: #0B773D; white-space: nowrap;" target="_blank">
        <i class="bi bi-printer"></i> Cetak Riwayat Penjualan
    </a>
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
@endsection
