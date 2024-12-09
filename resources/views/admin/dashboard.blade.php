<link rel="stylesheet" type="text/css" href="css/dashboard.css">
<script src="js/scripts.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.12.1/css/pro.min.css">
@extends('admin.layouts.main')

@section('content')

  <!-- strat content -->
  <div class="bg-gray-100 flex-1 p-6 md:mt-16">

    @if (session('username')) <!-- Periksa apakah username ada di session -->
        <a href="" style="color: #07582d; font-size: 20px; text-decoration: none;">
            <span class="me-2" style="font-size: 24px; font-weight: bold;"> <!-- Memperbesar ukuran teks -->
                Selamat Datang,
                <span style="font-size: 24px; font-weight: bold;"> <!-- Memperbesar username -->
                    {{ session('username') }}
                </span>
            </span>
        </a>
        <br>
        <!-- Menambahkan jarak antara teks dan card -->
        <div style="margin-top: 20px;"></div>
    @else
        <button class="btn-login" style="border-color: #07582d; transition: background-color 0.3s, color 0.3s;" onclick="window.location.href='/login';">
            <i class="bi bi-person-fill"></i> Login
        </button>
    @endif

    <!-- General Report -->
    <div class="grid grid-cols-4 gap-6 xl:grid-cols-1">
        <!-- Card untuk jumlah kategori -->
        <div class="report-card">
            <a href="{{ route('admin-kategori.index') }}" class="text-decoration-none">
                <div class="card">
                    <div class="card-body flex flex-col">
                        <!-- top -->
                        <div class="d-flex justify-between align-items-center">
                            <!-- Ikon kategori di sebelah kiri -->
                            <div class="px-3 py-2 rounded bg-green-600 text-white mr-3">
                                <i class="fad fa-th-large"></i> <!-- Ikon kategori -->
                            </div>
                            <!-- Jumlah kategori dan tulisan di sebelah kanan -->
                            <div class="text-end">
                                <h1 class="h3 num-4">
                                    {{ $jumlahKategori }}
                                </h1>
                                <p style="color: #07582d;">Jumlah Kategori</p> <!-- Tulisan jumlah kategori dengan warna #07582d -->
                            </div>
                        </div>
                        <!-- end top -->
                    </div>
                </div>
            </a>
            <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
        </div>

            <!-- Card untuk jumlah produk -->
            <div class="report-card">
                <a href="{{ route('admin-produk.index') }}" class="text-decoration-none">
                    <div class="card">
                        <div class="card-body flex flex-col">
                            <!-- top -->
                            <div class="d-flex justify-between align-items-center">
                                <!-- Ikon produk atau keranjang di sebelah kiri -->
                                <div class="px-3 py-2 rounded bg-yellow-600 text-white mr-3">
                                    <i class="fas fa-carrot"></i> <!-- Ikon produk atau kotak -->
                                </div>
                                <!-- Jumlah produk dan tulisan di sebelah kanan -->
                                <div class="text-end">
                                    <h1 class="h3 num-4">
                                        {{ $jumlahProduk }}
                                    </h1>
                                    <p style="color: #07582d;">Jumlah Produk</p> <!-- Tulisan jumlah produk dengan warna #07582d -->
                                </div>
                            </div>
                            <!-- end top -->
                        </div>
                    </div>
                </a>
                <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
            </div>
            <!-- Card untuk jumlah pelanggan -->
<div class="report-card">
    <a href="{{ route('admin.admin-pelanggan.index') }}" class="text-decoration-none">
        <div class="card">
            <div class="card-body flex flex-col">
                <!-- top -->
                <div class="d-flex justify-between align-items-center">
                    <!-- Ikon pelanggan di sebelah kiri -->
                    <div class="px-3 py-2 rounded bg-pink-600 text-white mr-3">
                        <i class="fad fa-users"></i> <!-- Ikon produk atau kotak -->
                    </div>
                    <!-- Jumlah pelanggan dan tulisan di sebelah kanan -->
                    <div class="text-end">
                        <h1 class="h3 num-4">
                            {{ $jumlahPelanggan }}
                        </h1>
                        <p style="color: #07582d;">Jumlah Pelanggan</p>
                    </div>
                </div>
                <!-- end top -->
            </div>
        </div>
    </a>
    <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
