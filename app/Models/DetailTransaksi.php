<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;

class DetailTransaksi extends Model
{
    protected $fillable = ['transaksi_id', 'produk_id', 'jumlah', 'subtotal'];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
