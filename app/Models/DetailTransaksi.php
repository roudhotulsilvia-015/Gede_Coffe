<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;
// Model untuk detail transaksi yang berhubungan dengan produk.
class DetailTransaksi extends Model
{// Menentukan kolom yang dapat diisi secara massal.
    protected $fillable = ['transaksi_id', 'produk_id', 'jumlah', 'subtotal'];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
