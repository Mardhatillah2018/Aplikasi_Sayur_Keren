<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $fillable = ['pengguna_id', 'produk_id', 'jumlah', 'harga'];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class);
    }
}