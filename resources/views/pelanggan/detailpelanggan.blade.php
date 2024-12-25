@extends('layouts.main')

@section('content')
<section class="vh-80 mt-5">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <!-- Card Detail Akun -->
            <div class="col-md-12 col-lg-10 mb-4">
                <div class="card shadow-lg rounded" style="border: none;">
                    <div class="card-body">
                        <h4 class="mt-1 text-center" style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #0B773D; font-size: 1.2rem;">Detail Akun</h4>

                        <div class="text-center mb-2">
                            <i class="bi bi-person-fill" style="font-size: 40px; color: #0B773D;"></i>
                            {{-- <h5 style="color: #0B773D;">{{ session('username') }}</h5> --}}
                        </div>

                        <div class="mb-3">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <strong style="font-size: 0.890rem;">Username:</strong>
                                </div>
                                <div class="col-8">
                                    {{ session('username') }}
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <strong style="font-size: 0.890rem;">Email:</strong>
                                </div>
                                <div class="col-8">
                                    {{ session('email') }}
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <strong style="font-size: 0.890rem;">No HP:</strong>
                                </div>
                                <div class="col-8">
                                    {{ session('nohp') }}
                                </div>
                            </div>
                        </div>

                        <div class="text-center mb-3">
                            <!-- Tautan untuk mengarahkan ke halaman edit profil -->
                            <a href="{{ route('edit-profile') }}" class="btn btn-sm" style="background-color: #0B773D; border-color: #0B773D; color: white;">Edit Profil</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Keranjang Belanja Anda -->
            <div class="col-md-12 col-lg-10 mb-4">
                <div class="card shadow-lg rounded" style="border: none;">
                    <div class="card-body">
                        <h4 class="mt-1 text-center" style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #0B773D; font-size: 1.2rem;">Keranjang Belanja Anda</h4>
                        <div class="text-center mb-4">
                            <i class="bi bi-cart-fill" style="font-size: 50px; color: #0B773D;"></i>
                        </div>

                        @if(session('keranjangs') && !session('keranjangs')->isEmpty())
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="font-size: 0.890rem;">No</th>
                                        <th class="text-center" style="font-size: 0.890rem;">Produk</th>
                                        <th class="text-center" style="font-size: 0.890rem;">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(session('keranjangs') as $index => $keranjang)
                                        <tr>
                                            <td style="font-size: 0.890rem;">{{ $index + 1 }}</td>
                                            <td style="font-size: 0.890rem;">{{ $keranjang->produk->nama }}</td>
                                            <td style="font-size: 0.890rem;" >{{ $keranjang->jumlah }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center">
                                <p style="color: #0B773D;">Anda belum menambahkan produk ke keranjang.</p>
                            </div>
                        @endif

                        <div class="text-center mb-3">
                            <a href="/semuaproduk" class="btn btn-sm" style="background-color: #0B773D; border-color: #0B773D; color: white;">Tambah</a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- <!-- Modal Edit Profil -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update-profile') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ session('username') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ session('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="nohp" class="form-label">No HP</label>
                            <input type="text" class="form-control" id="nohp" name="nohp" value="{{ session('nohp') }}" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    <br>
</section>
@endsection