</div>

<!-- Card untuk jumlah pesanan diproses -->
<div class="report-card">
    <a href="#" class="text-decoration-none">
        <div class="card">
            <div class="card-body flex flex-col">
                <!-- top -->
                <div class="d-flex justify-between align-items-center">
                    <!-- Ikon pesanan diproses di sebelah kiri -->
                    <div class="px-3 py-2 rounded text-white mr-3" style="background-color: #007bff;">
                        <i class="fas fa-spinner fa-spin"></i> <!-- Ikon produk atau kotak -->
                    </div>
                    <!-- Jumlah pesanan diproses dan tulisan di sebelah kanan -->
                    <div class="text-end">
                        <h1 class="h3 num-4">
                            {{ $jumlahPesananDiproses }}
                        </h1>
                        <p style="color: #07582d;">Pesanan Diproses</p>
                    </div>
                </div>
                <!-- end top -->
            </div>
        </div>
    </a>
    <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
</div>

    </div>
    <!-- End General Report -->

    <!-- strat Analytics -->
    <div class="mt-6 grid grid-cols-2 gap-6 xl:grid-cols-1">

    <!-- update section -->
    <div class="card bg-teal-400 border-teal-400 shadow-md text-white">
        <div class="card-body flex flex-row">

            <!-- image -->
            <div class="img-wrapper w-40 h-40 flex justify-center items-center">
                <img src="./img/happy.svg" alt="img title">
            </div>
            <!-- end image -->

            <!-- info -->
            <div class="py-2 ml-10">
                <h1 class="h6">Good Job, Mohamed!</h1>
                <p class="text-white text-xs">You've finished all of your tasks for this week.</p>

                <ul class="mt-4">
                    <li class="text-sm font-light"><i class="fad fa-check-double mr-2 mb-2"></i> Finish Dashboard Design</li>
                    <li class="text-sm font-light"><i class="fad fa-check-double mr-2 mb-2"></i> Fix Issue #74</li>
                    <li class="text-sm font-light"><i class="fad fa-check-double mr-2"></i> Publish version 1.0.6</li>
                </ul>
            </div>
            <!-- end info -->

        </div>
    </div>
    <!-- end update section -->

    <!-- carts -->
    <div class="flex flex-col">

        <!-- alert -->
        <div class="alert alert-dark mb-6">
            Hi! Wait A Minute . . . . . . Follow Me On Twitter
            <a class="ml-2" target="_blank" href="https://twitter.com/MohamedSaid__">@moesaid</a>
        </div>
        <!-- end alert -->

        <!-- charts -->
        <div class="grid grid-cols-2 gap-6 h-full">

            <div class="card">
                <div class="py-3 px-4 flex flex-row justify-between">
                    <h1 class="h6">
                        <span class="num-4"></span>k
                        <p>page view</p>
                    </h1>

                    <div class="bg-teal-200 text-teal-700 border-teal-300 border w-10 h-10 rounded-full flex justify-center items-center">
                        <i class="fad fa-eye"></i>
                    </div>
                </div>
                <div class="analytics_1"></div>
            </div>

            <div class="card">
                <div class="py-3 px-4 flex flex-row justify-between">
                    <h1 class="h6">
                        <span class="num-2"></span>k
                        <p>Unique Users</p>
                    </h1>

                    <div class="bg-indigo-200 text-indigo-700 border-indigo-300 border w-10 h-10 rounded-full flex justify-center items-center">
                        <i class="fad fa-users-crown"></i>
                    </div>
                </div>
                <div class="analytics_1"></div>
            </div>

        </div>
        <!-- charts    -->

    </div>
    <!-- end charts -->


