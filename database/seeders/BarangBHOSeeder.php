<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangBHOSeeder extends Seeder
{
    public function run(): void
    {
        // Alokasi ke Workshop Beamhouse [ID 4]
        $idLab = 4;

        // --- 1. PERALATAN PRODUKSI & MESIN UTAMA (Halaman 4, 5, 6, 8, 9, 12) ---
        $peralatan = [
            // Pisau Kulit (NUP 1-40) - Diwakili karena jumlah banyak
            ['nama' => 'Pisau Kulit', 'merk' => '-', 'bmn' => '3030201001', 'nup' => 1, 'thn' => 2013],
            // ... (NUP 2 s/d 40 menggunakan helper di bawah)

            ['nama' => 'Heater (Home Use)', 'merk' => 'ARISTON', 'bmn' => '3050205002', 'nup' => 4, 'thn' => 2007],
            ['nama' => 'Gerobak Dorong Roda 3', 'merk' => '-', 'bmn' => '3050299999', 'nup' => 46, 'thn' => 2022],
            ['nama' => 'Timbangan Elektronik', 'merk' => 'DHUTO Kapasitas 150 kg', 'bmn' => '3080101009', 'nup' => 4, 'thn' => 2024],
            ['nama' => 'Alat Pengukur Luas Kulit', 'merk' => 'Meja Pentang Kayu', 'bmn' => '3080111083', 'nup' => 12, 'thn' => 2013],
            ['nama' => 'Hair Dryer/Spray Dryer', 'merk' => 'MP2612', 'bmn' => '3080111102', 'nup' => 1, 'thn' => 2022],
            ['nama' => 'Shrinkage Limit Test', 'merk' => 'Alat pengukur Suhu kerut Kulit', 'bmn' => '3080124030', 'nup' => 1, 'thn' => 2023],
            ['nama' => 'Mesin Shaving', 'merk' => 'ALPE SOLDANI Type W.W 300 mm', 'bmn' => '3080137007', 'nup' => 1, 'thn' => 2019],
            ['nama' => 'Mesin Shaving', 'merk' => 'FLAMAR Punta 5 of 1500MM', 'bmn' => '3080137007', 'nup' => 2, 'thn' => 2016],
            ['nama' => 'Mesin Flashing', 'merk' => 'HUAFEI GQR4-150B', 'bmn' => '3080137008', 'nup' => 1, 'thn' => 2013],
            ['nama' => 'Spliting Machine', 'merk' => 'HAIAN WEIGUO DCH GJA9-180', 'bmn' => '3080156999', 'nup' => 29, 'thn' => 2015],
            ['nama' => 'Through Feed Samming', 'merk' => 'GUOMAO JZQ400-48.57-1', 'bmn' => '3080156999', 'nup' => 30, 'thn' => 2016],
        ];

        foreach ($peralatan as $val) {
            $this->saveBarang($idLab, $val['nama'], $val['merk'], $val['bmn'], $val['nup'], 'Alat Laboratorium', $val['thn']);
        }

        // --- PISAU KULIT MASSAL (NUP 1-40) ---
        for ($nup = 1; $nup <= 40; $nup++) {
            $this->saveBarang($idLab, 'Pisau Kulit', '-', '3030201001', $nup, 'Alat Laboratorium', 2013);
        }

        // --- FRAME UKUR KULIT (NUP 4-12) ---
        foreach (range(4, 12) as $nup) {
            $merk = ($nup <= 10) ? 'Frame Ukur Kulit 150 x 90' : 'Frame Ukur Kulit 105 x 90';
            $this->saveBarang($idLab, 'Frame Synchronizer', $merk, '3060102138', $nup, 'Alat Laboratorium', 2013);
        }

        // --- DEAL TICKNESS GAUGE (NUP 7-13) ---
        foreach (range(7, 13) as $nup) {
            $merk = ($nup <= 11) ? 'Peacock 0,01mm' : 'Calati 0,1mm';
            $this->saveBarang($idLab, 'Deal Tickness Gauge', $merk, '3080138029', $nup, 'Alat Laboratorium', 2013);
        }

        // --- DRUM TRIAL / DRUM STAINLESS (Halaman 6 & 12) ---
        foreach (range(1, 7) as $nup) {
            $merk = ($nup <= 2) ? 'DRUM TRIAL' : '1000*80*1050';
            $thn = ($nup <= 2) ? 2015 : 2018;
            $this->saveBarang($idLab, 'Drum Stainless Steel', $merk, '3080151023', $nup, 'Alat Laboratorium', $thn);
        }

        // --- 2. MEBELAIR & FURNITUR (Halaman 4, 5, 8, 10, 11) ---
        $this->saveBarang($idLab, 'Lemari Besi/Metal', 'BROTHER', '3050104001', 39, 'Furnitur', 2013);
        $this->saveBarang($idLab, 'Rak Kayu', 'Rak Bahan Kimia', '3050104004', 8, 'Furnitur', 2015);
        $this->saveBarang($idLab, 'Locker', 'BROTHER 6 Pintu', '3050104015', 35, 'Furnitur', 2015);
        $this->saveBarang($idLab, 'Tabung Pemadam Api', 'MINIMAX', '3050105001', 9, 'Furnitur', 1996);

        // Meja Kerja Kayu
        foreach ([59, 89, 90, 138, 164, 165] as $nup) {
            $thn = ($nup <= 90) ? 1986 : (($nup == 138) ? 2011 : 2013);
            $this->saveBarang($idLab, 'Meja Kerja Kayu', '-', '3050201002', $nup, 'Furnitur', $thn);
        }

        // Kursi Besi/Metal CHITOSE
        foreach ([243, 244, 245, 246, 385, 386, 387] as $nup) {
            $thn = ($nup <= 246) ? 2007 : 2007; // Keduanya tercatat 2007 di sistem
            $this->saveBarang($idLab, 'Kursi Besi/Metal', 'CHITOSE', '3050201003', $nup, 'Furnitur', 2007);
        }

        // Kursi Kayu Praktek (NUP 517 s/d 607)
        for ($nup = 517; $nup <= 607; $nup++) {
            $this->saveBarang($idLab, 'Kursi Kayu', 'Kursi Praktek', '3050201004', $nup, 'Furnitur', 2015);
        }

        // --- 3. ELEKTRONIK & TIK (Halaman 5, 6, 8, 9, 12) ---
        $this->saveBarang($idLab, 'A.C. Split', 'panasonic 1,5pk/ PN12WKJ', '3050204004', 125, 'Elektronik', 2022);
        $this->saveBarang($idLab, 'P.C Unit', 'LENOVO Core I3', '3100102001', 85, 'Elektronik', 2011);
        $this->saveBarang($idLab, 'Printer', 'CANON', '3100203003', 74, 'Elektronik', 2013);
    }

    private function saveBarang($idLab, $nama, $merk, $bmn, $nup, $kat, $thn)
    {
        Barang::updateOrCreate(
            ['kode_bmn' => $bmn . '.' . $nup],
            [
                'id_lab' => $idLab,
                'nama_barang' => $nama,
                'merk_tipe' => $merk,
                'kategori' => $kat,
                'tahun_perolehan' => $thn,
                'status_kondisi' => 'Baik',
                'klasifikasi_fungsi' => 'Pendidikan',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}