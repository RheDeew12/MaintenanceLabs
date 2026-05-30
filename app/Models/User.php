<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'prodi_id',
        'lab_id'
    ];

    /**
     * Atribut yang disembunyikan untuk serialisasi (Security).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Pengaturan casting atribut untuk keamanan data.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke model Laboratorium (tabel laboratoriums).
     * Nama method diubah menjadi 'laboratorium' agar sinkron dengan file Blade.
     */
    public function laboratorium(): BelongsTo
    {
        // Relasi ini menghubungkan lab_id di tabel users ke id di tabel laboratoriums
        return $this->belongsTo(Laboratorium::class, 'lab_id');
    }

    /**
     * Relasi ke model Prodi (tabel prodis).
     * Digunakan oleh role Kaprodi untuk identifikasi Program Studi.
     */
    public function prodi(): BelongsTo
    {
        // Relasi ini menghubungkan prodi_id di tabel users ke id di tabel prodis
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }
}