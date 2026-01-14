<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    // Tambahkan baris ini sesuai dokumen struktur tabel Anda [cite: 12]
    protected $table = 'tbl_kategori'; 

    protected $fillable = ['nama_kategori'];
}