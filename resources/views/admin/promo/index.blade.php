@extends('admin.layouts.main')
@section('title', 'Data Promo')
@section('navAdm', 'active')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <a href="/admin-promo/create" class="btn btn-primary mb-3" style="background-color: #0B773D; border-color: #0B773D;">Tambah Promo</a>
</div>

@if(session('pesan'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('pesan') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Tab Navigation -->
<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ request('tab') !== 'habis' ? 'active' : '' }}" href="?tab=berlaku">Promo Berlaku</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('tab') === 'habis' ? 'active' : '' }}" href="?tab=habis">Promo Habis</a>
    </li>
</ul>

<!-- Tabel Promo Berlaku -->
@if(request('tab') !== 'habis')
<div class="card mb-3">
    <div class="card-header bg-success text-white">Promo Berlaku</div>
    <table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Nama Promo</th>
                <th>Diskon</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Berakhir</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($promosBerlaku as $promo)
            <tr>
                <td>{{ $promosBerlaku->firstItem() + $loop->index }}</td>
                <td>{{ $promo->nama }}</td>
                <td>{{ $promo->diskon }}%</td>
                <td>{{ $promo->tanggal_mulai }}</td>
                <td>{{ $promo->tanggal_berakhir }}</td>
                <td class="text-center">
                    <a href="/admin-promo/{{ $promo->id }}/edit" title="Edit Data" class="btn btn-warning btn-sm me-2">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <form action="/admin-promo/{{ $promo->id }}" method="POST" class="d-inline">
                        @method('DELETE')
                        @csrf
                        <button title="Hapus Data" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus promo ini?')">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada promo yang berlaku.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-3">
        {{ $promosBerlaku->links() }}
    </div>
</div>
@endif

<!-- Tabel Promo Habis -->
@if(request('tab') === 'habis')
<div class="card">
    <div class="card-header bg-danger text-white">Promo Habis</div>
    <table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Nama Promo</th>
                <th>Diskon</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Berakhir</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($promosHabis as $promo)
            <tr>
                <td>{{ $promosHabis->firstItem() + $loop->index }}</td>
                <td>{{ $promo->nama }}</td>
                <td>{{ $promo->diskon }}%</td>
                <td>{{ $promo->tanggal_mulai }}</td>
                <td>{{ $promo->tanggal_berakhir }}</td>
                <td class="text-center">
                    <a href="/admin-promo/{{ $promo->id }}/edit" title="Edit Data" class="btn btn-warning btn-sm me-2">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <form action="/admin-promo/{{ $promo->id }}" method="POST" class="d-inline">
                        @method('DELETE')
                        @csrf
                        <button title="Hapus Data" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus promo ini?')">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada promo yang sudah habis.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-3">
        {{ $promosHabis->links() }}
    </div>
</div>
@endif

@endsection

<style>
    .table th, .table td {
        text-align: center; /* Menyelaraskan teks ke tengah */
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa; /* Menambahkan efek hover pada baris tabel */
    }
    .table-bordered {
        border: 1px solid #ddd; /* Menambahkan border pada tabel */
    }
    .table-bordered th, .table-bordered td {
        border: 1px solid #ddd; /* Border pada sel tabel */
    }
    .table-success {
        background-color: #28a745 !important; /* Mengganti warna header menjadi hijau */
        color: white; /* Teks header putih */
    }
    .table-danger {
        background-color: #dc3545 !important; /* Mengganti warna header menjadi merah */
        color: white; /* Teks header putih */
    }
    .card-header {
        font-weight: bold;
        font-size: 16px;
        padding: 10px 15px;
    }
</style>
