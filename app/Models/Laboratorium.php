<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Laboratorium extends Model
{
    // Memaksa nama tabel menjadi 'laboratoriums' agar sesuai dengan migrasi
    protected $table = 'laboratoriums'; 

    protected $fillable = ['prodi_id', 'nama_lab'];

    /**
     * Relasi ke model Prodi
     * Laboratorium berada di bawah naungan Program Studi (TPK, TPPK, atau TPKP)
     */
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    /**
     * RELASI UTAMA: Menghubungkan ke Model Barang
     * Menggunakan 'id_lab' sebagai Foreign Key sesuai struktur tabel barangs.
     * Fungsi ini dinamai 'barangs' agar standar Laravel (Plural).
     */
    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class, 'id_lab');
    }

    /**
     * ALIAS RELASI (Legacy Support):
     * Fungsi ini tetap disediakan dengan nama 'barang' agar withCount(['barang']) 
     * di AdminController tetap berjalan tanpa perlu mengubah banyak kode.
     */
    public function barang(): HasMany
    {
        return $this->hasMany(Barang::class, 'id_lab');
    }

    /**
     * Relasi ke MaintenanceRequest
     * Untuk melihat seluruh riwayat perbaikan yang terjadi di unit ini.
     */
    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(MaintenanceRequest::class, 'id_lab');
    }
}