<header class="navbar navbar-expand-lg fixed-top flex-md-nowrap p-0 shadow" style="background-color: #EDF3F2; padding: 0 1rem;" data-bs-theme="hijau">
    <a href="/dashboard" class="navbar-brand">
        <img src="{{ asset('images/sayurkeren.png') }}" alt="Sayur Keren" class="img-fluid navbar-image">
    </a>

    <!-- Konten Navbar -->
    <div class="d-flex flex-grow-1 justify-content-end align-items-center">
        <!-- Konten Navbar Kanan -->
        <ul class="navbar-nav d-flex align-items-center">
            <li class="nav-item">
                @if (session('username')) <!-- Periksa apakah username ada di session -->
                    <div class="header-right d-flex flex-column flex-sm-row align-items-center">
                        <span class="me-2 text-nowrap d-flex align-items-center">
                            <i class="bi bi-person-fill" style="color: #07582d;" title="Akun"></i>
                            <span class="ms-1">{{ session('username') }}</span>
                        </span>

                        <!-- Tombol Logout -->
                        <form action="/logout" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-logout">
                                <i class="bi bi-power"></i> Keluar
                            </button>
                        </form>
                    </div>
                @else
                    <button class="btn-login btn btn-outline-success" style="transition: background-color 0.3s, color 0.3s;" onclick="window.location.href='/login';">
                        <i class="bi bi-person-fill"></i> Login
                    </button>
                @endif
            </li>
        </ul>
    </div>
</header>
