<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Sayur Keren - Belanja Bahan Makanan Segar dan Olahan</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        .content-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 100px); /* Sesuaikan tinggi viewport, dikurangi margin header */
            margin-top: 100px; /* Untuk jarak antara header dan konten */
        }

        .content {
            max-width: 800px; /* Sesuaikan lebar konten */
            width: 100%; /* Agar responsif */
            text-align: center; /* Konten rata tengah */
        }

        .container-custom {
    margin: 0 auto; /* Mengatur margin agar berada di tengah */
    padding: 0 15px; /* Menambahkan padding untuk mencegah konten menempel ke tepi */
}

.card-custom {
    margin: 0;
    padding: 0;
}


    .table-custom {
        width: 100%; /* Ensure the table takes full width */
    }

    .table-custom th,
    .table-custom td {
        white-space: nowrap; /* Prevent text from wrapping */
    }
    </style>

    <!-- Custom styles for this template -->
    <link href="/css/styleadmin.css" rel="stylesheet">
</head>

<body>
    @include('pengelola.layouts.header')

    <div class="content-wrapper">
        <main class="content">
            @yield('content')
        </main>
    </div>

    <script src="/js/bootstrap.bundle.min.js"></script>
</body>

</html>
