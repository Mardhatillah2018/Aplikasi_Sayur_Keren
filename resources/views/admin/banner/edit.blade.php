@extends('admin.layouts.main')

@section('content')
<div class="d-flex justify-content-center align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2 class="h3 text-center" style="color: #0B773D;">Edit Data Banner</h2>
</div>
<div class="row">
  <div class="col-lg-8 col-md-10 mx-auto">
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="/admin-banner/{{ $banner->id }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="gambar_banner" class="form-label">Gambar Banner</label>
                    <input type="file" class="form-control @error('gambar_banner') is-invalid @enderror" name="gambar_banner" id="gambar_banner">
                    @if ($banner->gambar_banner)
                            <img src="{{ asset('images/bannerSlide/' . $banner->gambar_banner) }}" alt="Gambar Banner" class="img-thumbnail mt-2" width="150">
                        @endif
                    @error('gambar_banner')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary" style="background-color: #0B773D; border-color: #0B773D;">Submit</button>
            </form>
        </div>
    </div>
  </div>
</div>
@endsection
