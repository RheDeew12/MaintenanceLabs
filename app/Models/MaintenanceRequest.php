<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $table = 'maintenance_requests';

    /**
     * Mass Assignment
     * UPDATE: Menambahkan kolom catatan Pudir 2 dan timestamp keputusan.
     */
    protected $fillable = [
        'user_id',
        'barang_id', 
        'id_lab', 
        'issue_description',
        'foto_kerusakan',
        'urgency',
        'damage_level',
        'request_date',
        'status',
        'technical_recommendation',
        'repair_type',
        'estimated_cost',
        'rejection_note', // Catatan penolakan umum (jika ada)
        'pudir2_note',    // <--- WAJIB ADA: Agar catatan Approve/Reject Pudir 2 tersimpan
        'approved_at_pudir2', // <--- WAJIB ADA: Untuk track waktu persetujuan
        'rejected_at'         // <--- WAJIB ADA: Untuk track waktu penolakan
    ];

    /**
     * Casting Data
     */
    protected $casts = [
        'request_date' => 'datetime',
        'estimated_cost' => 'decimal:2',
        'approved_at_pudir2' => 'datetime', // Tambahkan casting agar mudah diformat di Blade
        'rejected_at' => 'datetime',        // Tambahkan casting
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke Model Barang (Master Barang)
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    /**
     * Relasi ke Model Laboratorium
     */
    public function lab(): BelongsTo
    {
        return $this->belongsTo(Laboratorium::class, 'id_lab');
    }

    /**
     * Relasi ke Model User (Pelapor)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Accessor: Status Label
     * Digunakan untuk warna badge di dashboard.
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'closed' => 'success',
            'repairing', 'waiting_verification', 'ready_to_close' => 'warning',
            'rejected' => 'danger',
            'pending_kaprodi', 'pending_pudir1', 'pending_pudir2', 'checking_technical' => 'primary',
            default => 'secondary'
        };
    }

    /**
     * Accessor: Ticket ID (Formatted)
     * Mengubah ID database menjadi format TIC-0001.
     */
    public function getFormattedIdAttribute()
    {
        return 'TIC-' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }
}