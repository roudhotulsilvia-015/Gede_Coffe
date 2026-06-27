<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['kode_transaksi', 'total_harga', 'bayar', 'kembalian', 'user_id'];

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