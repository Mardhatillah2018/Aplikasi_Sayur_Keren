@extends('layouts.main')

@section('content')

<section class="mt-5">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-12 col-lg-12 mb-4">
                <div class="card shadow-lg rounded" style="border: none;">

                    <h4 class="mt-3 text-center" style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #0B773D; font-size: 1.2rem;">Riwayat Belanja</h4>

                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ request('tab', 'pesanan diterima') === 'pesanan diterima' ? 'text-white' : '' }}"
                               href="?tab=pesanan diterima"
                               style="{{ request('tab', 'pesanan diterima') === 'pesanan diterima' ? 'background-color: #ef5555a3; font-size: 0.9rem;' : '' }}">
                                Diterima
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request('tab') === 'diproses' ? 'text-white' : '' }}"
                               href="?tab=diproses"
                               style="{{ request('tab') === 'diproses' ? 'background-color: #0c58b48f; font-size: 0.9rem;' : '' }}">
                                Diproses
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request('tab') === 'dikirim' ? 'text-white' : '' }}"
                               href="?tab=dikirim"
                               style="{{ request('tab') === 'dikirim' ? 'background-color: #08195894; font-size: 0.9rem;' : '' }}">
                                Dikirim
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request('tab') === 'selesai' ? 'text-white' : '' }}"
                               href="?tab=selesai"
                               style="{{ request('tab') === 'selesai' ? 'background-color: #0b773d90; font-size: 0.9rem;' : '' }}">
                                Selesai
                            </a>
                        </li>
                    </ul>

                    {{-- Riwayat berdasarkan tab --}}
                    @if(request('tab') === 'pesanan diterima'  || !request('tab'))
                    <!-- Pesanan Diproses -->
                    <div class="card-header" style="background-color: #ef5555a3; color: rgb(247, 247, 247);">
                        <h5 class="mb-0" style="font-size: 1rem;">📦 Pesanan Diterima</h5>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                        <!-- Tabel Riwayat Belanja -->
                        <div class="mb-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Tanggal Pemesanan</th>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Total Harga</th>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Bukti Transfer</th>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Status</th>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Pesan</th>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Ulasan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayatBelanja as $checkout)
                                    <tr id="row-{{ $checkout->id }}">
                                        <td class="text-center" style="font-size: 0.875rem;"><a href="{{ route('checkout.detail', $checkout->id) }}" style="text-decoration: none; color: #0B773D;" title="Lihat Detail">{{ \Carbon\Carbon::parse($checkout->tanggal_pemesanan)->format('d F Y') }}</a></td>
                                        <td class="text-center" style="font-size: 0.875rem;">Rp {{ number_format($checkout->total_harga, 0, ',', '.') }}</td>
                                        <td id="button-cell-{{ $checkout->id }}" class="text-center" style="font-size: 0.875rem;">
                                            @if($checkout->bukti_transfer)
                                                <button class="btn btn-success"
                                                        style="font-size: 13px; padding: 5px 5px;"
                                                        title="Lihat Bukti Transfer"
                                                        onclick="window.open('{{ asset($checkout->bukti_transfer) }}', '_blank')">
                                                    Lihat Bukti
                                                </button>
                                            @else
                                                <button class="btn"
                                                        style="background-color: #db9a44; color: white; font-size: 13px; padding: 5px 5px;"
                                                        title="Upload Bukti Transfer"
                                                        onclick="document.getElementById('fileInput{{ $checkout->id }}').click()">
                                                    Upload Bukti
                                                </button>
                                                <input type="file" id="fileInput{{ $checkout->id }}" name="bukti_transfer"
                                                       style="display: none;"
                                                       onchange="uploadBukti({{ $checkout->id }})">
                                            @endif
                                        </td>

                                        <td class="text-center" style="font-size: 0.875rem;">
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
                                        <td class="text-center">
                                            @if($checkout->catatan_admin)
                                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#messageModal-{{ $checkout->id }}" title="Lihat Pesan">
                                                    <i class="fas fa-envelope"></i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="messageModal-{{ $checkout->id }}" tabindex="-1" aria-labelledby="messageModalLabel-{{ $checkout->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="messageModalLabel-{{ $checkout->id }}">Pesan</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="small text-wrap">{{ $checkout->catatan_admin }}</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="small text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($checkout->ulasan)
                                                <!-- Tombol untuk melihat ulasan -->
                                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#viewUlasanModal{{ $checkout->id }}" title="Lihat Ulasan">
                                                    <i class="fas fa-eye"></i> Lihat Ulasan
                                                </button>

                                                <!-- Modal untuk melihat ulasan -->
                                                <div class="modal fade" id="viewUlasanModal{{ $checkout->id }}" tabindex="-1" aria-labelledby="viewUlasanModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="viewUlasanModalLabel">Ulasan Anda</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>{{ $checkout->ulasan }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Tombol untuk memberi ulasan -->
                                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#ulasanModal{{ $checkout->id }}" title="Beri Ulasan">
                                                    <i class="fas fa-star"></i> Beri Ulasan
                                                </button>

                                                <!-- Modal untuk memberi ulasan -->
                                                <div class="modal fade" id="ulasanModal{{ $checkout->id }}" tabindex="-1" aria-labelledby="ulasanModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="ulasanModalLabel" style="font-size: 0.880rem;">Beri Ulasan</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('riwayatBelanja.simpanUlasan', $checkout->id) }}" method="POST">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <textarea class="form-control" id="ulasan" name="ulasan" rows="4" placeholder="Ketik Ulasan" required></textarea>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-success">Simpan Ulasan</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    @elseif(request('tab') === 'diproses')
                    <div class="card-header" style="background-color: #0c58b48f; color: rgb(255, 255, 255);">
                        <h5 class="mb-0" style="font-size: 1rem;">📦 Pesanan Diproses</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <!-- Tabel Riwayat Belanja -->
                        <div class="mb-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Tanggal Pemesanan</th>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Total Harga</th>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Bukti Transfer</th>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Status</th>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Pesan</th>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Ulasan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayatBelanja as $checkout)
                                    <tr id="row-{{ $checkout->id }}">
                                        <td class="text-center" style="font-size: 0.875rem;"><a href="{{ route('checkout.detail', $checkout->id) }}" style="text-decoration: none; color: #0B773D;" title="Lihat Detail">{{ \Carbon\Carbon::parse($checkout->tanggal_pemesanan)->format('d F Y') }}</a></td>
                                        <td class="text-center" style="font-size: 0.875rem;">Rp {{ number_format($checkout->total_harga, 0, ',', '.') }}</td>
                                        <td id="button-cell-{{ $checkout->id }}" class="text-center" style="font-size: 0.875rem;">
                                            @if($checkout->bukti_transfer)
                                                <button class="btn btn-success"
                                                        style="font-size: 13px; padding: 5px 5px;"
                                                        title="Lihat Bukti Transfer"
                                                        onclick="window.open('{{ asset($checkout->bukti_transfer) }}', '_blank')">
                                                    Lihat Bukti
                                                </button>
                                            @else
                                                <button class="btn"
                                                        style="background-color: #db9a44; color: white; font-size: 13px; padding: 5px 5px;"
                                                        title="Upload Bukti Transfer"
                                                        onclick="document.getElementById('fileInput{{ $checkout->id }}').click()">
                                                    Upload Bukti
                                                </button>
                                                <input type="file" id="fileInput{{ $checkout->id }}" name="bukti_transfer"
                                                       style="display: none;"
                                                       onchange="uploadBukti({{ $checkout->id }})">
                                            @endif
                                        </td>

                                        <td class="text-center" style="font-size: 0.875rem;">
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
                                        <td class="text-center">
                                            @if($checkout->catatan_admin)
                                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#messageModal-{{ $checkout->id }}" title="Lihat Pesan">
                                                    <i class="fas fa-envelope"></i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="messageModal-{{ $checkout->id }}" tabindex="-1" aria-labelledby="messageModalLabel-{{ $checkout->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="messageModalLabel-{{ $checkout->id }}">Pesan</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="small text-wrap">{{ $checkout->catatan_admin }}</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="small text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($checkout->ulasan)
                                                <!-- Tombol untuk melihat ulasan -->
                                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#viewUlasanModal{{ $checkout->id }}" title="Lihat Ulasan">
                                                    <i class="fas fa-eye"></i> Lihat Ulasan
                                                </button>

                                                <!-- Modal untuk melihat ulasan -->
                                                <div class="modal fade" id="viewUlasanModal{{ $checkout->id }}" tabindex="-1" aria-labelledby="viewUlasanModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="viewUlasanModalLabel">Ulasan Anda</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>{{ $checkout->ulasan }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Tombol untuk memberi ulasan -->
                                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#ulasanModal{{ $checkout->id }}" title="Beri Ulasan">
                                                    <i class="fas fa-star"></i> Beri Ulasan
                                                </button>

                                                <!-- Modal untuk memberi ulasan -->
                                                <div class="modal fade" id="ulasanModal{{ $checkout->id }}" tabindex="-1" aria-labelledby="ulasanModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="ulasanModalLabel" style="font-size: 0.880rem;">Beri Ulasan</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('riwayatBelanja.simpanUlasan', $checkout->id) }}" method="POST">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <textarea class="form-control" id="ulasan" name="ulasan" rows="4" placeholder="Ketik Ulasan" required></textarea>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-success">Simpan Ulasan</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    @elseif(request('tab') === 'dikirim')
                    <div class="card-header" style="background-color: #08195894; color: rgb(255, 255, 255);">
                        <h5 class="mb-0" style="font-size: 1rem;">📦 Pesanan Dikirim</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <!-- Tabel Riwayat Belanja -->
                        <div class="mb-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Tanggal Pemesanan</th>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Total Harga</th>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Bukti Transfer</th>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Status</th>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Pesan</th>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Ulasan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayatBelanja as $checkout)
                                    <tr id="row-{{ $checkout->id }}">
                                        <td class="text-center" style="font-size: 0.875rem;"><a href="{{ route('checkout.detail', $checkout->id) }}" style="text-decoration: none; color: #0B773D;" title="Lihat Detail">{{ \Carbon\Carbon::parse($checkout->tanggal_pemesanan)->format('d F Y') }}</a></td>
                                        <td class="text-center" style="font-size: 0.875rem;">Rp {{ number_format($checkout->total_harga, 0, ',', '.') }}</td>
                                        <td id="button-cell-{{ $checkout->id }}" class="text-center" style="font-size: 0.875rem;">
                                            @if($checkout->bukti_transfer)
                                                <button class="btn btn-success"
                                                        style="font-size: 13px; padding: 5px 5px;"
                                                        title="Lihat Bukti Transfer"
                                                        onclick="window.open('{{ asset($checkout->bukti_transfer) }}', '_blank')">
                                                    Lihat Bukti
                                                </button>
                                            @else
                                                <button class="btn"
                                                        style="background-color: #db9a44; color: white; font-size: 13px; padding: 5px 5px;"
                                                        title="Upload Bukti Transfer"
                                                        onclick="document.getElementById('fileInput{{ $checkout->id }}').click()">
                                                    Upload Bukti
                                                </button>
                                                <input type="file" id="fileInput{{ $checkout->id }}" name="bukti_transfer"
                                                       style="display: none;"
                                                       onchange="uploadBukti({{ $checkout->id }})">
                                            @endif
                                        </td>

                                        <td class="text-center" style="font-size: 0.875rem;">
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
                                        <td class="text-center">
                                            @if($checkout->catatan_admin)
                                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#messageModal-{{ $checkout->id }}" title="Lihat Pesan">
                                                    <i class="fas fa-envelope"></i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="messageModal-{{ $checkout->id }}" tabindex="-1" aria-labelledby="messageModalLabel-{{ $checkout->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="messageModalLabel-{{ $checkout->id }}">Pesan</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="small text-wrap">{{ $checkout->catatan_admin }}</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="small text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($checkout->ulasan)
                                                <!-- Tombol untuk melihat ulasan -->
                                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#viewUlasanModal{{ $checkout->id }}" title="Lihat Ulasan">
                                                    <i class="fas fa-eye"></i> Lihat Ulasan
                                                </button>

                                                <!-- Modal untuk melihat ulasan -->
                                                <div class="modal fade" id="viewUlasanModal{{ $checkout->id }}" tabindex="-1" aria-labelledby="viewUlasanModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="viewUlasanModalLabel">Ulasan Anda</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>{{ $checkout->ulasan }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Tombol untuk memberi ulasan -->
                                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#ulasanModal{{ $checkout->id }}" title="Beri Ulasan">
                                                    <i class="fas fa-star"></i> Beri Ulasan
                                                </button>

                                                <!-- Modal untuk memberi ulasan -->
                                                <div class="modal fade" id="ulasanModal{{ $checkout->id }}" tabindex="-1" aria-labelledby="ulasanModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="ulasanModalLabel" style="font-size: 0.880rem;">Beri Ulasan</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('riwayatBelanja.simpanUlasan', $checkout->id) }}" method="POST">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <textarea class="form-control" id="ulasan" name="ulasan" rows="4" placeholder="Ketik Ulasan" required></textarea>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-success">Simpan Ulasan</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    @elseif(request('tab') === 'selesai')
                    <div class="card-header" style="background-color: #0b773d90; color: rgb(255, 255, 255);">
                        <h5 class="mb-0" style="font-size: 1rem;">📦 Pesanan Selesai</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <!-- Tabel Riwayat Belanja -->
                        <div class="mb-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Tanggal Pemesanan</th>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Total Harga</th>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Bukti Transfer</th>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Status</th>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Pesan</th>
                                        <th scope="col" class="text-center" style="font-size: 0.875rem;">Ulasan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayatBelanja as $checkout)
                                    <tr id="row-{{ $checkout->id }}">
                                        <td class="text-center" style="font-size: 0.875rem;"><a href="{{ route('checkout.detail', $checkout->id) }}" style="text-decoration: none; color: #0B773D;" title="Lihat Detail">{{ \Carbon\Carbon::parse($checkout->tanggal_pemesanan)->format('d F Y') }}</a></td>
                                        <td class="text-center" style="font-size: 0.875rem;">Rp {{ number_format($checkout->total_harga, 0, ',', '.') }}</td>
                                        <td id="button-cell-{{ $checkout->id }}" class="text-center" style="font-size: 0.875rem;">
                                            @if($checkout->bukti_transfer)
                                                <button class="btn btn-success"
                                                        style="font-size: 13px; padding: 5px 5px;"
                                                        title="Lihat Bukti Transfer"
                                                        onclick="window.open('{{ asset($checkout->bukti_transfer) }}', '_blank')">
                                                    Lihat Bukti
                                                </button>
                                            @else
                                                <button class="btn"
                                                        style="background-color: #db9a44; color: white; font-size: 13px; padding: 5px 5px;"
                                                        title="Upload Bukti Transfer"
                                                        onclick="document.getElementById('fileInput{{ $checkout->id }}').click()">
                                                    Upload Bukti
                                                </button>
                                                <input type="file" id="fileInput{{ $checkout->id }}" name="bukti_transfer"
                                                       style="display: none;"
                                                       onchange="uploadBukti({{ $checkout->id }})">
                                            @endif
                                        </td>

                                        <td class="text-center" style="font-size: 0.875rem;">
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
                                        <td class="text-center">
                                            @if($checkout->catatan_admin)
                                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#messageModal-{{ $checkout->id }}" title="Lihat Pesan">
                                                    <i class="fas fa-envelope"></i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="messageModal-{{ $checkout->id }}" tabindex="-1" aria-labelledby="messageModalLabel-{{ $checkout->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="messageModalLabel-{{ $checkout->id }}">Pesan</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="small text-wrap">{{ $checkout->catatan_admin }}</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="small text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($checkout->ulasan)
                                                <!-- Tombol untuk melihat ulasan -->
                                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#viewUlasanModal{{ $checkout->id }}" title="Lihat Ulasan">
                                                    <i class="fas fa-eye"></i> Lihat Ulasan
                                                </button>

                                                <!-- Modal untuk melihat ulasan -->
                                                <div class="modal fade" id="viewUlasanModal{{ $checkout->id }}" tabindex="-1" aria-labelledby="viewUlasanModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="viewUlasanModalLabel">Ulasan Anda</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>{{ $checkout->ulasan }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Tombol untuk memberi ulasan -->
                                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#ulasanModal{{ $checkout->id }}" title="Beri Ulasan">
                                                    <i class="fas fa-star"></i> Beri Ulasan
                                                </button>

                                                <!-- Modal untuk memberi ulasan -->
                                                <div class="modal fade" id="ulasanModal{{ $checkout->id }}" tabindex="-1" aria-labelledby="ulasanModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="ulasanModalLabel" style="font-size: 0.880rem;">Beri Ulasan</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('riwayatBelanja.simpanUlasan', $checkout->id) }}" method="POST">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <textarea class="form-control" id="ulasan" name="ulasan" rows="4" placeholder="Ketik Ulasan" required></textarea>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-success">Simpan Ulasan</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    @endif
                </div>
                {{-- selesai --}}
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

<div class="d-flex justify-content-center">
    {{ $riwayatBelanja->links() }}
</div>
@endsection
