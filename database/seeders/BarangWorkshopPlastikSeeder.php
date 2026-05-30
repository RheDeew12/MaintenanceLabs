<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangWorkshopPlastikSeeder extends Seeder
{
    public function run(): void
    {
        // Alokasi ke Workshop Plastik [ID 17]
        $idLab = 17;

        $barangs = [
            // --- DATA PERALATAN PRODUKSI & LABORATORIUM (Halaman 1, 5, 12) ---
            ['nama' => 'Mesin Kompresor', 'merk' => 'shark/LVU 5112 0,5 HP', 'bmn' => '3030101018', 'nup' => 9, 'thn' => 2022],
            ['nama' => 'Gantry Crane', 'merk' => 'Gantry Care beban maksimal 3 ton', 'bmn' => '3080123012', 'nup' => 1, 'thn' => 2024],
            ['nama' => 'Mesin Molding Injection', 'merk' => 'Asian Plastic Machinery SM 90 HCV', 'bmn' => '3080137010', 'nup' => 1, 'thn' => 2018],
            ['nama' => 'Mesin Molding Injection', 'merk' => 'Suzhou Tongda Machinery HTS-5L/1', 'bmn' => '3080137010', 'nup' => 2, 'thn' => 2019],
            ['nama' => 'Modified Mold', 'merk' => 'Mold Produk Teknis', 'bmn' => '3080108026', 'nup' => 1, 'thn' => 2019],
            ['nama' => 'Modified Mold', 'merk' => 'Mold Produk Teknis', 'bmn' => '3080108026', 'nup' => 2, 'thn' => 2019],
            ['nama' => 'Unit Alat Laboratorium Lainnya', 'merk' => 'Dudukan mesin hopper dryer injection molding', 'bmn' => '3080199999', 'nup' => 18, 'thn' => 2024],

            // --- DATA MEBELAIR & RUANGAN (Halaman 1, 4, 5) ---
            ['nama' => 'Filing Cabinet Besi', 'merk' => 'ELITE', 'bmn' => '3050104005', 'nup' => 26, 'thn' => 1985],
            ['nama' => 'Filing Cabinet Besi', 'merk' => 'BROTHER', 'bmn' => '3050104005', 'nup' => 34, 'thn' => 1996],
            ['nama' => 'Rak Besi', 'merk' => 'Rak Besi Lab Plastik', 'bmn' => '3050104003', 'nup' => 18, 'thn' => 2024],
            ['nama' => 'Locker', 'merk' => 'DATAFILE', 'bmn' => '3050104015', 'nup' => 11, 'thn' => 2007],
            ['nama' => 'Papan Gambar', 'merk' => 'PAPAN TULIS KACA', 'bmn' => '3050105061', 'nup' => 14, 'thn' => 2016],
            ['nama' => 'Meja Kerja Kayu', 'merk' => 'meja kayu', 'bmn' => '3050201002', 'nup' => 355, 'thn' => 2022],
            ['nama' => 'Meja Komputer', 'merk' => 'GRACE 68', 'bmn' => '3050201009', 'nup' => 15, 'thn' => 2012],
            
            // --- ELEKTRONIK & TIK (Halaman 5, 12) ---
            ['nama' => 'A.C. Split', 'merk' => 'Panasonic 2PK', 'bmn' => '3050204004', 'nup' => 89, 'thn' => 2015],
            ['nama' => 'Kipas Angin', 'merk' => 'Wall Fan Cosmos 16 Inch besi', 'bmn' => '3050204006', 'nup' => 51, 'thn' => 2024],
            ['nama' => 'Kipas Angin', 'merk' => 'Wall Fan Cosmos 16 Inch besi', 'bmn' => '3050204006', 'nup' => 52, 'thn' => 2024],
            ['nama' => 'P.C Unit', 'merk' => 'LENOVO Core I3', 'bmn' => '3100102001', 'nup' => 77, 'thn' => 2011],
            ['nama' => 'Printer', 'merk' => 'CANON', 'bmn' => '3100203003', 'nup' => 71, 'thn' => 2013],
        ];

        foreach ($barangs as $val) {
            $this->saveBarang($idLab, $val['nama'], $val['merk'], $val['bmn'], $val['nup'], $val['thn']);
        }

        // --- EXHAUSE FAN PANASONIC (NUP 11 s/d 17) ---
        for ($nup = 11; $nup <= 17; $nup++) {
            $this->saveBarang($idLab, 'Exhause Fan', 'PANASONIC Diameter 25cm', '3050204007', $nup, 2015);
        }

        // --- KURSI BESI CHITOSE (NUP 266-267, 551-554, 918-923, 932-941) ---
        $chitoseNups = [266, 267, 551, 552, 553, 554, 918, 919, 920, 921, 922, 923, 932, 933, 934, 935, 936, 937, 938, 939, 940, 941];
        foreach ($chitoseNups as $nup) {
            $this->saveBarang($idLab, 'Kursi Besi/Metal', 'CHITOSE', '3050201003', $nup, 2005);
        }

        // --- KURSI BESI FUTURA (NUP 1419-1430, 1461-1462, 1483-1485) ---
        $futuraNups = array_merge(range(1419, 1430), [1461, 1462, 1483, 1484, 1485]);
        foreach ($futuraNups as $nup) {
            $this->saveBarang($idLab, 'Kursi Besi/Metal', 'FUTURA 747', '3050201003', $nup, 2013);
        }

        // --- KURSI KAYU PRAKTEK (NUP 703-707) ---
        for ($nup = 703; $nup <= 707; $nup++) {
            $this->saveBarang($idLab, 'Kursi Kayu', 'Kursi Praktek', '3050201004', $nup, 2015);
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
                'kategori' => $this->getKat($bmn),
                'tahun_perolehan' => $thn,
                'status_kondisi' => 'Baik',
                'klasifikasi_fungsi' => 'Pendidikan',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    private function getKat($bmn) {
        if (str_starts_with($bmn, '303') || str_starts_with($bmn, '308')) return 'Alat Laboratorium';
        if (str_starts_with($bmn, '3050204') || str_starts_with($bmn, '310')) return 'Elektronik';
        return 'Furnitur';
    }
}