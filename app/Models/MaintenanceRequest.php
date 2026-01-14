<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $table = 'maintenance_requests';

    // Gunakan fillable untuk keamanan Mass Assignment
    protected $fillable = [
        'user_id',
        'equipment_id',
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
        'rejection_note'
    ];

    /**
     * Casting Data
     */
    protected $casts = [
        'request_date' => 'datetime',
        'estimated_cost' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke Model Equipment
     */
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    /**
     * Relasi ke Model User (Pelapor)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Accessor untuk Warna Badge Status
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'closed' => 'success',
            'repairing' => 'warning',
            'rejected' => 'danger',
            'pending_kaprodi', 'pending_pudir1', 'pending_pudir2' => 'primary',
            default => 'secondary'
        };
    }

    /**
     * Accessor untuk Ticket ID (TIC-0001)
     */
    public function getFormattedIdAttribute()
    {
        return 'TIC-' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }
}