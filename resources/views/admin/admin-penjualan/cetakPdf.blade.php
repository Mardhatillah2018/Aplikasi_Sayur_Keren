<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: fixed;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            word-wrap: break-word;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        th:nth-child(1), td:nth-child(1) {
            width: 4%;
        }
        th:nth-child(2), td:nth-child(2) {
            width: 8%;
        }
        th:nth-child(3), td:nth-child(3) {
            width: 4%;
        }
        th:nth-child(4), td:nth-child(4) {
            width: 6%;
        }
        th:nth-child(5), td:nth-child(5) {
            width: 15%;
        }
        /* th:nth-child(6), td:nth-child(6) {
            width: 20%;
        } */
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        @page {
            size: A4 landscape;
            margin-left: 5mm;
            margin-right: 5mm;
            margin-top: 5mm;
            margin-bottom: 5mm;
        }

        @media print {
            .container {
                page-break-inside: avoid;
            }
        }
        .text-center {
            text-align: center;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 120px;
            height: auto;
        }
        .header-info {
            text-align: right;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Bagian Header -->
        <div class="header">
            <div class="header-info">
                <strong>Sayur Keren</strong><br>
                Jl. KIS. Mangunsarkoro No.19, Jati Baru, Kec. Padang Tim., <br>Kota Padang, Sumatera Barat 25121<br>
                Telepon: 081244323035<br>
                Email: info@sayurkeren.com
            </div>
        </div>

        <!-- Judul Laporan -->
        <h2 class="text-center">Laporan Penjualan</h2>
        <p class="text-center">
            Periode:
            <strong>
                {{ $bulan }} {{ $tahun }}
            </strong>
        </p>

        <!-- Menampilkan pesan jika tidak ada penjualan -->
        @if($message)
            <p class="text-center" style="color: red; font-weight: bold;">{{ $message }}</p>
        @else
            <table class="table table-bordered">
                <tr>
                    <th>No</th>
                    <th>Tanggal Pemesanan</th>
                    <th>User ID</th>
                    <th>Total Harga</th>
                    <th>Alamat Pengiriman</th>
                </tr>
                @foreach($checkouts as $checkout)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($checkout->tanggal_pemesanan)->format('d-m-Y') }}</td>
                    <td>{{ $checkout->user_id }}</td>
                    <td>Rp {{ number_format($checkout->total_harga, 0, ',', '.') }}</td>
                    <td>{{ $checkout->alamat_pengiriman }}</td>
                </tr>
                @endforeach
            </table>

            <!-- Menampilkan total penjualan -->
            <p style="text-align: right; font-weight: bold;">
                Total Penjualan: Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
            </p>
        @endif
    </div>
</body>
</html>
