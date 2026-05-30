<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Barang extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'barangs';

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'id_lab', // Relasi lokasi unit (PENTING)
        'nama_barang',
        'merk_tipe',
        'kode_bmn',
        'tahun_perolehan',
        'kategori',
        'klasifikasi_fungsi',
        'foto_identifikasi',
        'status_kondisi', // Opsional: Untuk memantau alat Normal/Rusak
        'next_calibration' // Opsional: Untuk pemantauan jadwal kalibrasi
    ];

    /**
     * Relasi ke Laboratorium
     * Menjelaskan lokasi aset ini berada (TPK, TPPK, atau TPKP)
     */
    public function lab(): BelongsTo
    {
        return $this->belongsTo(Laboratorium::class, 'id_lab');
    }

    /**
     * Relasi ke MaintenanceRequest
     * Satu barang bisa memiliki banyak riwayat pengajuan maintenance
     */
    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(MaintenanceRequest::class, 'barang_id');
    }
}