@extends('layouts.main')

@section('content')
<section class="vh-80 mt-5">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-10 col-lg-8 mb-4">
                <div class="card shadow-lg rounded" style="border: none;">
                    <div class="card-body">
                        <h4 class="mt-1 text-center" style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #0B773D;">Checkout</h4>

                        <hr style="border-top: 2px solid #0B773D; margin-bottom: 20px;">

                        <!-- Data Pelanggan -->
                        <div class="mb-3">
                            <h5 class="font-weight-bold">Data Pelanggan</h5>
                            <p style="padding-left: 20px;" class="mb-1"><strong>Username:</strong> {{ $user->username }}</p>
                            <p style="padding-left: 20px;" class="mb-1"><strong>Nomor HP:</strong> {{ $user->nohp ?? 'Nomor HP tidak tersedia' }}</p>
                        </div>

                        <hr style="border-top: 2px solid #0B773D; margin-bottom: 20px;">

                        <!-- Data Produk -->
                        <div class="mb-3">
                            <h5 class="font-weight-bold">Data Produk</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($keranjangs as $keranjang)
                                    <tr>
                                        <td>{{ $keranjang->produk->nama }}</td>
                                        <td>{{ $keranjang->jumlah }}</td>
                                        <td>Rp {{ number_format($keranjang->harga, 2, ',', '.') }}</td>
                                        <td>Rp {{ number_format($keranjang->jumlah * $keranjang->harga, 2, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <hr style="border-top: 2px solid #0B773D; margin-bottom: 20px;">

                        <div class="mb-4">
                            <h5 class="font-weight-bold">Alamat Pengiriman</h5>
                            <p style="font-size: 0.75rem; color: red;">* Pilih lokasi Anda untuk menghitung ongkos kirim.</p>
                            <div id="map" style="height: 300px; border: 1px solid #0B773D;"></div>
                            <form action="{{ route('checkout.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="search">Cari Alamat:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="bi bi-search"></i> <!-- Ikon pencarian dari Bootstrap Icons -->
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="search" placeholder="Masukkan alamat" aria-describedby="basic-addon1">
                                    </div>
                                    <ul id="searchResults" class="list-group mt-1" style="display: none; max-height: 200px; overflow-y: auto;"></ul>
                                </div>

                                <div class="mb-3">
                                    <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                                    <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
                                    <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Alamat yang dipilih" readonly>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" id="calculateDistance">Hitung Ongkir</button>
                                </div>
                                <br>
                                <div class="form-group">
                                    <h6>Belanja: <span id="totalHarga" style="color: #0B773D; font-size: 0.85rem;">Rp {{ $totalHargaProduk }}</span></h6>
                                    <input type="hidden" id="totalHargaInput" name="total_harga" value="{{ $totalHargaProduk }}">
                                </div>
                                <div class="form-group" id="diskonSection" style="display: none;"> <!-- Awalnya disembunyikan -->
                                    <h6>Diskon: <span id="diskon" style="color: #D32F2F; font-size: 0.85rem;">Rp 0</span></h6>
                                    <input type="hidden" id="diskonInput" name="diskon" value="0">
                                </div>
                                <div class="form-group" id="hargaSetelahDiskonSection" style="display: none; border-top: 1px solid #ddd; padding-top: 10px;">
                                    <h6>Harga Setelah Diskon: <span id="hargaSetelahDiskon" style="color: #0B773D; font-size: 0.85rem;">Rp 0</span></h6>
                                    <input type="hidden" id="hargaSetelahDiskonInput" name="harga_setelah_diskon" value="0">
                                </div>
                                <div class="form-group">
                                    <h6>Ongkir: <span id="ongkir" style="color: #0B773D; font-size: 0.85rem;">Rp 0</span></h6>
                                    <input type="hidden" id="ongkirInput" name="ongkir" value="0">
                                </div>

                                <div class="form-group" style="border-top: 1px solid #ddd; padding-top: 10px;">
                                    <h5 style="color: #0B773D; font-weight: bold;">Total Pembayaran: <span id="totalPembayaran" style="color: #0B773D;">Rp 0</span></h5>
                                    <input type="hidden" id="totalPembayaranInput" name="total_pembayaran" value="0">
                                </div>
                                <div class="mt-3 text-center">
                                    <button type="submit" class="btn w-100 py-2" style="background-color: #0B773D; border-color: #0B773D; color: white;">Pesan Sekarang</button>
                                </div>
                            </form>
                        </div>

                        <!-- Leaflet.js -->
                        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
                        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
                        <script>
                            // Koordinat toko Sayur Keren
                            const tokoLocation = [-0.9338357848769078, 100.36405296634356];

                            // Inisialisasi Peta
                            const map = L.map('map').setView(tokoLocation, 13);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);

                            // Tambahkan marker untuk lokasi toko
                            L.marker(tokoLocation, {
                                icon: L.divIcon({
                                    className: 'custom-icon',  // Kelas untuk CSS
                                    html: '<div style="background-color: red; width: 15px; height: 15px; border-radius: 50%;"></div>',  // Membuat marker berbentuk lingkaran merah
                                    iconSize: [15, 15],  // Ukuran ikon
                                })
                            }).addTo(map)
                                .bindPopup('<b>Sayur Keren</b><br>Lokasi toko.')
                                .openPopup();

                            let marker = null;

                            // Fungsi untuk memperbarui marker
                            function updateMarker(lat, lng) {
                                if (marker) map.removeLayer(marker);
                                marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                                document.getElementById('latitude').value = lat;
                                document.getElementById('longitude').value = lng;

                                marker.on('dragend', function (e) {
                                    const { lat, lng } = marker.getLatLng();
                                    updateMarker(lat, lng);
                                    reverseGeocode(lat, lng);
                                });
                            }

                            // Fungsi Reverse Geocode
                            function reverseGeocode(lat, lng) {
                                fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json&countrycodes=id`)
                                    .then(response => response.json())
                                    .then(data => {
                                        document.getElementById('alamat').value = data.display_name || 'Alamat tidak ditemukan';
                                    });
                            }

                            // Fungsi untuk mencari alamat
                            document.getElementById('search').addEventListener('input', function () {
                                const query = this.value.trim();
                                if (!query) {
                                    document.getElementById('searchResults').style.display = 'none';
                                    return;
                                }

                                fetch(`https://nominatim.openstreetmap.org/search?q=${query}&format=json&addressdetails=1&limit=5&countrycodes=id`)
                                    .then(response => response.json())
                                    .then(data => {
                                        const resultsList = document.getElementById('searchResults');
                                        resultsList.innerHTML = '';
                                        if (data.length > 0) {
                                            resultsList.style.display = 'block';
                                            data.forEach(item => {
                                                const li = document.createElement('li');
                                                li.className = 'list-group-item list-group-item-action';
                                                li.textContent = item.display_name;
                                                li.addEventListener('click', function () {
                                                    const lat = parseFloat(item.lat);
                                                    const lon = parseFloat(item.lon);
                                                    document.getElementById('search').value = '';
                                                    document.getElementById('alamat').value = item.display_name;
                                                    resultsList.style.display = 'none';
                                                    updateMarker(lat, lon);
                                                    map.setView([lat, lon], 15);
                                                });
                                                resultsList.appendChild(li);
                                            });
                                        } else {
                                            resultsList.style.display = 'none';
                                        }
                                    });
                            });

                            // Fungsi untuk menghitung ongkir
                            document.getElementById('calculateDistance').addEventListener('click', function () {
                                const lat = parseFloat(document.getElementById('latitude').value);
                                const lon = parseFloat(document.getElementById('longitude').value);

                                if (!lat || !lon) {
                                    alert('Silakan pilih lokasi terlebih dahulu.');
                                    return;
                                }

                                const distance = map.distance(tokoLocation, [lat, lon]) / 1000; // Jarak dalam km
                                let ongkir = Math.ceil(distance * 1000); // Ongkir sebelum pembulatan

                                // Logika untuk membulatkan ongkir
                                if (distance < 0.5) {
                                    ongkir = Math.round(ongkir / 500) * 500; // Pembulatan ke kelipatan 500 jika jarak < 0.5 km
                                } else {
                                    ongkir = Math.round(ongkir / 1000) * 1000; // Pembulatan ke kelipatan 1000 jika jarak >= 0.5 km
                                }

                                const totalHargaProduk = {{ $totalHargaProduk }}; // Total harga produk

                                // Ambil diskon dari promo jika ada
                                let diskon = 0;
                                const isPromoActive = {{ $promo ? 'true' : 'false' }}; // Cek apakah promo aktif

                                // Hitung diskon pada total harga produk
                                if (isPromoActive) {
                                    const diskonPersentase = {{ $promo->diskon ?? 0 }} / 100; // Hitung persentase diskon
                                    diskon = totalHargaProduk * diskonPersentase; // Hitung diskon berdasarkan harga produk

                                    // Tampilkan bagian diskon
                                    document.getElementById('diskonSection').style.display = 'block'; // Tampilkan diskon
                                    document.getElementById('hargaSetelahDiskonSection').style.display = 'block'; // Tampilkan harga setelah diskon
                                } else {
                                    // Sembunyikan bagian diskon jika tidak ada promo
                                    document.getElementById('diskonSection').style.display = 'none';
                                    document.getElementById('hargaSetelahDiskonSection').style.display = 'none'; // Sembunyikan harga setelah diskon
                                }

                                // Hitung harga setelah diskon
                                const hargaSetelahDiskon = totalHargaProduk - diskon;

                                // Total pembayaran = Harga setelah diskon + ongkir
                                const totalPembayaran = hargaSetelahDiskon + ongkir; // Total pembayaran yang benar

                                // Menampilkan ongkir, diskon, dan harga setelah diskon
                                document.getElementById('ongkir').innerText = `Rp ${ongkir.toLocaleString()}`;
                                document.getElementById('ongkirInput').value = ongkir;
                                document.getElementById('diskon').innerText = `Rp ${diskon.toLocaleString()}`;
                                document.getElementById('diskonInput').value = diskon;
                                document.getElementById('hargaSetelahDiskon').innerText = `Rp ${hargaSetelahDiskon.toLocaleString()}`;
                                document.getElementById('hargaSetelahDiskonInput').value = hargaSetelahDiskon;

                                // Update total harga yang sudah termasuk ongkir dan diskon
                                document.getElementById('totalHarga').innerText = `Rp ${totalHargaProduk.toLocaleString()}`; // Total harga produk tetap

                                // Menampilkan total pembayaran setelah ongkir dan diskon dihitung
                                document.getElementById('totalPembayaran').innerText = `Rp ${totalPembayaran.toLocaleString()}`;
                                document.getElementById('totalPembayaranInput').value = totalPembayaran; // Menyimpan total pembayaran di input tersembunyi
                            });

                            document.addEventListener('DOMContentLoaded', function () {
                                // Fungsi untuk menangani pengiriman formulir
                                document.querySelector('form').addEventListener('submit', function (event) {
                                    const lat = parseFloat(document.getElementById('latitude').value);
                                    const lon = parseFloat(document.getElementById('longitude').value);
                                    const ongkir = parseFloat(document.getElementById('ongkirInput').value);

                                    // Validasi alamat dan ongkir
                                    if (!lat || !lon) {
                                        event.preventDefault(); // Mencegah pengiriman formulir
                                        alert('Silakan pilih alamat dan hitung ongkir terlebih dahulu.');
                                        return;
                                    }

                                    // Jika alamat dan ongkir sudah ada, tampilkan konfirmasi
                                    const confirmation = confirm('Apakah Anda ingin melanjutkan pemesanan?');
                                    if (!confirmation) {
                                        event.preventDefault(); // Mencegah pengiriman formulir
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .table-bordered {
        border: 2px solid #dee2e6 !important; /* Mengatur border tabel */
    }

    .table-bordered th, .table-bordered td {
        border: 2px solid #dee2e6 !important; /* Mengatur border pada setiap sel */
    }

    .table-bordered th {
        background-color: #f8f9fa;
        color: #0B773D;
    }

    .table-bordered td {
        background-color: #fff;
    }
</style>

@endsection
