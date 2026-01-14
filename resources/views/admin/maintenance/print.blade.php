<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perawatan - {{ $item->formatted_id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Pengaturan khusus untuk mode cetak */
        @media print {
            .no-print { display: none !important; }
            body { 
                padding: 0; 
                background-color: white !important;
                font-size: 11pt;
            }
            .container { width: 100% !important; max-width: 100% !important; }
            .card { border: none !important; }
            .table-light { background-color: #f8f9fa !important; }
        }
        
        body { background-color: #f4f7f6; font-family: 'Times New Roman', Times, serif; }
        .kop-surat { border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 30px; }
        .signature-space { height: 80px; }
        .info-label { width: 180px; font-weight: bold; }
    </style>
</head>
<body onload="window.print()"> {{-- Otomatis memunculkan dialog print saat loading selesai --}}

    <div class="container my-5">
        {{-- KOP SURAT --}}
        <div class="kop-surat text-center">
            <h4 class="mb-0">POLITEKNIK ATK YOGYAKARTA</h4>
            <p class="mb-0 small text-uppercase">Sistem Manajemen Pemeliharaan Fasilitas Laboratorium</p>
            <p class="small mb-0 fst-italic">Jl. Ringroad Selatan, Glugo, Panggungharjo, Sewon, Bantul, DIY</p>
        </div>

        <div class="no-print mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary shadow-sm">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
            <button onclick="window.print()" class="btn btn-primary shadow-sm">
                Cetak Laporan
            </button>
        </div>

        <div class="card shadow-sm border-0 p-4">
            <div class="text-center mb-4">
                <h5 class="fw-bold text-decoration-underline">LAPORAN KERUSAKAN & PERBAIKAN ALAT</h5>
                <span>Nomor Tiket: <strong>#{{ $item->formatted_id }}</strong></span>
            </div>

            {{-- 1. IDENTITAS PELAPORAN --}}
            <h6 class="fw-bold bg-light p-2 rounded">I. INFORMASI PENGADUAN</h6>
            <table class="table table-borderless table-sm mb-4">
                <tr>
                    <td class="info-label">Tanggal Pengajuan</td>
                    <td>: {{ ($item->request_date ?? $item->created_at)->format('d F Y, H:i') }} WIB</td>
                </tr>
                <tr>
                    <td class="info-label">Nama Pelapor (Ka. Lab)</td>
                    <td>: {{ $item->user->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Status Urgensi</td>
                    <td>: <span class="badge {{ $item->urgency == 'High' ? 'bg-danger' : 'bg-warning text-dark' }}">{{ strtoupper($item->urgency) }}</span></td>
                </tr>
            </table>

            {{-- 2. DETAIL ASET --}}
            <h6 class="fw-bold bg-light p-2 rounded">II. IDENTITAS ALAT / ASET</h6>
            <table class="table table-bordered mb-4">
                <thead class="table-light text-center small">
                    <tr>
                        <th>Nama Alat</th>
                        <th>Kode Aset</th>
                        <th>Merk / Tipe</th>
                        <th>Lokasi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr>
                        <td>{{ $item->equipment->name ?? '-' }}</td>
                        <td>{{ $item->equipment->code ?? '-' }}</td>
                        <td>{{ $item->equipment->merk ?? '-' }}</td>
                        <td>{{ $item->equipment->location ?? 'Belum Ditentukan' }}</td>
                    </tr>
                </tbody>
            </table>

            {{-- 3. ANALISIS KERUSAKAN --}}
            <h6 class="fw-bold bg-light p-2 rounded">III. DETAIL KERUSAKAN & REKOMENDASI</h6>
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label class="fw-bold small d-block">Gejala / Masalah yang Dilaporkan:</label>
                    <div class="border p-2 bg-light-subtle min-vh-10" style="min-height: 60px;">
                        {{ $item->issue_description }}
                    </div>
                </div>
                
                @if($item->technical_recommendation)
                <div class="col-12">
                    <label class="fw-bold small d-block">Analisis Teknis & Tindakan Perbaikan:</label>
                    <div class="border p-2 min-vh-10" style="min-height: 80px;">
                        {{ $item->technical_recommendation }}
                    </div>
                </div>
                <div class="col-6">
                    <label class="fw-bold small d-block">Metode Perbaikan:</label>
                    <div class="border p-2 fw-bold text-primary">{{ $item->repair_type == 'Internal' ? 'Mandiri (Teknisi Internal)' : 'Pihak Luar (Vendor)' }}</div>
                </div>
                <div class="col-6">
                    <label class="fw-bold small d-block">Biaya Perbaikan:</label>
                    <div class="border p-2 fw-bold">Rp {{ number_format($item->estimated_cost ?? 0, 0, ',', '.') }}</div>
                </div>
                @endif
            </div>

            {{-- 4. TANDA TANGAN --}}
            <div class="row mt-5">
                <div class="col-4 text-center">
                    <p class="mb-0 small">Dilaporkan Oleh,</p>
                    <p class="small mb-0">Kepala Laboratorium</p>
                    <div class="signature-space"></div>
                    <strong class="text-decoration-underline">( {{ $item->user->name ?? '....................' }} )</strong>
                </div>
                <div class="col-4 text-center">
                    <p class="mb-0 small">Mengetahui,</p>
                    <p class="small mb-0">Tim Pemelihara / Teknisi</p>
                    <div class="signature-space"></div>
                    <strong class="text-decoration-underline">( ........................................ )</strong>
                </div>
                <div class="col-4 text-center">
                    <p class="mb-0 small">Disetujui Oleh,</p>
                    <p class="small mb-0">Pimpinan / Kaprodi</p>
                    <div class="signature-space"></div>
                    <strong class="text-decoration-underline">( ........................................ )</strong>
                </div>
            </div>

            <div class="mt-5 text-end fst-italic text-muted no-print" style="font-size: 0.7rem;">
                Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}
            </div>
        </div>
    </div>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</body>
</html>