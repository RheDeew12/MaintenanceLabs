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
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel Users (Pelapor)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Relasi ke tabel Equipment (Alat)
            $table->foreignId('equipment_id')->constrained('equipment')->onDelete('cascade');
            
            // Detail Laporan dari Lab
            $table->text('issue_description');
            $table->enum('urgency', ['Low', 'Medium', 'High'])->default('Medium');
            $table->enum('damage_level', ['Ringan', 'Sedang', 'Berat'])->default('Ringan');
            
            // --- TAMBAHKAN KOLOM INI ---
            $table->timestamp('request_date')->useCurrent(); 
            // ---------------------------

            // Status Workflow
            $table->string('status')->default('pending_kaprodi');
            
            // Data Teknis (Diisi oleh Tim Pemelihara)
            $table->text('technical_recommendation')->nullable();
            $table->enum('repair_type', ['Internal', 'External'])->nullable();
            $table->decimal('estimated_cost', 15, 2)->nullable();
            $table->string('quotation_file')->nullable();
            
            // Catatan Penolakan (Jika status rejected)
            $table->text('rejection_note')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};