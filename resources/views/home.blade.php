@extends('layouts.main')

@section('content')
<br>

<section class="py-3">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-6 d-flex flex-column">
                <!-- Carousel Banner -->
                <div id="bannerCarousel" class="carousel slide flex-fill" data-bs-ride="carousel" data-bs-interval="3000">
                    <div class="carousel-inner h-100">
                        @foreach($banners as $key => $banner)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }} h-100">
                            {{-- <img src="{{ asset('images/bannerSlide/' . $banner->gambar_banner) }}" class="d-block w-100 h-100 banner-img" alt="Banner {{ $key + 1 }}" style="object-fit: cover;"> --}}
                            <div class="carousel-img-wrapper" style="position: relative; width: 100%; padding-bottom: 56.25%;"> <!-- 16:9 aspect ratio -->
                                <img src="{{ asset('images/bannerSlide/' . $banner->gambar_banner) }}" class="d-block w-100 h-100 banner-img" alt="Banner {{ $key + 1 }}" style="object-fit: cover; position: absolute; top: 0; left: 0;">
                            </div>
                            <div class="carousel-caption d-flex justify-content-center align-items-center" style="pointer-events: none;">
                                <a href="/semuaproduk" class="btn belanja-sekarang">BELANJA SEKARANG</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <!-- / Carousel Banner -->
            </div>

            <div class="col-md-6">
                <div class="banner-ad bg-success-subtle block-2 " style="background:url('images/banner/banner1_1.png') no-repeat;background-size: cover; height: 170px;"></div>
                <div class="banner-ad bg-danger block-3 mt-3" style="background:url('images/banner/banner2_2.png') no-repeat;background-size: cover; height: 170px;"></div>
                <!-- / Banner Blocks -->
            </div>
        </div>
    </div>

    <!-- Section Kategori -->
    <section class="py-3 overflow-hidden">
        <div class="container-lg">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header d-flex flex-wrap justify-content-between mb-5">
                        <h4 class="section-title">Kategori</h4>
                        <div class="d-flex align-items-center">
                            <!-- Tombol Navigasi -->
                            <div class="swiper-buttons">
                                <button class="swiper-prev category-carousel-prev btn" style="background-color: #0B773D; color: white; border: none;">❮</button>
                                <button class="swiper-next category-carousel-next btn" style="background-color: #0B773D; color: white; border: none;">❯</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="category-carousel swiper">
                        <div class="swiper-wrapper">
                            @foreach($kategoris as $kategori)
                                <div class="swiper-slide text-center">
                                    <a href="/" class="nav-link">
                                        <img src="{{ asset('images/kategori/' . $kategori->gambar_kategori) }}"
                                             class="rounded-circle img-category"
                                             alt="{{ $kategori->nama_kategori }}">
                                        <h4 class="fs-6 mt-3 fw-normal">{{ $kategori->nama_kategori }}</h4>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <!-- Pagination -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</section>

<style>

    /* Responsive adjustments for category images */
@media (max-width: 1200px) {
    .img-category {
        width: 80px; /* Ukuran lebih kecil untuk layar besar */
        height: 80px;
    }
}

@media (max-width: 992px) {
    .img-category {
        width: 70px; /* Ukuran lebih kecil untuk layar sedang */
        height: 70px;
    }
}

@media (max-width: 768px) {
    .img-category {
        width: 60px; /* Ukuran lebih kecil untuk layar kecil */
        height: 60px;
    }
}

@media (max-width: 480px) {
    .img-category {
        width: 50px; /* Ukuran terkecil untuk layar sangat kecil */
        height: 50px;
    }
}

/* Carousel Banner Styles
.carousel-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
} */
 /* Pastikan carousel item dan gambar memiliki ukuran tetap */
.carousel-item {
    width: 100%; /* Lebar mengikuti container */
    height: 576px; /* Tinggi tetap */
    position: relative; /* Agar caption bisa diposisikan dengan baik */
}

.banner-img, .carousel-item img {
    width: 100%; /* Gambar mengikuti lebar kontainer */
    height: 100%; /* Gambar mengikuti tinggi kontainer */
    object-fit: cover; /* Gambar akan menutupi kotak slide */
    object-position: center; /* Fokus gambar di tengah */
}

.carousel-caption {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 10;
    pointer-events: none;
}
.belanja-sekarang {
    background-color: #0B773D;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    pointer-events: auto;
}
.belanja-sekarang:hover {
    background-color: #085A2D;
}

/* Category Styles */
.category-carousel .swiper-slide {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 10px;
}
.img-category {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 50%;
    transition: transform 0.3s;
}
.img-category:hover {
    transform: scale(1.1);
}
.swiper-pagination {
    bottom: -20px !important; /* Geser pagination ke bawah */
    text-align: center; /* Atur agar tetap di tengah */
}

.swiper-pagination-bullet {
    background-color: #0B773D; /* Ubah warna pagination */
    opacity: 0.8;
    transition: opacity 0.3s ease;
}

.swiper-pagination-bullet-active {
    opacity: 1; /* Tambahkan efek saat aktif */
}

</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const categorySwiper = new Swiper('.category-carousel', {
    loop: true,
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    navigation: {
        nextEl: '.category-carousel-next',
        prevEl: '.category-carousel-prev',
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    slidesPerView: 6, // Tampilkan 6 kategori per slide
    spaceBetween: 15, // Jarak antar slide
    breakpoints: {
        1400: { slidesPerView: 6 }, // 6 kategori untuk layar sangat besar
        1200: { slidesPerView: 5 }, // 5 kategori untuk layar besar
        992: { slidesPerView: 4 },  // 4 kategori untuk layar medium
        768: { slidesPerView: 3 },  // 3 kategori untuk layar kecil
        480: { slidesPerView: 1 },  // 1 kategori untuk layar sangat kecil
    },
});


});
</script>
@endsection
