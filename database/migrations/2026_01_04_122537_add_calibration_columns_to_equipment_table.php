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
            $table->date('last_calibration')->nullable(); // Tanggal kalibrasi terakhir
            $table->date('next_calibration')->nullable(); // Jadwal kalibrasi ulang
        });
    }

    public function down(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropColumn(['last_calibration', 'next_calibration']);
        });
    }
};
