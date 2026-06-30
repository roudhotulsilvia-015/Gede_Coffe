<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// Migration untuk membuat tabel karyawans yang digunakan untuk menyimpan data karyawan.
return new class extends Migration
{
    // Run the migrations.
    public function up(): void
{// Membuat tabel karyawans untuk menyimpan data karyawan.
    Schema::create('karyawans', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('jabatan');
        $table->string('telepon');
        $table->timestamps();
    });
}

    // Reverse the migrations.
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
