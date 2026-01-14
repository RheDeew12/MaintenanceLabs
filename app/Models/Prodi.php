<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prodi extends Model
{
    // Sesuaikan dengan nama di phpMyAdmin Anda (pakai 's')
    protected $table = 'prodis'; 

    protected $fillable = ['nama_prodi'];

    public function laboratoriums(): HasMany
    {
        return $this->hasMany(Laboratorium::class, 'prodi_id');
    }
}