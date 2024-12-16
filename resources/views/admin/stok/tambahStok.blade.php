@extends('admin.layouts.main')

@section('content')

<div class="d-flex justify-content-center align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h4 class="text-center" style="color: #0B773D;">Tambah Stok untuk Produk: {{ $stok->produk->nama }}</h4>
</div>

<div class="row">
  <div class="col-lg-8 col-md-10 mx-auto">
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin-stok.store') }}" method="post">
                @csrf
                <input type="hidden" name="produk_id" value="{{ $stok->produk_id }}">

                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah Stok</label>
                    <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                    name="jumlah" id="jumlah" value="{{ old('jumlah') }}" placeholder="Masukkan jumlah stok" required>
                    @error('jumlah')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">Tambah Stok</button>
                <a href="{{ route('admin-stok.index') }}" class="btn btn-secondary ms-2">Kembali</a>
            </form>
        </div>
    </div>
  </div>
</div>

@endsection
