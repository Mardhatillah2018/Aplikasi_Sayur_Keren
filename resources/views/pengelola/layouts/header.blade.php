<header class="navbar fixed-top flex-md-nowrap p-0 shadow" style="background-color: #EDF3F2;" data-bs-theme="hijau">
    <a href="/dashboard" class="navbar-brand">
        <img src="{{ asset('images/sayurkeren.png') }}" alt="Sayur Keren" class="img-fluid navbar-image">
    </a>

    <ul class="navbar-nav flex-row d-md-none">
        <li class="nav-item text-nowrap">
            <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <svg class="bi"><use xlink:href="#list"/></svg>
            </button>
        </li>
    </ul>

    <ul class="navbar-nav ms-auto d-flex align-items-center">
        <li class="nav-item dropdown px-3">
            @if (session('username')) <!-- Periksa apakah username ada di session -->
                <div class="header-right">
                    <!-- Tombol untuk Notifikasi -->
                    <button class="btn btn-link text-decoration-none px-4" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifications">
                        <i class="bi bi-bell-fill"></i>
                    </button>
                    <span class="me-2">
                        <i class="bi bi-person-fill" style="color: #07582d;" title="Akun"></i> {{ session('username') }}
                    </span>

                    <!-- Tombol Logout -->
                    <form action="/logout" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-logout">
                            <i class="bi bi-power"></i> Keluar
                        </button>
                    </form>
                </div>
            @else
                <button class="btn-login" style="border-color: #07582d; transition: background-color 0.3s, color 0.3s;" onclick="window.location.href='/login';">
                    <i class="bi bi-person-fill"></i> Login
                </button>
            @endif
        </li>
    </ul>
</header>
