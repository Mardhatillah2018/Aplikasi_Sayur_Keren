@extends('admin.layouts.main')

@section('content')
<div class="d-flex justify-content-center align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2 class="h3 text-center" style="color: #0B773D;">Edit Data Pengelola Pesanan</h2>
</div>
<div class="row">
  <div class="col-lg-8 col-md-10 mx-auto">
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="/admin-pengelola/{{ $pengelola->id }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="username" class="form-label">Nama Pengelola</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" value="{{ old('username', $pengelola->username)}}" placeholder="Nama Pengelola">
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ $pengelola->email }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="nohp" class="form-label">No HP</label>
                    <input type="text" class="form-control @error('nohp') is-invalid @enderror" name="nohp" id="nohp" value="{{ old('nohp', $pengelola->nohp) }}" placeholder="No HP">
                    @error('nohp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100" style="background-color: #0B773D; border-color: #0B773D;">Submit</button>
            </form>
        </div>
    </div>
  </div>
</div>
@endsection
