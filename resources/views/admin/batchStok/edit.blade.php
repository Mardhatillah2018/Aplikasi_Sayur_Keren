@extends('admin.layouts.main')

@section('content')
<div class="d-flex justify-content-center align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2 class="h3 text-center" style="color: #0B773D;">Edit Data BatchStok</h2>
</div>
<div class="row">
    <div class="col-lg-8 col-md-10 mx-auto">
        <div class="card shadow-sm">
            <div class="card-body">
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

                    <button type="submit" class="btn btn-primary" style="background-color: #0B773D; border-color: #0B773D;">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
