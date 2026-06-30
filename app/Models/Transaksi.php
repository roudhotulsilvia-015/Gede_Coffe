<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// Model untuk transaksi yang berisi informasi dasar seperti kode transaksi, total harga, pembayaran, kembalian, dan user yang membuat transaksi.
class Transaksi extends Model
{// Menentukan kolom yang dapat diisi secara massal.
    protected $fillable = ['kode_transaksi', 'total_harga', 'bayar', 'kembalian', 'user_id'];
// Mendefinisikan relasi one-to-many dengan model DetailTransaksi.
    public function detail_transaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    /**
     * Get the kasir user who created this transaksi.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}