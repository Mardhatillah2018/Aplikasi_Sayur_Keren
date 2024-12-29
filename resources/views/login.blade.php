@extends('layouts.main')

@section('content')
<section class="vh-80 mt-5">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg rounded" style="border: none;">
                    <div class="card-body text-center">
                        <img src="{{ asset('images/sayurkeren.png') }}" class="img-fluid mb-1" alt="Sample image" style="width: 45%">
                        <div style="height: 1px; background-color: #0B773D; width: 50%; margin: 10px auto;"></div>
                        <h4 class="mt-1" style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #0B773D;">MASUK</h4>
                        @if (session('pesan'))
                            <div class="alert alert-success">
                                {{ session('pesan') }}
                            </div>
                        @endif
                        <form method="POST" action="/login">
                            @csrf

                            <div class="form-floating mb-2">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="floatingInput" placeholder="name@example.com" value="{{ old('email') }}">
                                <label for="floatingInput">Email</label>
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-floating mb-2">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" name="password" placeholder="Password">
                                <label for="floatingPassword">Kata Sandi</label>
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-check text-start my-3">
                                <input class="form-check-input" type="checkbox" name="remember" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Ingatkan saya
                                </label>
                            </div>
                            <button class="btn w-100 py-2" type="submit" style="background-color: #0B773D; border-color: #0B773D; color: white;">Masuk</button>
                            <div class="text-center">Belum punya akun? <a href="/register" style="color: #0B773D;">Daftar</a></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
</section>
@endsection
