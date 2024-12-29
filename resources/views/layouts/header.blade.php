<header class="header-custom">
    <div class="top-header">
        <div class="container">
            <div class="d-none d-md-block ms-3">
                <a href="https://wa.me/6281244323035" class="text-success d-flex align-items-center" target="_blank">
                    <i class="fab fa-whatsapp" style="font-size: 20px;"></i>
                    <span class="ms-2" style="font-size: 16px;">WhatsApp</span>
                </a>
            </div>
            <div class="header-right">
                @if (session('username'))
                    <a href="/detailpelanggan" style="color: #07582d; font-size: 16px; text-decoration: none;">
                        <span class="me-2">
                            <i class="bi bi-person-fill" style="color: #07582d;" title="Akun"></i> {{ session('username') }}
                        </span>
                    </a>
                    <form action="/logout" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-logout"><i class="bi bi-power"></i>Keluar</button>
                    </form>
                @else
                    <button class="btn-login" style="border-color: #07582d; transition: background-color 0.3s, color 0.3s;" onclick="window.location.href='/login';">
                        <i class="bi bi-person-fill"></i> Login
                    </button>
                @endif
            </div>
        </div>
    </div>

    <div class="main-header">
        <div class="container">
            <div class="logo">
                <a href="/">
                    <img src="{{ asset('images/sayurkeren.png') }}" alt="Sayur Keren" class="img-fluid" title="Home">
                </a>
            </div>
            <nav class="main-nav d-none d-md-block">
                <ul>
                    <li><a href="/semuaproduk" class="{{ Request::is('semuaproduk') ? 'active' : '' }}">SEMUA PRODUK</a></li>
                    <li><a href="/terbaru" class="{{ Request::is('terbaru') ? 'active' : '' }}">TERBARU</a></li>
                    <li><a href="/tentang" class="{{ Request::is('tentang') ? 'active' : '' }}">TENTANG</a></li>
                </ul>
            </nav>
            <div class="header-icons">
                <form action="{{ route('semuaproduk') }}" method="GET" class="d-flex align-items-center d-none d-md-flex"> <!-- Form hanya untuk Desktop -->
                    <input type="text" name="search" class="form-control ms-3" placeholder="Cari produk..." value="{{ request('search') }}">
                    <button type="submit" class="btn ms-2" style="background-color: #07582d; border-color: #07582d; color: #ffffff;">
                        <i class="bi bi-search"></i>
                    </button>
                </form>

                @if(session('username'))
                    <a href="{{ url('/keranjang') }}" title="Keranjang">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                    <a href="{{ url('/riwayat-belanja') }}" title="Riwayat Belanja" class="ms-3 {{ Request::is('riwayat-belanja') ? 'active' : '' }}">
                        <i class="fas fa-history"></i>
                    </a>
                @else
                    <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                @endif

                <!-- Ikon pencarian hanya untuk tampilan mobile -->
                <button class="btn ms-2 d-md-none" data-bs-toggle="modal" data-bs-target="#searchModal" style="background-color: #07582d; border-color: #07582d; color: #ffffff;">
                    <i class="bi bi-search"></i>
                </button>
            </div>

            <!-- Button untuk membuka menu Offcanvas -->
            <button class="btn btn-menu d-md-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                <i class="bi bi-list"></i> <!-- Icon tiga titik -->
            </button>
        </div>
    </div>
</header>

<!-- Modal untuk Pencarian -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchModalLabel">Cari Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('semuaproduk') }}" method="GET" class="d-flex align-items-center">
                    <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}">
                    <button type="submit" class="btn ms-2" style="background-color: #07582d; border-color: #07582d; color: #ffffff;">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Offcanvas Menu -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="list-unstyled">
            <li><a href="/semuaproduk" class="nav-link {{ Request::is('semuaproduk') ? 'active' : '' }}">SEMUA PRODUK</a></li>
            <li><a href="/terbaru" class="nav-link {{ Request::is('terbaru') ? 'active' : '' }}">TERBARU</a></li>
            <li><a href="/tentang" class="nav-link {{ Request::is('tentang') ? 'active' : '' }}">TENTANG</a></li>
            <li class="mt-3">
                @if(session('username'))
                    <a href="{{ url('/keranjang') }}" class="nav-link" title="Keranjang">
                        <i class="fas fa-shopping-cart"></i> Keranjang
                    </a>
                    <a href="{{ url('/riwayat-belanja') }}" class="nav-link" title="Riwayat Belanja">
                        <i class="fas fa-history"></i> Riwayat Belanja
                    </a>
                @else
                    <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" class="nav-link">
                        <i class="fas fa-shopping-cart"></i> Keranjang
                    </a>
                    <a href="/login" class="btn btn-success mt-3">Login</a>
                @endif
            </li>
        </ul>
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

<!-- Tambahkan CSS berikut ini -->
<style>
    /* Offcanvas background color */
    .offcanvas {
        background-color: #f8f9fa; /* Warna latar belakang Offcanvas */
    }

    /* Hover effect for links inside Offcanvas */
    .offcanvas-body .nav-link {
        padding: 10px 15px; /* Padding untuk link */
        border-radius: 5px; /* Sudut membulat */
        transition: background-color 0.3s, color 0.3s; /* Transisi halus */
    }

    .offcanvas-body .nav-link:hover {
        color: #07582d;  /* Warna hijau Sayur Keren */
        background-color: #d8f5e6;  /* Background hijau muda saat hover */
    }

    /* Active state for clicked links */
    .offcanvas-body .nav-link.active {
        color: #fff;
        background-color: #07582d; /* Background hijau gelap saat link aktif */
    }

    /* Menghapus efek focus agar tidak ada border atau titik */
    .offcanvas-body .nav-link:focus {
        outline: none; /* Menghilangkan outline */
        box-shadow: none; /* Menghilangkan efek box-shadow */
    }

    /* Styling untuk judul Offcanvas */
    .offcanvas-header {
        background-color: #07582d; /* Warna latar belakang header */
        color: white; /* Warna teks header */
    }

    /* Styling untuk tombol close */
    .btn-close {
        filter: invert(1); /* Membuat tombol close berwarna putih */
    }

    /* style untuk list */
    .offcanvas-body ul {
        padding-left: 0; /* Menghapus padding default */
    }
</style>
