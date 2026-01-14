<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Nama tabel diubah menjadi tbl_kategori sesuai struktur 
        Schema::create('tbl_kategori', function (Blueprint $table) {
            $table->id(); // PK [cite: 14]
            $table->string('nama_kategori'); // Contoh: Mesin Berat, Alat Gelas [cite: 15]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_kategori');
    }
};