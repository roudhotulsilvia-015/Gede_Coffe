<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// Migration untuk menambahkan kolom kategori pada tabel produks yang digunakan untuk menyimpan data kategori produk.
return new class extends Migration
{
    // Run the migrations.
   public function up() {
    Schema::table('produks', function (Blueprint $table) {
        $table->string('kategori')->after('nama_produk');
    });
}
// Reverse the migrations.
    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            //
        });
    }
};
