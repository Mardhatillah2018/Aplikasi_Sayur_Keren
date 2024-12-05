<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    // Nama tabel (opsional, jika nama tabel tidak sesuai dengan konvensi Laravel)
    protected $table = 'checkouts';

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'user_id',
        'alamat_pengiriman',
        'latitude',
        'longitude',
        'total_harga',
        'ongkir',
        'diskon',
        'produk_details',
        'tanggal_pemesanan',
        'status',
        'bukti_transfer',
        'catatan_admin',
        'ulasan'
    ];

    protected $attributes = [
        'status' => 'diterima',  // Default status
    ];

    // Casting kolom untuk mempermudah manipulasi data
    protected $casts = [
        'produk_details' => 'array', // Konversi JSON menjadi array
        'tanggal_pemesanan' => 'datetime', // Format datetime
    ];

    // Relasi dengan model Pengguna (relasi ke tabel pengguna)
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'user_id');
    }

}
