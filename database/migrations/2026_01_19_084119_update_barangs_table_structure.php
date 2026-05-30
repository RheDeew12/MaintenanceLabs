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
        Schema::table('barangs', function (Blueprint $table) {
            // 1. Cek dan Rename kolom jika masih menggunakan nama lama
            if (Schema::hasColumn('barangs', 'kode_barang')) {
                $table->renameColumn('kode_barang', 'kode_bmn');
            }

            // 2. Tambah kolom id_lab untuk sinkronisasi lokasi unit (PENTING)
            if (!Schema::hasColumn('barangs', 'id_lab')) {
                $table->unsignedBigInteger('id_lab')->nullable()->after('id');
                
                // Pasang Foreign Key ke tabel laboratoriums
                $table->foreign('id_lab')
                      ->references('id')
                      ->on('laboratoriums')
                      ->onDelete('cascade');
            }

            // 3. Tambah kolom baru lainnya dengan pengecekan aman
            if (!Schema::hasColumn('barangs', 'merk_tipe')) {
                $table->string('merk_tipe')->nullable()->after('nama_barang');
            }
            
            if (!Schema::hasColumn('barangs', 'kode_bmn') && !Schema::hasColumn('barangs', 'kode_barang')) {
                $table->string('kode_bmn')->unique()->after('merk_tipe');
            }

            if (!Schema::hasColumn('barangs', 'tahun_perolehan')) {
                $table->integer('tahun_perolehan')->nullable()->after('nama_barang'); 
            }

            if (!Schema::hasColumn('barangs', 'klasifikasi_fungsi')) {
                // Tambahkan pengecekan kolom 'kategori' untuk menghindari error 'after'
                $afterColumn = Schema::hasColumn('barangs', 'kategori') ? 'kategori' : 'nama_barang';
                $table->string('klasifikasi_fungsi')->default('Pendidikan')->after($afterColumn);
            }

            if (!Schema::hasColumn('barangs', 'foto_identifikasi')) {
                $table->string('foto_identifikasi')->nullable()->after('klasifikasi_fungsi');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            // Hapus Foreign Key dan Kolom id_lab
            if (Schema::hasColumn('barangs', 'id_lab')) {
                $table->dropForeign(['id_lab']);
                $table->dropColumn('id_lab');
            }

            if (Schema::hasColumn('barangs', 'kode_bmn')) {
                $table->renameColumn('kode_bmn', 'kode_barang');
            }

            $table->dropColumn([
                'merk_tipe', 
                'tahun_perolehan', 
                'klasifikasi_fungsi', 
                'foto_identifikasi'
            ]);
        });
    }
};