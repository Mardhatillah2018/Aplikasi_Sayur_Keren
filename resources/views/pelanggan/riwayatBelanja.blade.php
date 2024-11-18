@extends('layouts.main')

@section('content')
<section class="mt-5">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-12 col-lg-10 mb-4">
                <div class="card shadow-lg rounded" style="border: none;">
                    <div class="card-body">
                        <h4 class="mt-1 text-center" style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #0B773D;">Riwayat Belanja</h4>

                        <form method="GET" action="{{ route('riwayat-belanja') }}">
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    {{-- <label for="status" class="form-label">Filter Status</label> --}}
                                    <select id="status" name="status" class="form-select">
                                        <option value="">Semua Status</option>
                                        <option value="pesanan diterima" {{ request('status') == 'pesanan diterima' ? 'selected' : '' }}>Pesanan Diterima</option>
                                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    {{-- <label for="bulan" class="form-label">Filter Bulan</label> --}}
                                    <select id="bulan" name="bulan" class="form-select">
                                        <option value="">Semua Bulan</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    {{-- <label for="tahun" class="form-label">Filter Tahun</label> --}}
                                    <select id="tahun" name="tahun" class="form-select">
                                        <option value="">Semua Tahun</option>
                                        @foreach(range(date('Y'), date('Y') - 5) as $year)
                                            <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-success w-100">Terapkan</button>
                                </div>
                            </div>
                        </form>

                        <!-- Tabel Riwayat Belanja -->
                        <div class="mb-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Tanggal Pemesanan</th>
                                        <th scope="col">Total Harga</th>
                                        <th scope="col">Bukti Transfer</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayatBelanja as $checkout)
                                    <tr id="row-{{ $checkout->id }}">
                                        <td><a href="{{ route('checkout.detail', $checkout->id) }}" style="text-decoration: none; color: #0B773D;" title="Lihat Detail">{{ \Carbon\Carbon::parse($checkout->tanggal_pemesanan)->format('d F Y') }}</a></td>
                                        <td>Rp {{ number_format($checkout->total_harga, 0, ',', '.') }}</td>
                                        <td id="button-cell-{{ $checkout->id }}">
                                            @if($checkout->bukti_transfer)
                                                <button class="btn btn-success" title="Lihat Bukti Transfer"
                                                    onclick="window.open('{{ asset($checkout->bukti_transfer) }}', '_blank')">
                                                    Lihat Bukti
                                                </button>
                                            @else
                                                <button class="btn" style="background-color: #0b773d; color: white;"
                                                    title="Upload Bukti Transfer"
                                                    onclick="document.getElementById('fileInput{{ $checkout->id }}').click()">
                                                    Upload Bukti
                                                </button>
                                                <input type="file" id="fileInput{{ $checkout->id }}" name="bukti_transfer"
                                                    style="display: none;"
                                                    onchange="uploadBukti({{ $checkout->id }})">
                                            @endif
                                        </td>


                                        <td>
                                            @if($checkout->status == 'pesanan diterima')
                                                <span class="badge" style="background-color: #a72c28; color: white;">Pesanan Diterima</span> <!-- Hijau untuk pesanan diterima -->
                                            @elseif($checkout->status == 'diproses')
                                                <span class="badge" style="background-color: #0c58b4; color: white;">Diproses</span> <!-- Kuning untuk diproses -->
                                            @elseif($checkout->status == 'dikirim')
                                                <span class="badge" style="background-color: #081958; color: white;">Dikirim</span> <!-- Biru untuk dikirim -->
                                            @elseif($checkout->status == 'selesai')
                                                <span class="badge" style="background-color: #0b773d; color: white;">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Fungsi untuk meng-upload bukti transfer
    function uploadBukti(checkoutId) {
    var fileInput = document.getElementById('fileInput' + checkoutId);
    var formData = new FormData();
    formData.append('bukti_transfer', fileInput.files[0]);
    formData.append('_token', '{{ csrf_token() }}');

    fetch('/upload-bukti/' + checkoutId, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Tampilkan notifikasi berhasil
            alert('Bukti transfer berhasil diupload!');

            // Ubah tombol menjadi "Lihat Bukti"
            var buttonCell = document.getElementById('button-cell-' + checkoutId);
            buttonCell.innerHTML = `
                <button class="btn btn-success" title="Lihat Bukti Transfer"
                    onclick="window.open('${data.bukti_path}', '_blank')">
                    Lihat Bukti
                </button>
            `;
        } else {
            alert('Terjadi kesalahan saat mengupload bukti transfer.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal mengupload bukti transfer. Silakan coba lagi.');
    });
}

</script>
@endsection
