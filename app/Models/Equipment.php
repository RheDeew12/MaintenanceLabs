<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    use HasFactory;

    // Menetapkan nama tabel secara eksplisit
    protected $table = 'equipment'; 

    protected $fillable = [
        'nama_alat', 
        'kode_aset', 
        'merk', 
        'id_kategori', 
        'klasifikasi_fungsi', 
        'status_kondisi', 
        'id_lab',
        'tahun_perolehan',
        'foto_alat'
    ];

    /**
     * Relasi ke Laboratorium
     */
    public function lab(): BelongsTo
    {
        return $this->belongsTo(Laboratorium::class, 'id_lab');
    }

    /**
     * Relasi ke Kategori
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    /**
     * Relasi ke riwayat maintenance
     * PERBAIKAN: Menggunakan nama 'maintenanceRequests' agar sinkron dengan
     * pemanggilan eager loading di DashboardController::equipmentHistory
     */
    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(MaintenanceRequest::class, 'equipment_id');
    }
}