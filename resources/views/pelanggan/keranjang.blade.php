@extends('layouts.main')

@section('content')
<section class="vh-80 mt-5">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-10 col-lg-8 mb-4">
                <div class="card shadow-lg rounded" style="border: none;">
                    <div class="card-body">
                        <div class="table-responsive">
                        <h4 class="mt-1 text-center" style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #0B773D; font-size: 1rem;">Keranjang Belanja</h4>
                        <table class="table mt-4">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center" style="font-size: 0.875rem;">Produk</th>
                                    <th scope="col" class="text-center" style="font-size: 0.875rem;">Jumlah</th>
                                    <th scope="col" class="text-center" style="font-size: 0.875rem;">Harga</th>
                                    <th scope="col" class="text-center" style="font-size: 0.875rem;">Total</th>
                                    <th scope="col" class="text-center" style="font-size: 0.875rem;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($keranjangs as $keranjang)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('images/produk/' . $keranjang->produk->gambar) }}" alt="{{ $keranjang->produk->nama }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                                <div class="ms-3">
                                                    <h6 class="mb-0" style="font-size: 0.875rem;">{{ $keranjang->produk->nama }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center" style="font-size: 0.875rem;">{{ $keranjang->jumlah }}</td>
                                        <td class="text-center" style="font-size: 0.875rem;">Rp {{ number_format($keranjang->harga, 2) }}</td>
                                        <td class="text-center" style="font-size: 0.875rem;">Rp {{ number_format($keranjang->jumlah * $keranjang->harga, 2) }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('keranjangs.destroy', $keranjang->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button title="Hapus Produk" type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin menghapus produk ini dari keranjang?')" style="font-size: 0.75rem;"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        <div class="text-end">
                            <h5 style="font-size: 0.875rem; font-weight: bold">Total: Rp {{ number_format($totalHarga, 0, ',', '.') }}</h5>
                        </div>
                        <div class="text-center mt-4">
                            @if($keranjangs->isEmpty()) <!-- Jika keranjang kosong -->
                                <a href="/semuaproduk" class="btn w-100 py-2"
                                   style="background-color: #0B773D; border-color: #0B773D; color: white; font-size: 0.875rem;">
                                    Tambah Belanja
                                </a>
                            @else <!-- Jika keranjang ada isi -->
                                <a href="/checkout" class="btn w-100 py-2"
                                   style="background-color: #0B773D; border-color: #0B773D; color: white; font-size: 0.875rem;">
                                    Checkout
                                </a>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
