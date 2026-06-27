<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up() {
    Schema::create('transaksis', function (Blueprint $table) {
        $table->id();
        $table->string('kode_transaksi'); // Misal: TRX-20260626001
        $table->integer('total_harga');
        $table->integer('bayar');
        $table->integer('kembalian');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
