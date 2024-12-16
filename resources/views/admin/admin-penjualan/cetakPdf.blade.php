<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Laporan Penjualan</h1>
    <p>Tahun: {{ $tahun }}</p>
    <p>Bulan: {{ $bulan }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pemesanan</th>
                <th>User ID</th>
                <th>Total Harga</th>
                <th>Alamat Pengiriman</th>
            </tr>
        </thead>
        <tbody>
            @foreach($checkouts as $checkout)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($checkout->tanggal_pemesanan)->format('d-m-Y') }}</td>
                <td>{{ $checkout->user_id }}</td>
                <td>Rp {{ number_format($checkout->total_harga, 0, ',', '.') }}</td>
                <td>{{ $checkout->alamat_pengiriman }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
