<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangTUKKulitSeeder extends Seeder
{
    public function run(): void
    {
        // Alokasi ke Workshop TUK Kulit [ID 12]
        $idLab = 12;

        $barangs = [
            // --- PERALATAN & INSTRUMEN UKUR ---
            ['nama' => 'Timbangan Cepat Kapasitas 200 Kg', 'merk' => '-', 'bmn' => '3030310010', 'nup' => 2, 'thn' => 2013],
            ['nama' => 'Frame Synchronizer', 'merk' => 'Frame Ukur Kulit 105 x 90', 'bmn' => '3060102138', 'nup' => 13, 'thn' => 2013],
            ['nama' => 'Frame Synchronizer', 'merk' => 'Frame Ukur Kulit 105 x 90', 'bmn' => '3060102138', 'nup' => 14, 'thn' => 2013],
            ['nama' => 'Frame Synchronizer', 'merk' => 'Frame Ukur Kulit 105 x 90', 'bmn' => '3060102138', 'nup' => 15, 'thn' => 2013],
            
            // Alat Pengukur Luas Kulit (Meja Pentang)
            ['nama' => 'Alat Pengukur Luas Kulit', 'merk' => 'Meja Pentang Kayu', 'bmn' => '3080111083', 'nup' => 7, 'thn' => 2013],
            ['nama' => 'Alat Pengukur Luas Kulit', 'merk' => 'Meja Pentang Kayu', 'bmn' => '3080111083', 'nup' => 8, 'thn' => 2013],
            ['nama' => 'Alat Pengukur Luas Kulit', 'merk' => 'Meja Pentang Kayu', 'bmn' => '3080111083', 'nup' => 13, 'thn' => 2013],
            ['nama' => 'Alat Pengukur Luas Kulit', 'merk' => 'Meja Pentang Kayu', 'bmn' => '3080111083', 'nup' => 14, 'thn' => 2013],
            ['nama' => 'Alat Pengukur Luas Kulit', 'merk' => 'Meja Pentang Kayu', 'bmn' => '3080111083', 'nup' => 15, 'thn' => 2013],

            // --- MEBELAIR ---
            ['nama' => 'Rak Besi', 'merk' => 'Rak Besi', 'bmn' => '3050104003', 'nup' => 20, 'thn' => 2015],
            ['nama' => 'Rak Kayu', 'merk' => '-', 'bmn' => '3050104004', 'nup' => 3, 'thn' => 2011],
            ['nama' => 'Rak Kayu', 'merk' => '-', 'bmn' => '3050104004', 'nup' => 4, 'thn' => 2011],
            ['nama' => 'Kursi Besi/Metal', 'merk' => 'FUTURA 747', 'bmn' => '3050201003', 'nup' => 1481, 'thn' => 2015],

            // --- ELEKTRONIK ---
            ['nama' => 'Kipas Angin', 'merk' => 'Kipas Angin Maspion (Lab TUK Kampus 1)', 'bmn' => '3050204006', 'nup' => 57, 'thn' => 2024],
            ['nama' => 'Kipas Angin', 'merk' => 'Kipas Angin Maspion (Lab TUK Kampus 1)', 'bmn' => '3050204006', 'nup' => 58, 'thn' => 2024],
            ['nama' => 'Kipas Angin', 'merk' => 'Kipas Angin (Lab TUK Kampus 1)', 'bmn' => '3050204006', 'nup' => 59, 'thn' => 2024],
        ];

        foreach ($barangs as $val) {
            $this->saveBarang($idLab, $val['nama'], $val['merk'], $val['bmn'], $val['nup'], $val['thn']);
        }

        // --- KURSI BESI/METAL CHITOSE (NUP 464 - 472) ---
        for ($nup = 464; $nup <= 472; $nup++) {
            $this->saveBarang($idLab, 'Kursi Besi/Metal', 'CHITOSE', '3050201003', $nup, 2007);
        }

        // --- KURSI KAYU PRAKTEK (NUP 724 - 733) ---
        for ($nup = 724; $nup <= 733; $nup++) {
            $this->saveBarang($idLab, 'Kursi Kayu', 'Kursi Praktek', '3050201004', $nup, 2015);
        }

        // --- PALANG KUDA (NUP 15 - 40) ---
        // Mencakup NUP 15-19, 29-30, 33-40 sesuai rincian PDF
        $palangKudaNups = array_merge(range(15, 19), [29, 30], range(33, 40));
        foreach ($palangKudaNups as $nup) {
            $this->saveBarang($idLab, 'Palang Kuda', '-', '3190103002', $nup, 2013);
        }
    }

    private function saveBarang($idLab, $nama, $merk, $bmn, $nup, $thn)
    {
        Barang::updateOrCreate(
            ['kode_bmn' => $bmn . '.' . $nup],
            [
                'id_lab' => $idLab,
                'nama_barang' => $nama,
                'merk_tipe' => $merk,
                'kategori' => $this->getKategori($bmn),
                'tahun_perolehan' => $thn,
                'status_kondisi' => 'Baik',
                'klasifikasi_fungsi' => 'Pendidikan',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    private function getKategori($bmn)
    {
        if (str_starts_with($bmn, '303') || str_starts_with($bmn, '308') || str_starts_with($bmn, '306')) return 'Alat Laboratorium';
        if (str_starts_with($bmn, '3050204')) return 'Elektronik';
        return 'Furnitur';
    }
}