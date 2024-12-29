@extends('admin.layouts.main')
@section('title', 'Data Pengantar Pesanan')
@section('navAdm', 'active')

@section('content')
<div class="d-flex justify-content-center align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3 class="h3 text-center" style="color: #0B773D; font-size: 25px;">DATA PENGANTAR</h3>
</div>
<div class="d-flex justify-content-between mb-3">
    <a href="/admin-pengantar/create" class="btn btn-primary mb-3" style="background-color: #0B773D; border-color: #0B773D;">Tambah Pengantar Pesanan</a>

    <!-- Form Pencarian -->
    <form action="{{ url('/admin-pengantar') }}" method="GET" class="d-flex align-items-center">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari Pengantar Pesanan" value="{{ request()->input('search') }}" style="width: 250px;">
        <button type="submit" class="btn btn-primary" style="background-color: #0B773D; border-color: #0B773D;">Cari</button>
    </form>
</div>

@if(session('pesan'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('pesan') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Tabel Data Pengantar Pesanan -->
<div class="card col-span-2 xl:col-span-1">
    <div class="card-header bg-success text-white">Data Pengantar Pesanan</div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-success text-center">
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengantars as $index => $pengantar)
                    <tr>
                        <td>{{ $pengantars->firstItem() + $index }}</td>
                        <td>{{ $pengantar->username }}</td>
                        <td>{{ $pengantar->email }}</td>
                        <td>{{ $pengantar->nohp }}</td>
                        <td class="text-center">
                            <a href="/admin-pengantar/{{ $pengantar->id }}/edit" title="Edit Data" class="btn btn-warning btn-sm me-2"><i class="bi bi-pencil-square"></i> Edit</a>
                            <form action="/admin-pengantar/{{ $pengantar->id }}" method="post" class="d-inline">
                                @method('DELETE')
                                @csrf
                                <button title="Hapus Data" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin menghapus data pengantar pesanan ini?')"><i class="bi bi-trash"></i> Hapus</button>
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
    {{ $pengantars->links() }}
</div>
@endsection
