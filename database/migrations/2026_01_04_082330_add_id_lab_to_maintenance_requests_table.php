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
        Schema::table('maintenance_requests', function (Blueprint $table) {
            // Menambahkan kolom id_lab setelah equipment_id agar struktur tabel rapi
            $table->unsignedBigInteger('id_lab')->nullable()->after('equipment_id');
            
            // Opsional: Jika Anda ingin memastikan integritas data dengan tabel laboratoriums
            // $table->foreign('id_lab')->references('id')->on('laboratoriums')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenance_requests', function (Blueprint $table) {
            // Menghapus kolom jika migrasi di-rollback
            $table->dropColumn('id_lab');
        });
    }
};