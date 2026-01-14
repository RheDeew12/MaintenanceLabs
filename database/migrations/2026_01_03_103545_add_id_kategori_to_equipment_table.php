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
        Schema::table('equipment', function (Blueprint $table) {
            // Tambahkan id_lab jika belum ada (FK ke tabel laboratorium) 
            if (!Schema::hasColumn('equipment', 'id_lab')) {
                $table->unsignedBigInteger('id_lab')->nullable()->after('id');
            }

            // Tambahkan id_kategori (FK ke tabel kategori) [cite: 68, 72]
            // Gunakan ->after('id_lab') hanya jika kita yakin id_lab sudah ada atau dibuat di atas
            $table->unsignedBigInteger('id_kategori')->nullable()->after('id_lab');

            // Tambahkan Klasifikasi Fungsi (Pendidikan/Non-Pendidikan) 
            if (!Schema::hasColumn('equipment', 'klasifikasi_fungsi')) {
                $table->enum('klasifikasi_fungsi', ['Pendidikan', 'Non-Pendidikan'])->nullable()->after('id_kategori');
            }

            // Tambahkan Tahun Perolehan 
            if (!Schema::hasColumn('equipment', 'tahun_perolehan')) {
                $table->year('tahun_perolehan')->nullable()->after('merk');
            }

            // Tambahkan Foto Alat 
            if (!Schema::hasColumn('equipment', 'foto_alat')) {
                $table->string('foto_alat')->nullable()->after('tahun_perolehan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropColumn(['id_lab', 'id_kategori', 'klasifikasi_fungsi', 'tahun_perolehan', 'foto_alat']);
        });
    }
};