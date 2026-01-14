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
     */
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    /**
     * PERBAIKAN UTAMA: Mengganti 'lab_id' menjadi 'id_lab'
     * Nama fungsi tetap 'equipment' agar sinkron dengan withCount di AdminController
     */
    public function equipment(): HasMany
    {
        // Parameter kedua HARUS 'id_lab' sesuai struktur tabel equipment Anda
        return $this->hasMany(Equipment::class, 'id_lab');
    }

    /**
     * Versi plural (opsional), juga dipastikan menggunakan kunci 'id_lab'
     */
    public function equipments(): HasMany
    {
        return $this->hasMany(Equipment::class, 'id_lab');
    }
}