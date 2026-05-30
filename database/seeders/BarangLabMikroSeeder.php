<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangLabMikroSeeder extends Seeder
{
    public function run(): void
    {
        // Alokasi ke Laboratorium Mikrobiologi [ID 3]
        $idLab = 3;

        // --- 1. PERALATAN LABORATORIUM & INSTRUMEN (Halaman 3, 4, 6) ---
        $peralatan = [
            ['nama' => 'Mesin Kompresor', 'merk' => 'KOMPRESOR 1,5 PK', 'bmn' => '3030101018', 'nup' => 1, 'thn' => 2015],
            ['nama' => 'Orbital Shaker', 'merk' => 'stuart', 'bmn' => '3030301102', 'nup' => 1, 'thn' => 2015],
            ['nama' => 'LCD Projector/Infocus', 'merk' => 'Acer', 'bmn' => '3050105048', 'nup' => 17, 'thn' => 2011],
            ['nama' => 'Water Bath (Alat Laboratorium Umum)', 'merk' => 'MEMERT', 'bmn' => '3080111002', 'nup' => 5, 'thn' => 2005],
            ['nama' => 'Incubator (Alat Laboratorium Umum)', 'merk' => 'HERAEUS', 'bmn' => '3080111003', 'nup' => 2, 'thn' => 1994],
            ['nama' => 'Timbangan/Neraca', 'merk' => 'AND', 'bmn' => '3080111023', 'nup' => 6, 'thn' => 2007],
            ['nama' => 'Vacum Pump', 'merk' => '-', 'bmn' => '3080111028', 'nup' => 3, 'thn' => 2005],
            ['nama' => 'Microtome (Alat Laboratorium Umum)', 'merk' => 'MICROM HM325', 'bmn' => '3080111113', 'nup' => 2, 'thn' => 2007],
            ['nama' => 'Stereo Microscope', 'merk' => 'MOTIC', 'bmn' => '3080112008', 'nup' => 1, 'thn' => 2004],
            ['nama' => 'Homogin Mixer', 'merk' => 'Maxi Mix', 'bmn' => '3080113050', 'nup' => 1, 'thn' => 2004],
            ['nama' => 'Homogin Mixer', 'merk' => 'THERMOLYNE', 'bmn' => '3080113050', 'nup' => 2, 'thn' => 2004],
            ['nama' => 'Fumehood (Lemari Asap)', 'merk' => '-', 'bmn' => '3080127026', 'nup' => 1, 'thn' => 2013],
            ['nama' => 'Stereo Microskop', 'merk' => '-', 'bmn' => '3080118007', 'nup' => 1, 'thn' => 2013],
            ['nama' => 'Stereo Microskop', 'merk' => '-', 'bmn' => '3080118007', 'nup' => 2, 'thn' => 2013],
        ];

        foreach ($peralatan as $val) {
            $this->saveBarang($idLab, $val['nama'], $val['merk'], $val['bmn'], $val['nup'], 'Alat Laboratorium', $val['thn']);
        }

        // --- Colony Counter (NUP 3, 4, 5) ---
        $this->saveBarang($idLab, 'Colony Counter', 'STUART', '3080116006', 3, 'Alat Laboratorium', 2005);
        foreach ([4, 5] as $nup) {
            $this->saveBarang($idLab, 'Colony Counter', 'GERBER INSTRUMENTS', '3080116006', $nup, 'Alat Laboratorium', 2006);
        }

        // --- Mikroskop Binokuler (NUP 1 s/d 17) ---
        for ($nup = 1; $nup <= 17; $nup++) {
            $merk = ($nup <= 5) ? 'XSZ' : (($nup <= 15) ? 'MOTIC' : '-');
            $thn = ($nup <= 5) ? 2002 : (($nup <= 15) ? 2003 : 2013);
            $this->saveBarang($idLab, 'Mikroskop Binokuler', $merk, '3080116006', $nup, 'Alat Laboratorium', $thn);
        }

        // --- Shaker (NUP 1, 2) ---
        foreach ([1, 2] as $nup) {
            $this->saveBarang($idLab, 'Shaker', 'VRN 200', '3080141232', $nup, 'Alat Laboratorium', 2006);
        }

        // --- 2. MEBELAIR & FURNITUR (Halaman 3, 4, 5) ---
        
        $mebelair = [
            ['nama' => 'Lemari Kayu', 'merk' => '-', 'bmn' => '3050104002', 'nup' => 12, 'thn' => 2011],
            ['nama' => 'Filing Cabinet Besi', 'merk' => 'BROTHER', 'bmn' => '3050104001', 'nup' => 24, 'thn' => 1985],
            ['nama' => 'White Board', 'merk' => '-', 'bmn' => '3050105010', 'nup' => 31, 'thn' => 2011],
            ['nama' => 'Meja Kerja Kayu', 'merk' => '-', 'bmn' => '3050201002', 'nup' => 79, 'thn' => 2001],
            ['nama' => 'Meja Komputer', 'merk' => 'GRACE 68', 'bmn' => '3050201009', 'nup' => 16, 'thn' => 2012],
            ['nama' => 'Tabung Pemadam Api', 'merk' => 'MINIMAX', 'bmn' => '3050105001', 'nup' => 7, 'thn' => 1996],
        ];

        foreach ($mebelair as $val) {
            $this->saveBarang($idLab, $val['nama'], $val['merk'], $val['bmn'], $val['nup'], 'Furnitur', $val['thn']);
        }

        // Buffet NUP Campuran
        foreach ([1, 35, 36, 41, 45] as $nup) {
            $thn = ($nup == 1) ? 1963 : (($nup == 35) ? 1989 : (($nup == 36) ? 1990 : (($nup == 41) ? 2000 : 2004)));
            $this->saveBarang($idLab, 'Buffet', '-', '3050104013', $nup, 'Furnitur', $thn);
        }

        // Locker Datafile (NUP 7, 8, 13)
        foreach ([7, 8, 13] as $nup) {
            $this->saveBarang($idLab, 'Locker', 'DATAFILE', '3050104015', $nup, 'Furnitur', 2007);
        }

        // Kursi Besi/Metal (CHITOSE)
        foreach ([321, 322, 323, 324, 325, 326, 456, 457] as $nup) {
            $thn = ($nup < 400) ? 2005 : 2007;
            $this->saveBarang($idLab, 'Kursi Besi/Metal', 'CHITOSE', '3050201003', $nup, 'Furnitur', $thn);
        }
        $this->saveBarang($idLab, 'Kursi Besi/Metal', 'FUTURA 747', '3050201003', 1482, 'Furnitur', 2015);

        // Kursi Kayu Praktek (NUP 792 s/d 806)
        for ($nup = 792; $nup <= 806; $nup++) {
            $this->saveBarang($idLab, 'Kursi Kayu', 'Kursi Praktek', '3050201004', $nup, 'Furnitur', 2015);
        }

        // --- 3. ELEKTRONIK & TIK (Halaman 3, 4, 6) ---
        
        $this->saveBarang($idLab, 'Lemari Es', 'NATIONAL', '3050204001', 2, 'Elektronik', 1993);
        $this->saveBarang($idLab, 'Lemari Es', 'PANASONIC 1 Pintu', '3050204001', 5, 'Elektronik', 2015);
        $this->saveBarang($idLab, 'A.C. Split', 'SHARP', '3050204004', 76, 'Elektronik', 2013);
        
        foreach ([33, 34] as $nup) {
            $this->saveBarang($idLab, 'Kipas Angin', 'PANASONIC Kipas Gantung', '3050204006', $nup, 'Elektronik', 2015);
        }

        // Kompor & Tabung Gas
        foreach ([2, 3] as $nup) $this->saveBarang($idLab, 'Kompor Gas', 'rinnai 1 tungku', '3050205002', $nup, 'Elektronik', 2022);
        $this->saveBarang($idLab, 'Tabung Gas', 'bright gas 5.5', '3050205009', 3, 'Elektronik', 2022);

        // PC & Printer
        $this->saveBarang($idLab, 'P.C Unit', 'COMPAQ 3321D', '3100102001', 70, 'Elektronik', 2011);
        $this->saveBarang($idLab, 'P.C Unit', 'LENOVO COREi3', '3100102001', 150, 'Elektronik', 2017);
        $this->saveBarang($idLab, 'Printer', 'Epson L365', '3100203003', 98, 'Elektronik', 2016);
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