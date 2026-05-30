<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        // Cek apakah prodi_id sudah ada, jika belum baru tambahkan
        if (!Schema::hasColumn('users', 'prodi_id')) {
            $table->foreignId('prodi_id')->nullable()->after('role')->constrained('prodis');
        }
        
        // Cek apakah lab_id sudah ada, jika belum baru tambahkan
        if (!Schema::hasColumn('users', 'lab_id')) {
            $table->foreignId('lab_id')->nullable()->after('prodi_id')->constrained('laboratoriums');
        }
    });
}

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['prodi_id']);
            $table->dropForeign(['lab_id']);
            $table->dropColumn(['prodi_id', 'lab_id']);
        });
    }
};