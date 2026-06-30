<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// Migration untuk menambahkan kolom user_id pada tabel transaksis yang digunakan untuk menyimpan data ID pengguna yang melakukan transaksi.
return new class extends Migration
{
    // Run the migrations.
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            if (! Schema::hasColumn('transaksis', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            }
        });
    }

   // Reverse the migrations.
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            if (Schema::hasColumn('transaksis', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};