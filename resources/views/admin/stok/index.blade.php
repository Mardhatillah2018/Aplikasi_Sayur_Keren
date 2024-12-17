@extends('admin.layouts.main')
@section('title', 'Stok')
@section('navAdm', 'active')

@section('content')
<div class="d-flex justify-content-center align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3 class="h3 text-center" style="color: #0B773D; font-size: 25px;">DATA STOK PRODUK</h3>
</div>
<!-- Pesan sukses -->
@if(session('pesan'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('pesan') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Form Pencarian dan Tombol Tambah Stok Sejajar -->
<div class="d-flex justify-content-between mb-3">
    <!-- Tombol tambah stok -->
    <a href="/admin-stok/create" class="btn btn-primary mb-3" style="background-color: #0B773D; border-color: #0B773D; white-space: nowrap;">Tambah Stok</a>
</div>

<!-- Tabel Stok -->
<div class="card col-span-2 xl:col-span-1">
    <div class="card-header bg-success text-white">Stok Produk</div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-success text-center">
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($stoks as $stok)
                <tr>
                    <td>{{ $stoks->firstItem() + $loop->index }}</td>
                    <td>{{ $stok->produk->nama }}</td>
                    <td>{{ $stok->jumlah }}</td>
                    <td class="text-center">
                        <!-- Tombol tambah stok -->
                        <a href="/admin-stok/{{ $stok->id }}/tambahStok" title="Tambah Stok" class="btn btn-success btn-sm me-2">
                            <i class="bi bi-plus-square"></i> Tambah Stok
                        </a>
                        <a href="/admin-batchStok/{{ $stok->produk_id }}" title="Lihat Batch Stok" class="btn btn-sm" style="background-color: #FFA500; border-color: #FFA500; color: white;">
                            <i class="bi bi-eye"></i> Lihat Batch
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
    {{ $stoks->links() }}
</div>
@endsection

<style>
    .tab-image {
        width: 50px; /* Ukuran gambar lebih kecil jika diperlukan */
        height: 50px;
        object-fit: cover;
    }
</style>
