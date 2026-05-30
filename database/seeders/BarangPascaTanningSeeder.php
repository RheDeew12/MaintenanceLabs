<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangPascaTanningSeeder extends Seeder
{
    public function run(): void
    {
        // Alokasi ke Workshop Pasca Tanning & Finishing [ID 5]
        $idLab = 5;

        // --- 1. PERALATAN PRODUKSI & LAB (Spray Gun, Drum, Hair Dryer, dll) ---
        
        // Spray Gun (NUP 9-11, 14-20) 
        $sprayGuns = [
            ['nup' => 9, 'merk' => 'MEIJI F 75'], ['nup' => 10, 'merk' => 'MEIJI F 75'], ['nup' => 11, 'merk' => 'MEIJI F 75'],
            ['nup' => 14, 'merk' => 'MEIJI F100'], ['nup' => 15, 'merk' => 'MEIJI F100'], ['nup' => 16, 'merk' => 'MEIJI F100'],
            ['nup' => 17, 'merk' => 'MEIJI F 75 SYIPON'], ['nup' => 18, 'merk' => 'MEIJI F 75 SYIPON'], 
            ['nup' => 19, 'merk' => 'KODENKA F 75 SYIPON'], ['nup' => 20, 'merk' => 'MEIJI F 75 SYIPON'],
        ];
        foreach ($sprayGuns as $sg) {
            $this->saveBarang($idLab, 'Spray Gun', $sg['merk'], '3080111058', $sg['nup'], 'Alat Laboratorium', 2017);
        }

        // Deal Tickness Gauge (NUP 1-4, 14-16) 
        foreach ([1, 2, 3, 4, 14, 15, 16] as $nup) {
            $merk = ($nup == 1) ? 'Calati 0,1mm' : 'Peacock 0,01mm';
            $this->saveBarang($idLab, 'Deal Tickness Gauge', $merk, '3080138029', $nup, 'Alat Laboratorium', 2013);
        }

        // Hair Dryer / Dryer (NUP 2-3) 
        foreach ([2, 3] as $nup) {
            $this->saveBarang($idLab, 'Hair Dryer/Spray Dryer/Dryer', 'MP2612', '3080111102', $nup, 'Alat Laboratorium', 2022);
        }

        // Mesin Drum Pemasak Kulit (NUP 6-8, 14-17, 20-24) 
        foreach ([6, 7, 8, 14, 15, 16, 17, 20, 21, 22, 23, 24] as $nup) {
            $thn = ($nup >= 20) ? 2013 : 2001;
            $this->saveBarang($idLab, 'Mesin Drum Pemasak Kulit', '-', '3080137001', $nup, 'Alat Laboratorium', $thn);
        }

        // Gentong Plastik (NUP 9-20) 
        for ($nup = 9; $nup <= 20; $nup++) {
            $this->saveBarang($idLab, 'Gentong Plastik', '-', '3080151022', $nup, 'Alat Laboratorium', 2013);
        }

        // Palang Kuda (NUP 2, 4, 12, 13, 14, 28, 31, 32) 
        foreach ([2, 4, 12, 13, 14, 28, 31, 32] as $nup) {
            $this->saveBarang($idLab, 'Palang Kuda', '-', '3190103002', $nup, 'Alat Laboratorium', 2013);
        }

        // --- 2. PERALATAN WORKSHOP LAINNYA ---
        
        // Mesin Kompresor (NUP 5-6) 
        foreach ([5, 6] as $nup) {
            $this->saveBarang($idLab, 'Mesin Kompresor', 'KOMPRESOR', '3030101018', $nup, 'Alat Laboratorium', 2015);
        }

        // Mechanic Heater / Heater Toggling (NUP 1-2) 
        foreach ([1, 2] as $nup) {
            $this->saveBarang($idLab, 'Mechanic Heater', 'Heater Mesin Toggling', '3080156093', $nup, 'Alat Laboratorium', 2013);
        }

        // Meja Pentang / Pengukur Luas Kulit [cite: 17, 18]
        foreach ([9, 10, 11] as $nup) {
            $this->saveBarang($idLab, 'Alat Pengukur Luas Kulit', 'Meja Pentang Kayu', '3080111083', $nup, 'Alat Laboratorium', 2013);
        }
        foreach ([3, 4, 5] as $nup) {
            $this->saveBarang($idLab, 'Alat Pengukur Luas Kulit', 'Frame Pentang Kayu', '3080111083', $nup, 'Alat Laboratorium', 2013);
        }

        // --- 3. MEBELAIR & ELEKTRONIK (Halaman 1-5) ---
        
        // Locker Brother 6 Pintu (NUP 29-34) 
        for ($nup = 29; $nup <= 34; $nup++) {
            $this->saveBarang($idLab, 'Locker', 'BROTHER 6 Pintu', '3050104015', $nup, 'Furnitur', 2013);
        }

        // Bangku Panjang Besi (NUP 61-65) 
        foreach ([61, 62, 63, 64, 65] as $nup) {
            $merk = ($nup == 65) ? 'Bangku Panjang Besi Cor' : 'Bangku Panjang Besi Hollow';
            $this->saveBarang($idLab, 'Bangku Panjang Besi/Metal', $merk, '3050201006', $nup, 'Furnitur', 2019);
        }

        // Elektronik Pendukung (AC, Kipas, Exhaust) [cite: 17, 18]
        $this->saveBarang($idLab, 'A.C. Split', 'SAMSUNG', '3050204004', 6, 'Elektronik', 2012);
        $this->saveBarang($idLab, 'A.C. Split', 'Panasonic/CS-PC12QKJ', '3050204004', 25, 'Elektronik', 2013);
        $this->saveBarang($idLab, 'Exhause Fan', 'panasonic/FV-40 FAU', '3050204007', 18, 'Elektronik', 2022);
        $this->saveBarang($idLab, 'Exhause Fan', 'panasonic/FV-40 FAU', '3050204007', 19, 'Elektronik', 2022);
        
        // Tabung Pemadam Api [cite: 17, 18]
        $this->saveBarang($idLab, 'Tabung Pemadam Api', 'MINIMAX', '3050105001', 2, 'Alat Laboratorium', 1996);
        $this->saveBarang($idLab, 'Tabung Pemadam Api', 'YAMATO', '3050105001', 1, 'Alat Laboratorium', 1996);
    }

    /**
     * Helper untuk menyimpan data barang
     */
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