<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangJahitSepatuSeeder extends Seeder
{
    public function run(): void
    {
        // Alokasi ke Workshop Jahit Sepatu [ID 9] berdasarkan daftar aset resmi
        $idLabJahit = 9;

        $barangs = [
            // --- MESIN JAHIT & SESET (Halaman 1) ---
            ['nama' => 'Mesin Jahit (Cangklong)', 'merk' => 'TYPICAL GC 2603', 'bmn' => '3030101016', 'nup' => '66', 'kat' => 'Alat Laboratorium', 'thn' => 2013],
            ['nama' => 'Mesin Jahit (Cangklong)', 'merk' => 'TYPICAL GC 2603', 'bmn' => '3030101016', 'nup' => '77', 'kat' => 'Alat Laboratorium', 'thn' => 2013],
            ['nama' => 'Mesin Jahit (Cangklong)', 'merk' => 'GOLDEN WHEEL CS-810', 'bmn' => '3030101017', 'nup' => '3', 'kat' => 'Alat Laboratorium', 'thn' => 2013],
            ['nama' => 'Mesin Jahit (Cangklong)', 'merk' => 'GOLDEN WHEEL CS-810', 'bmn' => '3030101017', 'nup' => '4', 'kat' => 'Alat Laboratorium', 'thn' => 2013],
            ['nama' => 'Mesin Seset Kulit (Skiving)', 'merk' => 'TYPICAL', 'bmn' => '3030102004', 'nup' => '1', 'kat' => 'Alat Laboratorium', 'thn' => 2013],
            ['nama' => 'Mesin Seset Kulit (Skiving)', 'merk' => 'TYPICAL', 'bmn' => '3030102004', 'nup' => '2', 'kat' => 'Alat Laboratorium', 'thn' => 2013],

            // --- PERALATAN KANTOR & ELEKTRONIK (Halaman 3 - 5) ---
            ['nama' => 'A.C. Split', 'merk' => 'Panasonic 1,5pk/PN12WKJ', 'bmn' => '3050204004', 'nup' => '125', 'kat' => 'Elektronik', 'thn' => 2022],
            ['nama' => 'Kipas Angin Gantung', 'merk' => 'PANASONIC', 'bmn' => '3050204006', 'nup' => '36', 'kat' => 'Elektronik', 'thn' => 2015],
            ['nama' => 'Kipas Angin Gantung', 'merk' => 'PANASONIC', 'bmn' => '3050204006', 'nup' => '37', 'kat' => 'Elektronik', 'thn' => 2015],
            ['nama' => 'P.C Unit (Peralatan Personal Komputer)', 'merk' => 'LENOVO Core i3', 'bmn' => '3100102001', 'nup' => '85', 'kat' => 'Elektronik', 'thn' => 2011],
            ['nama' => 'Printer (Peralatan Personal Komputer)', 'merk' => 'CANON', 'bmn' => '3100203003', 'nup' => '74', 'kat' => 'Elektronik', 'thn' => 2013],

            // --- MEBELAIR / FURNITUR (Halaman 2 - 3) ---
            ['nama' => 'Papan Tulis/White Board', 'merk' => '-', 'bmn' => '3050105010', 'nup' => '40', 'kat' => 'Furnitur', 'thn' => 2013],
            ['nama' => 'Meja Kerja Kayu', 'merk' => '-', 'bmn' => '3050201002', 'nup' => '164', 'kat' => 'Furnitur', 'thn' => 2013],
            ['nama' => 'Meja Kerja Kayu', 'merk' => '-', 'bmn' => '3050201002', 'nup' => '165', 'kat' => 'Furnitur', 'thn' => 2013],
        ];

        foreach ($barangs as $val) {
            // Kode unik menggunakan format KodeBMN.NUP sesuai standar administrasi [16]
            $kodeUnik = $val['bmn'] . '.' . $val['nup'];

            Barang::updateOrCreate(
                ['kode_bmn' => $kodeUnik], 
                [
                    'id_lab' => $idLabJahit,
                    'nama_barang' => $val['nama'],
                    'merk_tipe' => $val['merk'],
                    'kategori' => $val['kat'],
                    'tahun_perolehan' => $val['thn'],
                    'status_kondisi' => 'Baik', 
                    'klasifikasi_fungsi' => 'Pendidikan',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // --- DATA MASSAL: Kursi Besi/Metal Chitose (Halaman 3) ---
        // Mencakup NUP 447 sampai 455 sesuai daftar aset workshop [16]
        for ($nup = 447; $nup <= 455; $nup++) {
            Barang::updateOrCreate(
                ['kode_bmn' => '3050201003.' . $nup],
                [
                    'id_lab' => $idLabJahit,
                    'nama_barang' => 'Kursi Besi/Metal',
                    'merk_tipe' => 'CHITOSE',
                    'kategori' => 'Furnitur',
                    'tahun_perolehan' => 2007,
                    'status_kondisi' => 'Baik',
                    'klasifikasi_fungsi' => 'Pendidikan',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // --- DATA MASSAL: Locker Brother (Halaman 2) ---
        // Mencakup NUP 35 sampai 37 sesuai daftar aset workshop [16]
        for ($nup = 35; $nup <= 37; $nup++) {
            Barang::updateOrCreate(
                ['kode_bmn' => '3050105001.' . $nup],
                [
                    'id_lab' => $idLabJahit,
                    'nama_barang' => 'Locker',
                    'merk_tipe' => 'BROTHER 6 Pintu',
                    'kategori' => 'Furnitur',
                    'tahun_perolehan' => 2015,
                    'status_kondisi' => 'Baik',
                    'klasifikasi_fungsi' => 'Pendidikan',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}