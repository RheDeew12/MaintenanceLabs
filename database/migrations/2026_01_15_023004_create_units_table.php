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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            // Menambahkan kolom sesuai gambar
            $table->string('nama_lab'); // Untuk menyimpan Nama Lab / Workshop
            $table->string('prodi');    // Untuk menyimpan pilihan Prodi (TPK, TPPK, TPKP)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};