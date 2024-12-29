@extends('admin.layouts.main')
@section('title', 'Data Pelanggan')
@section('navAdm', 'active')

@section('content')
<div class="d-flex justify-content-center align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3 class="h3 text-center" style="color: #0B773D; font-size: 25px;">DATA PELANGGAN</h3>
</div>

@if(session('pesan'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('pesan') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Tabel Data Pelanggan -->
<div class="card col-span-2 xl:col-span-1">
    <div class="card-header bg-success text-white">Data Pelanggan</div>

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
                @foreach($penggunas as $index => $pengguna)
                    <tr>
                        <td>{{ $penggunas->firstItem() + $index }}</td>
                        <td>{{ $pengguna->username }}</td>
                        <td>{{ $pengguna->email }}</td>
                        <td>{{ $pengguna->nohp }}</td>
                        <td class="text-center">
                            <form action="/admin-pelanggan/{{ $pengguna->id }}" method="post" class="d-inline">
                                @method('DELETE')
                                @csrf
                                <button title="Hapus Data" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin menghapus data pelanggan ini?')"><i class="bi bi-trash"></i> Hapus</button>
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
    {{ $penggunas->links() }}
</div>
@endsection

