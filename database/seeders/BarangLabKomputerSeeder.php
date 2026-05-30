<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangLabKomputerSeeder extends Seeder
{
    public function run(): void
    {
        // Alokasi ke Laboratorium Komputer [ID 6]
        $idLab = 6;

        $items = [
            // --- FURNITUR & MEBELAIR ---
            ['nama' => 'Filing Cabinet Besi', 'merk' => 'BROTHER B.104', 'bmn' => '3050104005', 'nup' => 47, 'thn' => 2013],
            ['nama' => 'Meja Kerja Kayu', 'merk' => '-', 'bmn' => '3050201002', 'nup' => 220, 'thn' => 2011],

            // Meja Komputer Grace (NUP 17-73)
            ...$this->generateRange($idLab, 'Meja Komputer', 'GRACE 68', '3050201009', 17, 46, 2012),
            ...$this->generateRange($idLab, 'Meja Komputer', 'GRACE 86', '3050201009', 48, 54, 2012),
            ...$this->generateRange($idLab, 'Meja Komputer', '80x40x74', '3050201009', 56, 73, 2012),

            // Kursi Fiber (NUP 33-36)
            ...$this->generateRange($idLab, 'Kursi Fiber Glas/Plastik', '-', '3050201020', 33, 36, 2012),

            // --- ALAT LABORATORIUM & PENDUKUNG ---
            ['nama' => 'LCD Projector/Infocus', 'merk' => 'EPSON LCD High End 5500', 'bmn' => '3050105048', 'nup' => 47, 'thn' => 2012],
            ['nama' => 'LCD Projector/Infocus', 'merk' => 'ACER X1 XGA 4000 ANSI', 'bmn' => '3050105048', 'nup' => 69, 'thn' => 2012],
            ['nama' => 'Trisponder', 'merk' => 'CRISPIN', 'bmn' => '3080807011', 'nup' => 1, 'thn' => 2013],

            // --- ELEKTRONIK & TIK ---
            // AC Split (NUP 53-100)
            ...$this->generateRange($idLab, 'A.C. Split', 'PANASONIC', '3050204004', 53, 56, 2012),
            ['nama' => 'A.C. Split', 'merk' => 'Panasonic 2PK', 'bmn' => '3050204004', 'nup' => 100, 'thn' => 2015],

            // UPS/Stabilizer (NUP 1-55)
            ...$this->generateRange($idLab, 'Stabilizer/UPS', 'PROLINK PRO1200SV', '3050201003', 1, 30, 2013),
            ...$this->generateRange($idLab, 'Stabilizer/UPS', 'APC Back UPS 650', '3050201003', 37, 46, 2013),
            ...$this->generateRange($idLab, 'Stabilizer/UPS', 'APC APS UPS BV1000I-MS', '3050201003', 47, 55, 2020),

            // PC Unit (NUP bervariasi)
            ['nama' => 'P.C Unit', 'merk' => 'LENOVO Core I3', 'bmn' => '3100102001', 'nup' => 75, 'thn' => 2011],
            ...$this->generateRange($idLab, 'P.C Unit', 'LENOVO', '3100102001', 97, 138, 2012),
            ...$this->generateRange($idLab, 'P.C Unit', 'DELL i5-8400 8GB DDR4', '3100102001', 152, 181, 2018),

            ['nama' => 'Printer', 'merk' => 'EPSON', 'bmn' => '3100203003', 'nup' => 85, 'thn' => 2013],
        ];

        foreach ($items as $item) {
            $this->saveBarang($idLab, $item['nama'], $item['merk'], $item['bmn'], $item['nup'], $item['thn']);
        }

        // --- KURSI BESI CHITOSE (Massal NUP 250 - 1099) ---
        $this->seedKursiChitose($idLab);
    }

    private function generateRange($idLab, $nama, $merk, $bmn, $start, $end, $thn) {
        $data = [];
        for ($i = $start; $i <= $end; $i++) {
            $data[] = ['nama' => $nama, 'merk' => $merk, 'bmn' => $bmn, 'nup' => $i, 'thn' => $thn];
        }
        return $data;
    }

    private function seedKursiChitose($idLab) {
        $ranges = [
            ['start' => 250, 'end' => 264],
            ['start' => 1030, 'end' => 1047],
            ['start' => 1062, 'end' => 1071],
            ['start' => 1098, 'end' => 1099],
        ];

        foreach ($ranges as $range) {
            for ($nup = $range['start']; $nup <= $range['end']; $nup++) {
                $this->saveBarang($idLab, 'Kursi Besi/Metal', 'CHITOSE', '3050201003', $nup, 2007);
            }
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
                'status_kondisi' => 'Normal',
                'klasifikasi_fungsi' => 'Pendidikan',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    private function getKategori($bmn) {
        if (str_starts_with($bmn, '3050204') || str_starts_with($bmn, '310')) return 'Elektronik';
        if (str_starts_with($bmn, '308') || str_starts_with($bmn, '3050105')) return 'Alat Laboratorium';
        return 'Furnitur';
    }
}