</div>
    <!-- end Analytics -->

    <!-- Sales Overview -->
    <div class="card mt-6">

    <!-- header -->
    <div class="card-header flex flex-row justify-between">
        <h1 class="h6">Sales Overview</h1>

        <div class="flex flex-row justify-center items-center">

            <a href="">
                <i class="fad fa-chevron-double-down mr-6"></i>
            </a>

            <a href="">
                <i class="fad fa-ellipsis-v"></i>
            </a>

        </div>

    </div>
    <!-- end header -->

    <!-- body -->
    <div class="card-body grid grid-cols-2 gap-6 lg:grid-cols-1">

        <div class="p-8">
            <h1 class="h2">5,337</h1>
            <p class="text-black font-medium">Sales this month</p>

            <div class="mt-20 mb-2 flex items-center">
                <div class="py-1 px-3 rounded bg-green-200 text-green-900 mr-3">
                    <i class="fa fa-caret-up"></i>
                </div>
                <p class="text-black"><span class="num-2 text-green-400"></span><span class="text-green-400">% more sales</span> in comparison to last month.</p>
            </div>

            <div class="flex items-center">
                <div class="py-1 px-3 rounded bg-red-200 text-red-900 mr-3">
                    <i class="fa fa-caret-down"></i>
                </div>
                <p class="text-black"><span class="num-2 text-red-400"></span><span class="text-red-400">% revenue per sale</span> in comparison to last month.</p>
            </div>

            <a href="#" class="btn-shadow mt-6">view details</a>

        </div>

        <div class="">
            <div id="sealsOverview"></div>
        </div>

    </div>
    <!-- end body -->

</div>
    <!-- end Sales Overview -->

    <!-- start numbers -->
    <div class="grid grid-cols-5 gap-6 xl:grid-cols-2">

    <!-- card -->
    <div class="card mt-6">
        <div class="card-body flex items-center">

            <div class="px-3 py-2 rounded bg-indigo-600 text-white mr-3">
                <i class="fad fa-wallet"></i>
            </div>

            <div class="flex flex-col">
                <h1 class="font-semibold"><span class="num-2"></span> Sales</h1>
                <p class="text-xs"><span class="num-2"></span> payments</p>
            </div>

        </div>
    </div>
    <!-- end card -->

    <!-- card -->
    <div class="card mt-6">
        <div class="card-body flex items-center">

            <div class="px-3 py-2 rounded bg-green-600 text-white mr-3">
                <i class="fad fa-shopping-cart"></i>
            </div>

            <div class="flex flex-col">
                <h1 class="font-semibold"><span class="num-2"></span> Orders</h1>
                <p class="text-xs"><span class="num-2"></span> items</p>
            </div>

        </div>
    </div>
    <!-- end card -->

    <!-- card -->
    <div class="card mt-6 xl:mt-1">
        <div class="card-body flex items-center">

            <div class="px-3 py-2 rounded bg-yellow-600 text-white mr-3">
                <i class="fad fa-blog"></i>
            </div>

            <div class="flex flex-col">
                <h1 class="font-semibold"><span class="num-2"></span> posts</h1>
                <p class="text-xs"><span class="num-2"></span> active</p>
            </div>

        </div>
    </div>
    <!-- end card -->

    <!-- card -->
    <div class="card mt-6 xl:mt-1">
        <div class="card-body flex items-center">

            <div class="px-3 py-2 rounded bg-red-600 text-white mr-3">
                <i class="fad fa-comments"></i>
            </div>

            <div class="flex flex-col">
                <h1 class="font-semibold"><span class="num-2"></span> comments</h1>
                <p class="text-xs"><span class="num-2"></span> approved</p>
            </div>

        </div>
    </div>
    <!-- end card -->

    <!-- card -->
    <div class="card mt-6 xl:mt-1 xl:col-span-2">
        <div class="card-body flex items-center">

            <div class="px-3 py-2 rounded bg-pink-600 text-white mr-3">
                <i class="fad fa-user"></i>
            </div>

            <div class="flex flex-col">
                <h1 class="font-semibold"><span class="num-2"></span> memebrs</h1>
                <p class="text-xs"><span class="num-2"></span> online</p>
            </div>

        </div>
    </div>
    <!-- end card -->

</div>
    <!-- end nmbers -->

    <!-- start quick Info -->
    <div class="grid grid-cols-3 gap-6 mt-6 xl:grid-cols-1">




</div>
    <!-- end quick Info -->


  </div>
  <!-- end content -->

@endsection


