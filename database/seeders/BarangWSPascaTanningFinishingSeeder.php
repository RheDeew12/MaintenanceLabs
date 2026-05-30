<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangWSPascaTanningFinishingSeeder extends Seeder
{
    public function run(): void
    {
        // Alokasi ke Workshop Pasca Tanning dan Finishing [ID Lab 5]
        $idLab = 5;

        $barangs = [
            // --- PERALATAN PRODUKSI & FINISHING (Halaman 1 & 2) ---
            ['nama' => 'Leather Measuring', 'merk' => 'Haian Weiguo 180', 'bmn' => '3080156999', 'nup' => 28, 'thn' => 2015],
            ['nama' => 'Buffing & Dedusting Machine', 'merk' => '1800 mm DONGXIN', 'bmn' => '3080156999', 'nup' => 35, 'thn' => 2016],
            ['nama' => 'Hydraulic Ironing & Embossing Press', 'merk' => '3H', 'bmn' => '3080156999', 'nup' => 36, 'thn' => 2016],
            ['nama' => 'Through Feed Stretching', 'merk' => 'RUGAO DONGXING GLRZ-160', 'bmn' => '3080156999', 'nup' => 34, 'thn' => 2016],
            
            // Mesin Glandstot / Glasing
            ['nama' => 'Mesin Glandstot', 'merk' => 'Mesin Glazing', 'bmn' => '3080137003', 'nup' => 1, 'thn' => 2013],
            ['nama' => 'Mesin Glandstot', 'merk' => 'Mesin Glazing', 'bmn' => '3080137003', 'nup' => 2, 'thn' => 2013],
            ['nama' => 'Mesin Glandstot', 'merk' => 'Mesin Glazing', 'bmn' => '3080137003', 'nup' => 3, 'thn' => 2013],

            // --- PERALATAN PENDUKUNG LABORATORIUM ---
            ['nama' => 'Exhaust System', 'merk' => '-', 'bmn' => '3080709016', 'nup' => 1, 'thn' => 2013],
            ['nama' => 'Exhaust System', 'merk' => '-', 'bmn' => '3080709016', 'nup' => 2, 'thn' => 2013],
            ['nama' => 'Peralatan Tukang Kulit Lainnya', 'merk' => 'FRAME PENTANG', 'bmn' => '3030210999', 'nup' => 31, 'thn' => 2015],
            ['nama' => 'Tabung Pemadam Api', 'merk' => 'MINIMAX', 'bmn' => '3050105001', 'nup' => 8, 'thn' => 1996],
            
            // Frame Synchronizer (Frame Ukur Kulit)
            ['nama' => 'Frame Synchronizer', 'merk' => 'Frame Ukur Kulit 150 x 90', 'bmn' => '3060102138', 'nup' => 1, 'thn' => 2013],
            ['nama' => 'Frame Synchronizer', 'merk' => 'Frame Ukur Kulit 150 x 90', 'bmn' => '3060102138', 'nup' => 2, 'thn' => 2013],
            ['nama' => 'Frame Synchronizer', 'merk' => 'Frame Ukur Kulit 150 x 90', 'bmn' => '3060102138', 'nup' => 3, 'thn' => 2013],

            // Alat Pengukur Luas Kulit (Frame/Meja Pentang)
            ['nama' => 'Alat Pengukur Luas Kulit', 'merk' => 'Frame Pentang Kayu', 'bmn' => '3080111083', 'nup' => 1, 'thn' => 2013],
            ['nama' => 'Alat Pengukur Luas Kulit', 'merk' => 'Frame Pentang Kayu', 'bmn' => '3080111083', 'nup' => 2, 'thn' => 2013],
            ['nama' => 'Alat Pengukur Luas Kulit', 'merk' => 'Meja Pentang Kayu', 'bmn' => '3080111083', 'nup' => 6, 'thn' => 2013],

            // --- ELEKTRONIK & MEBELAIR ---
            ['nama' => 'Kipas Angin', 'merk' => 'Kipas Angin Maspion 1809', 'bmn' => '3050204006', 'nup' => 46, 'thn' => 2023],
            ['nama' => 'Kipas Angin', 'merk' => 'Wall Fan Cosmos 16 Inch besi', 'bmn' => '3050204006', 'nup' => 50, 'thn' => 2024],
        ];

        foreach ($barangs as $val) {
            $this->saveBarang($idLab, $val['nama'], $val['merk'], $val['bmn'], $val['nup'], $val['thn']);
        }

        // --- PALANG KUDA (NUP 3, 5, 7, 25, 26, 9, 27) ---
        $palangKudaNups = [3, 5, 7, 25, 26, 9, 27];
        foreach ($palangKudaNups as $nup) {
            $this->saveBarang($idLab, 'Palang Kuda', '-', '3190103002', $nup, 2013);
        }

        // --- KURSI BESI/METAL (Massal) ---
        // Mencakup kursi di Workshop Frame Pentang & Glasing
        for ($nup = 1974; $nup <= 1976; $nup++) {
            $this->saveBarang($idLab, 'Kursi Besi/Metal', 'CHITOSE', '3050201003', $nup, 2012);
        }
        $this->saveBarang($idLab, 'Kursi Besi/Metal', 'CHITOSE', '3050201003', 2021, 2012);
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
                'status_kondisi' => 'Normal', // Sesuai standar untuk terbaca Siap Pakai
                'klasifikasi_fungsi' => 'Pendidikan',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    private function getKategori($bmn)
    {
        if (str_starts_with($bmn, '308') || str_starts_with($bmn, '306') || str_starts_with($bmn, '303')) {
            return 'Alat Laboratorium';
        }
        if (str_starts_with($bmn, '3050204')) return 'Elektronik';
        return 'Furnitur';
    }
}