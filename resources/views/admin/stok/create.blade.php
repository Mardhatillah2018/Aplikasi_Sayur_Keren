@extends('admin.layouts.main')

@section('content')
<div class="d-flex justify-content-center align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2 class="h3 text-center" style="color: #0B773D;">Input Stok Produk</h2>
</div>

<div class="row">
  <div class="col-lg-8 col-md-10 mx-auto">
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin-stok.store') }}" method="post">
                @csrf

                <div class="mb-3">
                    <label for="produk_id" class="form-label">Produk</label>
                    <select class="form-select @error('produk_id') is-invalid @enderror" name="produk_id" id="produk_id">
                        <option value="">--Pilih Produk--</option>
                        @foreach($produks as $produk)
                            <option value="{{ $produk->id }}" {{ old('produk_id') == $produk->id ? 'selected' : '' }}>{{ $produk->nama }}</option>
                        @endforeach
                    </select>
                    @error('produk_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

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

                <button type="submit" class="btn btn-success">Submit</button>
                <a href="{{ route('admin-stok.index') }}" class="btn btn-secondary ms-2">Kembali</a>
            </form>
        </div>
    </div>
  </div>
</div>

@endsection
