@extends('admin.layouts.main')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Data BatchStok</h1>
</div>

<div class="row">
    <div class="col-6">
        <form action="/admin-batchStok/{{ $batch_stok->id }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="jumlah" class="form-label">Stok</label>
                <input type="text" class="form-control @error('jumlah') is-invalid @enderror"
                       name="jumlah" id="jumlah"
                       value="{{ old('jumlah', $batch_stok->jumlah) }}"
                       placeholder="Jumlah">
                @error('jumlah')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success" style="background-color: #0B773D; border-color: #0B773D;">Update</button>
        </form>
    </div>
</div>
@endsection
