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

    <ul class="navbar-nav">
    <li class="nav-item dropdown px-3">
        @if (session('username')) <!-- Periksa apakah username ada di session -->
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #07582d; font-size: 16px; text-decoration: none;">
                <i class="bi bi-person-fill me-2"></i>{{ session('username') }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li>
                    <form action="/logout" method="POST" class="dropdown-item" style="margin: 0; padding: 0;">
                        @csrf
                        <button type="submit" class="btn btn-link text-decoration-none" style="color: #07582d; padding: 0;">
                            <i class="bi bi-door-open me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        @else
            <button class="btn-login" style="border-color: #07582d; transition: background-color 0.3s, color 0.3s;" onclick="window.location.href='/login';">
                <i class="bi bi-person-fill"></i> Login
            </button>
        @endif
    </li>
</ul>

</header>
