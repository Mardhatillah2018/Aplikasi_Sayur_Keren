@extends('admin.layouts.main')
@section('title', 'Detail Batch Stok')
@section('navAdm', 'active')

@section('content')
<div class="container">
    <!-- Header -->
    <h2 class="mb-4">Detail Batch Stok</h2>

    <!-- Informasi Produk -->
    <div class="card mb-3">
        <div class="card-header bg-success text-white">
            Informasi Produk
        </div>
        <div class="card-body">
            <h5 class="card-title">Nama Produk: <strong>{{ $batchStoks->first()->produk->nama ?? 'Tidak Diketahui' }}</strong></h5>
        </div>
    </div>

    <!-- Tabel Batch Stok -->
    <div class="card">
        <div class="card-header bg-success text-white">
            Batch Stok
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-success text-center">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Kadaluarsa</th>
                            {{-- <th>Nama Produk</th> --}}
                            <th>Jumlah Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($batchStoks as $index => $batchStok)
                        <tr>
                            <td>{{ $batchStoks->firstItem() + $index }}</td>
                            <td>{{ $batchStok->tgl_kadaluarsa }}</td>
                            {{-- <td>{{ $batchStok->produk->nama }}</td> --}}
                            <td>{{ $batchStok->jumlah }}</td>
                            <td class="text-center">
                                <!-- Tombol Edit -->
                                <a href="/admin-batchStok/{{ $batchStok->id }}/edit" title="Edit Data" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tombol Kembali dan Pagination -->
    <div class="d-flex justify-content-between mt-3">
        <a href="/admin-stok" class="btn btn-secondary">Kembali</a>
        {{ $batchStoks->links() }}
    </div>
</div>
@endsection
