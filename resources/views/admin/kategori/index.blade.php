@extends('admin.layouts.main')
@section('title', 'Kategori')
@section('navAdm', 'active')

@section('content')
<div class="d-flex justify-content-center align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3 class="h3 text-center" style="color: #0B773D; font-size: 25px;">DATA KATEGORI</h3>
</div>
<div class="d-flex justify-content-between mb-3">
    <!-- Tombol tambah kategori -->
    <a href="/admin-kategori/create" class="btn btn-primary mb-3" style="background-color: #0B773D; border-color: #0B773D; white-space: nowrap;">Tambah Kategori</a>

    <!-- Form Pencarian -->
    <form action="{{ url('/admin-kategori') }}" method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari Kategori" value="{{ request()->input('search') }}" style="width: 250px;">
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

<!-- Tabel Kategori -->
<div class="card col-span-2 xl:col-span-1">
    <div class="card-header bg-success text-white">Kategori</div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-success text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($kategoris as $kategori)
                <tr>
                    <td>{{ $kategoris->firstItem() + $loop->index }}</td>
                    <td>{{ $kategori->nama_kategori }}</td>
                    <td>
                        <img src="{{ asset('images/kategori/' . $kategori->gambar_kategori) }}" class="tab-image rounded" alt="{{ $kategori->nama_kategori }}">
                    </td>
                    <td class="text-center">
                        <a href="/admin-kategori/{{ $kategori->id }}/edit" title="Edit Data" class="btn btn-warning btn-sm me-2">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <form action="/admin-kategori/{{ $kategori->id }}" method="post" class="d-inline">
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
    {{ $kategoris->links() }}
</div>

@endsection

<style>
    .tab-image {
        width: 50px; /* Lebar gambar lebih kecil */
        height: 50px; /* Tinggi gambar lebih kecil */
        object-fit: cover;
    }
</style>
