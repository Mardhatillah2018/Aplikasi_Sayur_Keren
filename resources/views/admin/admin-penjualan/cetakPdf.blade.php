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
            width: 6%;
        }
        th:nth-child(2), td:nth-child(2) {
            width: 15%;
        }
        th:nth-child(3), td:nth-child(3) {
            width: 20%;
        }
        th:nth-child(4), td:nth-child(4) {
            width: 24%;
        }
        th:nth-child(5), td:nth-child(5) {
            width: 15%;
        }
        th:nth-child(6), td:nth-child(6) {
            width: 20%;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        @page {
            size: A4;
            margin: 15mm;
        }
        @media print {
            .container {
                page-break-inside: avoid;
            }
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Laporan Penjualan</h2>
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
        <div class="footer">
            <p>&copy; {{ date('Y') }} Sayur Keren</p>
        </div>
    </div>
</body>
</html>
