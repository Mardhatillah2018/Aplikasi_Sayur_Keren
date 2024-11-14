@extends('admin.layouts.main')
@section('title', 'Data Pelanggan')
@section('navAdm', 'active')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <!-- Form Pencarian -->
    <form action="{{ url('/admin-pelanggan') }}" method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari Pelanggan" value="{{ request()->input('search') }}" style="width: 250px;">
        <button type="submit" class="btn btn-primary" style="background-color: #0B773D; border-color: #0B773D;">Cari</button>
    </form>
</div>

@if(session('pesan'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('pesan') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Tabel Data Pelanggan -->
<div class="card col-span-2 xl:col-span-1">
    <div class="card-header">Data Pelanggan</div>

    <table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Username</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penggunas as $index => $pengguna)
                <tr>
                    <td>{{ $penggunas->firstItem() + $index }}</td>
                    <td>{{ $pengguna->username }}</td>
                    <td>{{ $pengguna->email }}</td>
                    <td>{{ $pengguna->nohp }}</td>
                    <td class="text-center">
                        {{-- <a href="/admin-pengguna/{{ $pengguna->id }}/edit" title="Edit Data" class="btn btn-warning btn-sm me-2"><i class="bi bi-pencil-square"></i> Edit</a> --}}
                        <form action="/admin-pelanggan/{{ $pengguna->id }}" method="post" class="d-inline">
                            @method('DELETE')
                            @csrf
                            <button title="Hapus Data" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin menghapus data ini?')"><i class="bi bi-trash"></i> Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center">
    {{ $penggunas->links() }}
</div>
@endsection
