<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk memperbarui struktur tabel peralatan (tbl_alat).
     */
    public function up(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            // 1. Kelompok Relasi (Foreign Keys)
            // Menghubungkan alat ke Lab (Prodi) dan Kategori teknis[cite: 10, 18].
            $table->foreignId('lab_id')->after('id')->constrained('laboratoriums')->onDelete('cascade')->comment('Menghubungkan ke Lab dan Prodi');
            $table->foreignId('kategori_id')->after('lab_id')->constrained('tbl_kategori')->onDelete('cascade')->comment('Menghubungkan ke Tabel Kategori');
            
            // 2. Kelompok Klasifikasi & Legalitas Aset
            // Menentukan fungsi alat (Pendidikan/Non-Pendidikan) dan nomor inventaris BMN.
            $table->enum('klasifikasi_fungsi', ['Pendidikan', 'Non-Pendidikan'])->default('Pendidikan')->after('kategori_id');
            $table->string('kode_aset')->nullable()->after('klasifikasi_fungsi')->comment('Nomor inventaris negara (BMN)');
            
            // 3. Kelompok Spesifikasi & Riwayat
            // Mencatat tahun perolehan untuk analisis depresiasi aset.
            $table->year('tahun_perolehan')->nullable()->after('merk');
            
            // 4. Kelompok Status & Identifikasi Visual
            // Digunakan untuk indikator warna pada dashboard Kaprodi (Normal/Rusak/Perbaikan)[cite: 18, 52].
            $table->enum('status_kondisi', ['Normal', 'Rusak Ringan', 'Rusak Berat', 'Perbaikan'])->default('Normal')->after('tahun_perolehan');
            $table->string('foto_alat')->nullable()->after('status_kondisi')->comment('Foto alat untuk identifikasi visual');
        });
    }

    /**
     * Batalkan migrasi (Rollback).
     */
    public function down(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            // Menghapus foreign key terlebih dahulu sebelum menghapus kolom
            $table->dropForeign(['lab_id']);
            $table->dropForeign(['kategori_id']);
            
            $table->dropColumn([
                'lab_id', 
                'kategori_id', 
                'klasifikasi_fungsi', 
                'kode_aset', 
                'status_kondisi', 
                'tahun_perolehan', 
                'foto_alat'
            ]);
        });
    }
};