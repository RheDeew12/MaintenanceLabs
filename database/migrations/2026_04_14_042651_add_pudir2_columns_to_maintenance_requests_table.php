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
            // Catatan dari Pudir 2 (Bisa berupa instruksi Approve atau alasan Reject)
            if (!Schema::hasColumn('maintenance_requests', 'pudir2_note')) {
                $table->text('pudir2_note')->nullable()->after('status');
            }

            // Timestamp persetujuan Pudir 2
            if (!Schema::hasColumn('maintenance_requests', 'approved_at_pudir2')) {
                $table->timestamp('approved_at_pudir2')->nullable()->after('pudir2_note');
            }

            // Timestamp penolakan (Bisa oleh Kaprodi atau Pudir 2)
            if (!Schema::hasColumn('maintenance_requests', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('approved_at_pudir2');
            }

            // TAMBAHAN: Catatan penolakan umum jika Anda ingin membedakan note reject dan approve
            if (!Schema::hasColumn('maintenance_requests', 'reject_reason')) {
                $table->text('reject_reason')->nullable()->after('rejected_at');
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
                'pudir2_note', 
                'approved_at_pudir2', 
                'rejected_at', 
                'reject_reason'
            ]);
        });
    }
};