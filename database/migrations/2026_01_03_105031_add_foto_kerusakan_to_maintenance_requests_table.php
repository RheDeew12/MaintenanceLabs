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
            // 1. Menambahkan bukti visual kerusakan 
            if (!Schema::hasColumn('maintenance_requests', 'foto_kerusakan')) {
                $table->string('foto_kerusakan')->nullable()->after('issue_description');
            }

            // 2. Menambahkan kolom rekomendasi teknis (untuk Tim Pemelihara) [cite: 14, 35]
            if (!Schema::hasColumn('maintenance_requests', 'technical_recommendation')) {
                $table->text('technical_recommendation')->nullable()->after('foto_kerusakan');
            }

            // 3. Menambahkan tipe perbaikan: Mandiri / Pihak Luar [cite: 15, 16, 35]
            if (!Schema::hasColumn('maintenance_requests', 'repair_type')) {
                $table->enum('repair_type', ['Internal', 'External'])->nullable()->after('technical_recommendation');
            }

            // 4. Menambahkan estimasi biaya (untuk persetujuan Pudir 2) [cite: 18, 36]
            if (!Schema::hasColumn('maintenance_requests', 'estimated_cost')) {
                $table->decimal('estimated_cost', 15, 2)->nullable()->after('repair_type');
            }

            // 5. Menambahkan catatan penolakan / komplain 
            if (!Schema::hasColumn('maintenance_requests', 'rejection_note')) {
                $table->text('rejection_note')->nullable()->after('estimated_cost');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenance_requests', function (Blueprint $table) {
            $table->dropColumn([
                'foto_kerusakan', 
                'technical_recommendation', 
                'repair_type', 
                'estimated_cost', 
                'rejection_note'
            ]);
        });
    }
};