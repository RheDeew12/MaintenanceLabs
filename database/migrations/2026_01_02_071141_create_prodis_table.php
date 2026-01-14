<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    // 1. Buat tabel prodis
    Schema::create('prodis', function (Blueprint $table) {
        $table->id();
        $table->string('nama_prodi');
        $table->timestamps();
    });

    // 2. Lakukan UPDATE pada tabel users untuk menyambungkan prodi_id
    Schema::table('users', function (Blueprint $table) {
        $table->foreign('prodi_id')
              ->references('id')
              ->on('prodis')
              ->onDelete('set null'); // Jika prodi dihapus, user tetap ada tapi prodi_id jadi NULL
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['prodi_id']);
    });
    Schema::dropIfExists('prodis');
}
};