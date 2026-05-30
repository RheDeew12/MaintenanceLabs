<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Langkah 1: Buat kolomnya dulu
        if (!Schema::hasColumn('maintenance_requests', 'barang_id')) {
            Schema::table('maintenance_requests', function (Blueprint $table) {
                $table->unsignedBigInteger('barang_id')->nullable()->after('id');
            });
        }

        /**
         * Langkah 2: Buat Foreign Key dengan pengecekan tabel referensi.
         * Kita membungkusnya dalam pengecekan Schema::hasTable untuk memastikan
         * tabel 'barangs' sudah ada di database sebelum memasang constraint.
         */
        if (Schema::hasTable('barangs')) {
            Schema::table('maintenance_requests', function (Blueprint $table) {
                // Gunakan try-catch untuk menghindari error jika FK sudah ada
                try {
                    $table->foreign('barang_id')
                          ->references('id')
                          ->on('barangs')
                          ->onDelete('cascade');
                } catch (\Exception $e) {
                    // Abaikan jika constraint sudah ada
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('maintenance_requests', function (Blueprint $table) {
            // Pastikan foreign key dihapus sebelum kolomnya
            if (Schema::hasColumn('maintenance_requests', 'barang_id')) {
                // Gunakan try-catch karena dropForeign akan error jika FK tidak ditemukan
                try {
                    $table->dropForeign(['barang_id']);
                } catch (\Exception $e) {}
                
                $table->dropColumn('barang_id');
            }
        });
    }
};