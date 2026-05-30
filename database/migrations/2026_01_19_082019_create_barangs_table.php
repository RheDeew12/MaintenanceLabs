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
        if (!Schema::hasTable('barangs')) {
            Schema::create('barangs', function (Blueprint $table) {
                // Kolom id otomatis jadi yang pertama
                $table->id();
                
                // Urutan penulisan di sini akan menentukan urutan kolom di database
                $table->unsignedBigInteger('id_lab')->nullable(); 
                $table->string('nama_barang');
                $table->string('merk_tipe')->nullable();
                $table->string('kode_bmn')->unique();
                $table->integer('tahun_perolehan')->nullable();
                $table->string('kategori')->nullable();
                $table->string('status_kondisi')->default('Normal');
                $table->string('klasifikasi_fungsi')->default('Pendidikan');
                $table->string('foto_identifikasi')->nullable();
                $table->date('next_calibration')->nullable();
                $table->timestamps();

                // Foreign Key Constraint
                $table->foreign('id_lab')
                      ->references('id')
                      ->on('laboratoriums')
                      ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};