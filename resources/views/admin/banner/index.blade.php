@extends('admin.layouts.main')
@section('title', 'Banner')
@section('navAdm', 'active')

@section('content')
<div class="d-flex justify-content-center align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3 class="h3 text-center" style="color: #0B773D; font-size: 25px;">DATA BANNER</h3>
</div>
<div class="d-flex justify-content-between mb-3">
    <!-- Tombol tambah banner -->
    <a href="/admin-banner/create" class="btn btn-primary mb-3" style="background-color: #0B773D; border-color: #0B773D; white-space: nowrap;">Tambah Banner</a>

    <!-- Form Pencarian -->
    <form action="{{ url('/admin-banner') }}" method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari Banner" value="{{ request()->input('search') }}" style="width: 250px;">
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

<!-- Tabel Gambar Banner -->
<div class="card col-span-2 xl:col-span-1">
    <div class="card-header bg-success text-white">Banner</div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-success text-center">
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($banners as $banner)
                <tr>
                    <td class="text-center">{{ $banners->firstItem() + $loop->index }}</td>
                    <td class="text-center">
                        <img src="{{ asset('images/bannerSlide/' . $banner->gambar_banner) }}" class="tab-image rounded" alt="Banner">
                    </td>
                    <td class="text-center">
                        <a href="/admin-banner/{{ $banner->id }}/edit" title="Edit Data" class="btn btn-warning btn-sm me-2">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <form action="/admin-banner/{{ $banner->id }}" method="post" class="d-inline">
                            @method('DELETE')
                            @csrf
                            <button title="Hapus Data" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus banner ini?')">
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
    {{ $banners->links() }}
</div>

@endsection

<style>
    .tab-image {
        width: 150px; /* Lebar gambar banner */
        height: 100px; /* Tinggi gambar banner */
        object-fit: cover;
    }
</style>
