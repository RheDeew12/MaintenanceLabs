<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangLabLimbahSeeder extends Seeder
{
    public function run(): void
    {
        // Alokasi ke Laboratorium Limbah dan UPAL [ID 2]
        $idLab = 2;

        // --- 1. INSTRUMEN & PERALATAN LABORATORIUM UTAMA (Halaman 4, 6, 9) ---
        $peralatanLab = [
            ['nama' => 'Mesin Press Hidrolik & Punch', 'merk' => '-', 'bmn' => '3030101004', 'nup' => 1, 'thn' => 2013],
            ['nama' => 'PH Meter (Alat Ukur Universal)', 'merk' => 'Lutron PH-207', 'bmn' => '3030301029', 'nup' => 11, 'thn' => 2013],
            ['nama' => 'PH Meter (Alat Ukur Universal)', 'merk' => 'Lutron Digital PH Meter PH-208', 'bmn' => '3030301029', 'nup' => 12, 'thn' => 2013],
            ['nama' => 'Recovery Chrome (Alat Lab Hidrokimia)', 'merk' => '-', 'bmn' => '3080103999', 'nup' => 1, 'thn' => 2024],
            ['nama' => 'Oven Lab Limbah', 'merk' => '-', 'bmn' => '3080111005', 'nup' => 6, 'thn' => 2024],
            ['nama' => 'Spektrofotometer Visibel hach dr 1900', 'merk' => 'Spektrofotometer', 'bmn' => '3080111138', 'nup' => 3, 'thn' => 2021],
            ['nama' => 'Biocounter (Alat Lab Limbah)', 'merk' => '-', 'bmn' => '3080111191', 'nup' => 1, 'thn' => 2012],
            ['nama' => 'Lovibond Turbidirect (Turbidimeter)', 'merk' => '-', 'bmn' => '3080113011', 'nup' => 2, 'thn' => 2013],
            ['nama' => 'Desicator non vakum 30 cm', 'merk' => '-', 'bmn' => '3080113019', 'nup' => 5, 'thn' => 2015],
            ['nama' => 'Alat Pembuat Pelet', 'merk' => '-', 'bmn' => '3080113069', 'nup' => 1, 'thn' => 2012],
            ['nama' => 'Lemari Asam Galvanis', 'merk' => '-', 'bmn' => '3080117016', 'nup' => 4, 'thn' => 2013],
            ['nama' => 'Jar Tester JLT4 VELP Scientifica', 'merk' => 'VELP', 'bmn' => '3080601016', 'nup' => 1, 'thn' => 2015],
            ['nama' => 'Jar Tester JLT6 VELP Scientifica', 'merk' => 'VELP', 'bmn' => '3080601016', 'nup' => 2, 'thn' => 2015],
            ['nama' => 'COD Reaktor TINTOMETER LOVIBOND RD125', 'merk' => 'LOVIBOND', 'bmn' => '3080601021', 'nup' => 1, 'thn' => 2015],
            ['nama' => 'Bod Incubator Thermostatic Cabinet LOVIBOND', 'merk' => 'LOVIBOND', 'bmn' => '3080605024', 'nup' => 2, 'thn' => 2015],
            ['nama' => 'Incinerator WIA - 600 LUT 2', 'merk' => '-', 'bmn' => '3170122024', 'nup' => 1, 'thn' => 2015],
        ];

        foreach ($peralatanLab as $val) {
            $this->saveBarang($idLab, $val['nama'], $val['merk'], $val['bmn'], $val['nup'], 'Alat Laboratorium', $val['thn']);
        }

        // Heating Mantle (Heraeus & Electrothermal)
        $this->saveBarang($idLab, 'Heating Mantle', 'Heraeus', '3080156114', 6, 'Alat Laboratorium', 2024);
        $this->saveBarang($idLab, 'Heating Mantle', 'Electrothermal', '3080156114', 7, 'Alat Laboratorium', 2024);

        // Unit Alat Laboratorium Lainnya (LOVIBOND pH110)
        foreach ([6, 7, 8] as $nup) {
            $thn = ($nup == 6) ? 2012 : (($nup == 7) ? 2013 : 2015);
            $this->saveBarang($idLab, 'LOVIBOND Senso Direct pH110', 'LOVIBOND', '3080156114', $nup, 'Alat Laboratorium', $thn);
        }

        // --- 2. MEBELAIR & FURNITUR (Halaman 4, 5, 10, 11) ---

        // Locker Brother 6 Pintu (NUP 42-47)
        for ($nup = 42; $nup <= 47; $nup++) {
            $this->saveBarang($idLab, 'Locker', 'BROTHER 6 Pintu', '3050104015', $nup, 'Furnitur', 2015);
        }

        // Kursi Besi/Metal (CHITOSE)
        foreach ([357, 476, 477, 478] as $nup) {
            $thn = ($nup == 357) ? 2005 : 2007;
            $this->saveBarang($idLab, 'Kursi Besi/Metal', 'CHITOSE', '3050201003', $nup, 'Furnitur', $thn);
        }

        // Kursi Kayu Praktek (NUP 717-723 dan 807-827)
        foreach (array_merge(range(717, 723), range(807, 827)) as $nup) {
            $this->saveBarang($idLab, 'Kursi Kayu', 'Kursi Praktek', '3050201004', $nup, 'Furnitur', 2015);
        }

        // Kursi Praktek Kayu Tinggi 50cm (NUP 830-859)
        foreach (range(830, 859) as $nup) {
            if ($nup == 846) continue;
            $this->saveBarang($idLab, 'KURSI PRAKTEK KAYU Tinggi 50 cm', '-', '3050201004', $nup, 'Furnitur', 2017);
        }

        // Meja Kerja Kayu (Termasuk Meja Dosen)
        $meja = [
            ['nup' => 42, 'thn' => 1986], ['nup' => 53, 'thn' => 1996],
            ['nup' => 80, 'thn' => 2003], ['nup' => 141, 'thn' => 2011],
            ['nup' => 297, 'merk' => 'MEJA DOSEN', 'thn' => 2016],
            ['nup' => 362, 'merk' => '2 laci', 'thn' => 2022],
        ];
        foreach ($meja as $m) {
            $this->saveBarang($idLab, 'Meja Kerja Kayu', $m['merk'] ?? '-', '3050201002', $m['nup'], 'Furnitur', $m['thn']);
        }

        // --- 3. ELEKTRONIK & TIK (Halaman 5, 6, 12) ---

        // AC & Kipas
        $this->saveBarang($idLab, 'A.C. Split', 'SHARP', '3050204004', 72, 'Elektronik', 2013);
        $this->saveBarang($idLab, 'A.C. Split', 'Panasonic 2PK', '3050204004', 94, 'Elektronik', 2015);
        foreach ([38, 39] as $nup) $this->saveBarang($idLab, 'Kipas Angin', 'PANASONIC', '3050204006', $nup, 'Elektronik', 2015);

        // PC & Printer
        $this->saveBarang($idLab, 'P.C Unit', 'COMPAQ 3321D', '3100102001', 72, 'Elektronik', 2011);
        $this->saveBarang($idLab, 'P.C Unit', 'ACER Desktop TC-830', '3100102001', 175, 'Elektronik', 2019);
        $this->saveBarang($idLab, 'Printer', 'Epson L365', '3100203003', 95, 'Elektronik', 2015);
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