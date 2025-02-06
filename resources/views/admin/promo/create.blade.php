@extends('admin.layouts.main')

@section('content')
<div class="d-flex justify-content-center align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2 class="h3 text-center" style="color: #0B773D;">Input Data Promo</h2>
</div>
<div class="row">
  <div class="col-lg-8 col-md-10 mx-auto">
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="/admin-promo" method="post">
                @csrf

                <!-- Nama Promo -->
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Promo</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                    name="nama" id="nama" value="{{ old('nama') }}" placeholder="Nama Promo">
                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Deskripsi Promo -->
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Promo</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                    name="deskripsi" id="deskripsi" rows="3" placeholder="Deskripsi Promo">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Diskon -->
                <div class="mb-3">
                    <label for="diskon" class="form-label">Diskon (%)</label>
                    <input type="number" class="form-control @error('diskon') is-invalid @enderror"
                    name="diskon" id="diskon" value="{{ old('diskon') }}" placeholder="Diskon dalam persen">
                    @error('diskon')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Tanggal Mulai -->
                <div class="mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                    <input type="datetime-local" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                    name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}">
                    @error('tanggal_mulai')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Tanggal Berakhir -->
                <div class="mb-3">
                    <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir</label>
                    <input type="datetime-local" class="form-control @error('tanggal_berakhir') is-invalid @enderror"
                    name="tanggal_berakhir" id="tanggal_berakhir" value="{{ old('tanggal_berakhir') }}">
                    @error('tanggal_berakhir')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="/admin-promo" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>
@endsection
