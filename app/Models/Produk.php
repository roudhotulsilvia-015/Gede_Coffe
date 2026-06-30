<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// Model untuk produk yang berisi informasi dasar seperti nama produk, kategori, harga, dan stok.
class Produk extends Model
{// Menentukan kolom yang dapat diisi secara massal.
    protected $fillable = ['nama_produk', 'kategori', 'harga', 'stok'];
}