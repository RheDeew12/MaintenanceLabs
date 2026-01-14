<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // WAJIB DITAMBAHKAN

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Bersihkan data NULL terlebih dahulu secara manual
        // Ini memastikan tidak ada baris yang melanggar aturan NOT NULL nantinya
        DB::table('users')->whereNull('prodi_id')->update(['prodi_id' => 1]);

        // 2. Ubah struktur kolom
        Schema::table('users', function (Blueprint $table) {
            // Menggunakan change() membutuhkan package doctrine/dbal jika Laravel < 10
            // nullable(false) memastikan kolom tidak boleh kosong di masa depan
            $table->unsignedBigInteger('prodi_id')->default(1)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('prodi_id')->default(null)->nullable()->change();
        });
    }
};