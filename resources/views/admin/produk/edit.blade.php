@extends('admin.layouts.main')

@section('content')
<div class="d-flex justify-content-center align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2 class="h3 text-center" style="color: #0B773D;">Edit Data Produk</h2>
</div>
<div class="row">
  <div class="col-lg-8 col-md-10 mx-auto">
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="/admin-produk/{{ $produk->id }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Produk</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                name="nama" id="nama" value="{{ old('nama', $produk->nama) }}" placeholder="Nama Produk">
                @error('nama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" step="0.01" class="form-control @error('harga') is-invalid @enderror"
                name="harga" id="harga" value="{{ old('harga', $produk->harga) }}" placeholder="Harga">
                @error('harga')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="masa_tahan" class="form-label">Masa Tahan (hari)</label>
                <input type="number" class="form-control @error('masa_tahan') is-invalid @enderror"
                name="masa_tahan" id="masa_tahan" value="{{ old('masa_tahan', $produk->masa_tahan) }}" placeholder="Masa Tahan">
                @error('masa_tahan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar" id="gambar">

                @if ($produk->gambar)
                    <img src="{{ asset('images/produk/' . $produk->gambar) }}" alt="Gambar Produk" class="img-thumbnail mt-2" width="150">
                @endif

                @error('gambar')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="kategori_id" class="form-label">Kategori</label>
                <select class="form-select" name="kategori_id" id="kategori_id">
                    <option value="">--Pilih Kategori--</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ (old('kategori_id', $produk->kategori_id) == $kategori->id) ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control @error('keterangan') is-invalid @enderror"
                            name="keterangan" id="keterangan" placeholder="Keterangan Produk">{{ old('keterangan', $produk->keterangan) }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">
                    {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="background-color: #0B773D; border-color: #0B773D;">Update</button>
            </form>
            <br>
        </div>
    </div>
  </div>
</div>
@endsection
