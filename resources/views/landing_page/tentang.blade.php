@extends('layouts.main')
@section('content')
<br>
<h4 class="text-center mt-4"><b>Mengapa Harus Belanja di Sayur Keren?</b></h4>

<div class="row mt-4">
    <div class="col-md-4 col-sm-6 col-12 mb-3">
        <div class="card hover-card">
            <div class="img-container">
                <img src="/images/tentang/tentang1.png" class="card-img-top" alt="Produk Segar Berkualitas">
            </div>
            <div class="card-body text-center">
                <h5 class="card-title">Produk Segar Berkualitas</h5>
                <p class="card-text">Sayur Keren menyediakan berbagai produk segar, seperti sayuran, buah, dan bahan olahan berkualitas tinggi, yang dipilih langsung dari pemasok terpercaya untuk memastikan kesegaran dan kesehatan setiap saat.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-12 mb-3">
        <div class="card hover-card">
            <div class="img-container">
                <img src="/images/tentang/tentang2.png" class="card-img-top" alt="Mudah dan Praktis">
            </div>
            <div class="card-body text-center">
                <h5 class="card-title">Mudah & Praktis</h5>
                <p class="card-text">Belanja kebutuhan sehari-hari jadi lebih mudah hanya dengan beberapa klik. Kami mengirimkan pesanan langsung ke alamat Anda, membuat belanja praktis dan efisien tanpa perlu keluar rumah.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-12 mb-3">
        <div class="card hover-card">
            <div class="img-container">
                <img src="/images/tentang/tentang3.png" class="card-img-top" alt="Harga Kompetitif dan Promo Menarik">
            </div>
            <div class="card-body text-center">
                <h5 class="card-title">Hemat & Promo Menarik</h5>
                <p class="card-text">Menawarkan harga kompetitif untuk produk segar dan olahan, serta promo menarik. Anda bisa menikmati penawaran terbaik tanpa khawatir kualitas, menjadikan belanja di Sayur Keren pilihan hemat.</p>
            </div>
        </div>
    </div>
</div>
<br>
<style>
    .hover-card {
        border: 1px solid #0e6336; /* Garis hijau di tepi card */
        transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        background-color: #ffffff; /* Warna asli card */
    }

    .hover-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        background-color: #0e6336; /* Warna border saat hover */
        color: #ffffff; /* Warna teks saat hover */
    }

    .hover-card:hover .card-title,
    .hover-card:hover .card-text {
        color: #ffffff; /* Warna teks menjadi putih saat hover */
    }

    .card-title {
        font-size: 1.3rem; /* Ukuran judul lebih besar */
        font-weight: bold;
    }

    .card-text {
        font-size: 0.8rem; /* Ukuran teks lebih kecil */
        line-height: 1.2; /* Mengurangi spasi baris */
        font-weight: normal;
    }

    .card-body {
        text-align: center; /* Rata tengah */
    }

    .img-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 150px; /* Sesuaikan tinggi kontainer gambar */
        width: 100%;
    }

    .card-img-top {
        height: 170px; /* Atur tinggi gambar */
        width: 170px; /* Atur lebar gambar agar sesuai dengan lebar card */
    }

    /* Responsive styling */
    @media (max-width: 768px) {
        .card-img-top {
            height: 120px; /* Atur ulang tinggi gambar untuk perangkat lebih kecil */
            width: 120px; /* Atur ulang lebar gambar untuk perangkat lebih kecil */
        }

        .card-title {
            font-size: 1.1rem; /* Ukuran judul lebih kecil untuk perangkat lebih kecil */
        }

        .card-text {
            font-size: 0.75rem; /* Ukuran teks lebih kecil untuk perangkat lebih kecil */
        }
    }

    @media (max-width: 576px) {
        .img-container {
            height: 100px; /* Atur ulang tinggi kontainer gambar untuk perangkat sangat kecil */
        }

        .card-img-top {
            height: 100px; /* Atur ulang tinggi gambar untuk perangkat sangat kecil */
            width: 100px; /* Atur ulang lebar gambar untuk perangkat sangat kecil */
        }
    }
</style>
@endsection
