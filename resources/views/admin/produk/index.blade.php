@extends('admin.layouts.main')
@section('title', 'Produk')
@section('navAdm', 'active')

@section('content')
<!-- Form Pencarian dan Tombol Tambah Produk Sejajar -->
<div class="d-flex justify-content-between mb-3">
    <!-- Tombol tambah produk -->
    <a href="/admin-produk/create" class="btn btn-primary mb-3" style="background-color: #0B773D; border-color: #0B773D; white-space: nowrap;">Tambah Produk</a>

    <!-- Form Pencarian -->
    <form action="{{ url('/admin-produk') }}" method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari Produk" value="{{ request()->input('search') }}" style="width: 250px;">
        <button type="submit" class="btn btn-primary" style="background-color: #0B773D; border-color: #0B773D;">Cari</button>
    </form>
</div>

<!-- Pesan sukses -->
@if(session('pesan'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('pesan') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Tabel Produk -->
<div class="card col-span-2 xl:col-span-1">
    <div class="card-header bg-success text-white">Produk</div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-success text-center">
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Masa Tahan</th>
                    <th>Gambar</th>
                    <th>Kategori</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($produks as $produk)
                <tr>
                    <td>{{ $produks->firstItem() + $loop->index }}</td>
                    <td>{{ $produk->nama }}</td>
                    <td>Rp{{ number_format($produk->harga, 0, ',', '.') }}</td>
                    <td>{{ $produk->masa_tahan }}</td>
                    <td>
                        <img src="{{ asset('images/' . $produk->gambar) }}" class="tab-image rounded" alt="{{ $produk->nama }}">
                    </td>
                    <td>
                        <span class="badge bg-primary">{{ $produk->kategori->nama_kategori }}</span>
                    </td>
                    <td>{{ $produk->keterangan }}</td>
                    <td class="text-center">
                        <a href="/admin-produk/{{ $produk->id }}/edit" title="Edit Data" class="btn btn-warning btn-sm me-2">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <form action="/admin-produk/{{ $produk->id }}" method="post" class="d-inline">
                            @method('DELETE')
                            @csrf
                            <button title="Hapus Data" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin menghapus data ini?')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center">
    {{ $produks->links() }}
</div>

@endsection

<style>
    .tab-image {
        width: 50px; /* Lebar gambar lebih kecil */
        height: 50px; /* Tinggi gambar lebih kecil */
        object-fit: cover;
    }
</style>

