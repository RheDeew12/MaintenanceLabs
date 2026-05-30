<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('maintenance_requests', function (Blueprint $table) {
            // Hapus foreign key lama terlebih dahulu jika ada
            try {
                $table->dropForeign(['equipment_id']);
            } catch (\Exception $e) {}

            // Hapus kolom yang menyebabkan error
            $table->dropColumn('equipment_id');
        });
    }

    public function down(): void
    {
        Schema::table('maintenance_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('equipment_id')->nullable();
        });
    }
};