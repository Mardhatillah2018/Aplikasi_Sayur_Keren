@extends('admin.layouts.main')
@section('title', 'Detail Penjualan')

@section('content')
<div class="card">
    <div class="card-header bg-success text-white">
        <h5>Detail Penjualan</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Bagian Informasi -->
            <div class="col-md-6">
                <table class="table table-bordered table-sm">
                    <tbody>
                        <tr>
                            <th>Tanggal Pemesanan</th>
                            <td>{{ \Carbon\Carbon::parse($checkout->tanggal_pemesanan)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th>User ID</th>
                            <td>{{ $checkout->user_id }}</td>
                        </tr>
                        <tr>
                            <th>Alamat Pengiriman</th>
                            <td>{{ $checkout->alamat_pengiriman }}</td>
                        </tr>
                        <tr>
                            <th>Total Pembayaran</th>
                            <td>Rp {{ number_format($checkout->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Ongkir</th>
                            <td>Rp {{ number_format($checkout->ongkir, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Diskon</th>
                            <td>Rp {{ number_format($checkout->diskon, 0, ',', '.') }}</td>
                        </tr>

                        {{-- <tr>
                            <th>Status</th>
                            <td><span class="badge bg-info">{{ $checkout->status }}</span></td>
                        </tr> --}}
                        <tr>
                            <th>Ulasan</th>
                            <td>{{ $checkout->ulasan }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <!-- Bagian Peta -->
            <div class="col-md-6">
                <p><strong>Lokasi Pengiriman:</strong></p>
                <div id="map" style="height: 300px; border: 1px solid #ddd;"></div>
            </div>
        </div>

        <!-- Bagian Produk Details -->
        <div class="mt-4">
            <h5>Produk Details</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm align-middle">
                    <thead class="table-success">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $details = json_decode($checkout->produk_details, true);
                            $total = 0;
                        @endphp
                        @foreach ($details as $index => $detail)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $detail['nama'] }}</td>
                                <td class="text-center">{{ $detail['jumlah'] }}</td>
                                <td class="text-end">Rp {{ number_format($detail['harga'], 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($detail['jumlah'] * $detail['harga'], 0, ',', '.') }}</td>
                                @php
                                    $total += $detail['jumlah'] * $detail['harga'];
                                @endphp
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Belanja</th>
                            <th class="text-end">Rp {{ number_format($total, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Peta -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script>
    // Koordinat latitude dan longitude
    var lat = {{ $checkout->latitude }};
    var lng = {{ $checkout->longitude }};

    // Inisialisasi peta menggunakan Leaflet.js
    var map = L.map('map').setView([lat, lng], 15); // Zoom level 15
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // Tambahkan marker ke peta
    L.marker([lat, lng]).addTo(map)
        .bindPopup("<b>Lokasi Pengiriman</b><br>{{ $checkout->alamat_pengiriman }}")
        .openPopup();
</script>
@endsection
