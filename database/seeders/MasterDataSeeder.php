<?php

namespace Database\Seeders;

use App\Models\Prodi;
use App\Models\Laboratorium;
use App\Models\Kategori;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Update/Tambah Prodi 
        $prodi = Prodi::updateOrCreate(
            ['nama_prodi' => 'TPK'],
            ['nama_prodi' => 'TPK']
        );

        // 2. Update/Tambah Laboratorium 
        $lab = Laboratorium::updateOrCreate(
            ['nama_lab' => 'Lab Kimia', 'prodi_id' => $prodi->id],
            ['nama_lab' => 'Lab Kimia']
        );

        // 3. Update/Tambah Kategori
        $kategori = Kategori::updateOrCreate(
            ['nama_kategori' => 'Mesin Berat'],
            ['nama_kategori' => 'Mesin Berat']
        );

        // 4. Update/Tambah Peralatan
        Equipment::updateOrCreate(
            ['kode_aset' => 'BMN-2026-001'], // Unik berdasarkan nomor aset
            [
                'lab_id' => $lab->id,
                'kategori_id' => $kategori->id,
                'klasifikasi_fungsi' => 'Pendidikan', 
                'nama_alat' => 'Mesin Seset',
                'merk' => 'Fortuna',
                'status_kondisi' => 'Normal', 
                'tahun_perolehan' => 2020, 
            ]
        );

        // 5. Update/Tambah Users (Menghindari Duplicate Email)
        User::updateOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'kaprodi@mail.com'],
            [
                'name' => 'Kepala Prodi TPK',
                'password' => Hash::make('password'),
                'role' => 'Kaprodi', 
                'prodi_id' => $prodi->id,
            ]
        );
    }
}