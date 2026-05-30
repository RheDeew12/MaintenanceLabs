<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        // 1. Bersihkan data NULL terlebih dahulu agar tidak melanggar NOT NULL
        DB::table('users')->whereNull('prodi_id')->update(['prodi_id' => 1]);

        Schema::table('users', function (Blueprint $table) {
            /** * 2. Hapus Foreign Key lama. 
             * Ini wajib karena MySQL tidak mengizinkan modifikasi kolom NOT NULL 
             * jika Foreign Key-nya masih memiliki aturan 'ON DELETE SET NULL'.
             */
            $table->dropForeign(['prodi_id']);
            
            // 3. Ubah struktur kolom menjadi NOT NULL dengan default '1' (TPK)
            $table->unsignedBigInteger('prodi_id')->default(1)->nullable(false)->change();

            /**
             * 4. Pasang kembali Foreign Key dengan aturan yang sesuai.
             * Gunakan 'cascade' agar sinkron dengan aturan NOT NULL.
             */
            $table->foreign('prodi_id')->references('id')->on('prodis')->onDelete('cascade');
        });
    }

    /**
     * Batalkan migrasi (Rollback).
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['prodi_id']);
            
            // Kembalikan menjadi nullable
            $table->unsignedBigInteger('prodi_id')->default(null)->nullable()->change();
            
            // Pasang kembali Foreign Key dengan aturan lama
            $table->foreign('prodi_id')->references('id')->on('prodis')->onDelete('set null');
        });
    }
};