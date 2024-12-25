@extends('layouts.main')
@section('content')

<h5 class="mt-5">Produk Terbaru</h5>

<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
        <div class="product-grid row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6">

        @forelse($produks as $produk)
            <div class="col mb-4">
                <div class="product-item position-relative">
                    <figure>
                        <a href="#" title="{{ $produk->nama }}">
                            <img src="{{ asset('images/produk/' . $produk->gambar) }}" class="tab-image img-fluid" alt="{{ $produk->nama }}">
                        </a>
                    </figure>

                    <h3 class="h6">{{ $produk->nama }}</h3>

                    <div style="display: flex; flex-direction: column; gap: 5px;">
                        <p style="margin: 0; line-height: normal; font-size: 12px; color: #666;">{{ $produk->keterangan }}</p>

                        @if(isset($produk->stok))
                            @if($produk->stok->jumlah > 0)
                                {{-- <span class="qty" style="line-height: normal; font-size: 12px; color: #0B773D;">
                                    Stok: {{ $produk->stok->jumlah }}
                                </span> --}}
                            @else
                                <span class="qty" style="line-height: normal; font-size: 12px; color: red; font-weight: bold;">
                                    Habis
                                </span>
                            @endif
                        @else
                            <span class="qty" style="line-height: normal; font-size: 12px; color: red; font-weight: bold;">
                                Stok tidak tersedia
                            </span>
                        @endif
                    </div>

                    <span class="price" style="font-size: 14px;">Rp {{ number_format($produk->harga, 2) }}</span>

                    <div class="d-flex align-items-center justify-content-between">
                        <div class="input-group product-qty" data-stock="{{ $produk->stok->jumlah ?? 0 }}">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus"
                                    @if(!Auth::check() || (isset($produk->stok) && $produk->stok->jumlah == 0))
                                        data-bs-toggle="modal" data-bs-target="#loginModal"
                                    @endif
                                    @if(isset($produk->stok) && $produk->stok->jumlah == 0)
                                        disabled
                                    @endif>
                                    <i class="bi bi-dash"></i>
                                </button>
                            </span>
                            <span id="quantity-display-{{ $produk->id }}" class="form-control input-number text-center">1</span>
                            <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus"
                                    data-max-stock="{{ $produk->stok->jumlah ?? 0 }}"
                                    @if(!Auth::check())
                                        data-bs-toggle="modal" data-bs-target="#loginModal"
                                    @else
                                        @if(isset($produk->stok) && $produk->stok->jumlah == 0)
                                            disabled
                                        @endif
                                    @endif>
                                    <i class="bi bi-plus"></i>
                                </button>
                            </span>
                        </div>

                        <form action="{{ route('keranjangs.store') }}" method="POST" class="d-inline" id="form-{{ $produk->id }}" onsubmit="return addToCart(event, {{ $produk->id }})">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <input type="hidden" name="jumlah" value="1" class="jumlah-input" id="jumlah-{{ $produk->id }}">
                            <button type="submit" class="nav-link text-green fs-6"
                                @if(!Auth::check() || (isset($produk->stok) && $produk->stok->jumlah == 0))
                                    data-bs-toggle="modal" data-bs-target="#loginModal"
                                @endif
                                @if(isset($produk->stok) && $produk->stok->jumlah == 0)
                                    style="pointer-events: none; color: grey;"
                                @else
                                    style="color: #07582d;"
                                @endif
                            >
                                <span class="small-text">+Keranjang</span>
                            </button>

                        </form>

                    </div>
                </div>
            </div>
        @empty
            <p class="text-center" style="color: red">Produk tidak tersedia</p>
        @endforelse

        </div>
    </div>
</div>

<!-- Modal untuk Login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Silahkan Masuk Terlebih Dahulu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Anda harus masuk untuk menambahkan produk ke keranjang.
            </div>
            <div class="modal-footer">
                <a href="/login" class="btn btn-success">Masuk</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Konfirmasi -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Berhasil Menambahkan Produk ke Keranjang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <a href="/keranjang" class="btn btn-success">Lihat Keranjang</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Lanjut Belanja</button>
            </div>
        </div>
    </div>
</div>

<script>
    function addToCart(event, productId) {
        event.preventDefault();
        const form = document.getElementById(`form-${productId}`);

        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            }
        })
        .then(response => {
            if (response.ok) {
                const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
                confirmModal.show();
            } else {
                alert('Gagal menambahkan produk ke keranjang.');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    const minusButtons = document.querySelectorAll('.quantity-left-minus');
    const plusButtons = document.querySelectorAll('.quantity-right-plus');

    minusButtons.forEach(button => {
        button.addEventListener('click', function() {
            const quantityDisplay = button.closest('.input-group').querySelector('span[id^="quantity-display-"]');
            let quantity = parseInt(quantityDisplay.innerText);

            if (quantity > 1) {
                quantity--;
                quantityDisplay.innerText = quantity;
                const productId = quantityDisplay.id.split('-')[2];
                document.getElementById(`jumlah-${productId}`).value = quantity;
            }
        });
    });

    plusButtons.forEach(button => {
        button.addEventListener('click', function() {
            const quantityDisplay = button.closest('.input-group').querySelector('span[id^="quantity-display-"]');
            let quantity = parseInt(quantityDisplay.innerText);
            const maxStock = parseInt(button.getAttribute('data-max-stock'));

            if (quantity < maxStock) {
                quantity++;
                quantityDisplay.innerText = quantity;
                const productId = quantityDisplay.id.split('-')[2];
                document.getElementById(`jumlah-${productId}`).value = quantity;
            }
        });
    });
</script>

@endsection
