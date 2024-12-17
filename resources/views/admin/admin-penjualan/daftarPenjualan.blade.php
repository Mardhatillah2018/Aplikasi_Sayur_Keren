@extends('admin.layouts.main')
@section('title', 'Penjualan')
@section('navAdm', 'active')

@section('content')
<div class="d-flex justify-content-center align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3 class="text-center" style="color: #0B773D; font-size: 25px;">DATA PENJUALAN</h3>
</div>
<div class="d-flex justify-content-between mb-3">
    <!-- Form Filter Tahun & Bulan -->
    <form action="/cetak-pdf/penjualan" method="GET" class="d-flex" target="_blank">
        <select name="tahun" class="form-control me-2" required>
            <option value="" disabled selected>Pilih Tahun</option>
            @foreach(range(date('Y'), date('Y') - 5) as $year)
                <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
        </select>
        <select name="bulan" class="form-control me-2" required>
            <option value="" disabled selected>Pilih Bulan</option>
            @for($m = 1; $m <= 12; $m++)
                <option value="{{ sprintf('%02d', $m) }}">{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
            @endfor
        </select>
        <button type="submit" class="btn btn-success" style="white-space: nowrap;">
            <i class="bi bi-printer"></i> Cetak
        </button>
    </form>
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
