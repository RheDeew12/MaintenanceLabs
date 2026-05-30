@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4" style="background-color: #f8fafc; min-height: 100vh;">
    
    {{-- 1. Header Section (Hanya muncul di Browser/Layar) --}}
    <div class="d-flex justify-content-between align-items-center mb-4 p-4 rounded-4 shadow-sm border-0 d-print-none" 
        style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
        
        <div>
            <h2 class="text-white mb-1 fw-bold" style="letter-spacing: -0.5px;">Master Inventaris Alat</h2>
            <p class="text-white-50 mb-0 small">
                <i class="fas fa-university me-2"></i>Unit Kerja: {{ Auth::user()->prodi->nama_prodi ?? 'Program Studi' }}
            </p>
        </div>

        <button class="btn btn-light rounded-3 px-4 fw-bold shadow-sm transition-all hover-lift" onclick="window.print()">
            <i class="fas fa-print me-2 text-primary"></i>Cetak Laporan
        </button>
    </div>

    {{-- 2. Kop Surat Formal (Hanya muncul saat dicetak) --}}
    <div class="d-none d-print-block">
        <div class="text-center mb-0">
            <h4 class="mb-0 fw-bold">KEMENTERIAN PERINDUSTRIAN REPUBLIK INDONESIA</h4>
            <h5 class="mb-0 fw-bold">BADAN PENGEMBANGAN SUMBER DAYA MANUSIA INDUSTRI</h5>
            <h4 class="mb-1 fw-bold">POLITEKNIK ATK YOGYAKARTA</h4>
            <p class="small mb-0">Jl. Ringroad Selatan, Glugo, Panggungharjo, Sewon, Bantul, Yogyakarta 55188</p>
            <hr style="border-top: 3px solid #000; margin-top: 10px; opacity: 1;">
        </div>
        <div class="text-center mt-4 mb-4">
            <h5 class="fw-bold text-uppercase" style="text-decoration: underline;">LAPORAN DAFTAR INVENTARIS ALAT LABORATORIUM / WORKSHOP</h5>
            <h6 class="text-uppercase">PROGRAM STUDI: {{ Auth::user()->prodi->nama_prodi ?? '' }}</h6>
            <p class="small">Posisi Data Per Tanggal: {{ now()->translatedFormat('d F Y') }}</p>
        </div>
    </div>

    {{-- 3. Statistik Row (Hanya muncul di Layar) --}}
    <div class="row g-4 mb-4 stats-row d-print-none">
        @php
            $readyCount = $equipment->whereIn('status_kondisi', ['Normal', 'Baik'])->count();
            $maintCount = $equipment->where('status_kondisi', 'Perlu Perbaikan')->count();
            $brokenCount = $equipment->whereIn('status_kondisi', ['Rusak', 'Rusak Berat'])->count();
        @endphp
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 text-white" style="background-color: #059669;">
                <div class="card-body p-4 text-center">
                    <h6 class="fw-bold opacity-75 small text-uppercase">Siap Pakai</h6>
                    <h2 class="mb-0 fw-bold">{{ $readyCount }} Unit</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 text-white" style="background-color: #d97706;">
                <div class="card-body p-4 text-center">
                    <h6 class="fw-bold opacity-75 small text-uppercase">Maintenance</h6>
                    <h2 class="mb-0 fw-bold">{{ $maintCount }} Unit</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 text-white" style="background-color: #dc2626;">
                <div class="card-body p-4 text-center">
                    <h6 class="fw-bold opacity-75 small text-uppercase">Rusak / Afkir</h6>
                    <h2 class="mb-0 fw-bold">{{ $brokenCount }} Unit</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- 4. Tabel Inventaris --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="main-table">
                    <thead class="bg-light">
                        <tr class="text-dark small fw-bold">
                            <th class="ps-4 py-3 border-bottom text-center" style="width: 50px;">NO</th>
                            <th class="py-3 border-bottom">IDENTITAS ALAT & KODE BMN</th>
                            <th class="py-3 border-bottom">MERK / TIPE</th>
                            <th class="py-3 border-bottom text-center">TAHUN</th>
                            <th class="py-3 border-bottom">LOKASI UNIT</th>
                            <th class="py-3 border-bottom text-center" style="width: 150px;">KONDISI</th>
                            <th class="text-center pe-4 py-3 border-bottom d-print-none">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($equipment as $index => $item)
                        <tr>
                            <td class="ps-4 text-center small text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark mb-0">{{ $item->nama_barang ?? 'N/A' }}</div>
                                <div class="text-primary font-monospace d-print-black" style="font-size: 10px;">
                                    {{ $item->kode_bmn ?? '-' }}
                                </div>
                            </td>
                            <td class="small">{{ $item->merk_tipe ?? '-' }}</td>
                            <td class="text-center small">{{ $item->tahun_perolehan ?? '-' }}</td>
                            <td>
                                <span class="small">{{ $item->lab->nama_lab ?? 'N/A' }}</span>
                            </td>
                            <td class="text-center">
                                @php
                                    $status = $item->status_kondisi;
                                    $isReady = in_array($status, ['Normal', 'Baik']);
                                    $isMaint = $status == 'Perlu Perbaikan';
                                    $color = $isReady ? '#059669' : ($isMaint ? '#d97706' : '#dc2626');
                                    $labelText = $isReady ? 'SIAP PAKAI' : ($isMaint ? 'MAINTENANCE' : 'RUSAK');
                                @endphp
                                
                                {{-- Badge Layar (Modern Soft Color) --}}
                                <div class="d-print-none px-2 py-1 rounded-pill fw-bold" 
                                     style="background-color: {{ $color }}15; color: {{ $color }}; font-size: 9px; border: 1px solid {{ $color }}30;">
                                    {{ $labelText }}
                                </div>

                                {{-- Teks Cetak (Formal Black & Bold) --}}
                                <div class="d-none d-print-block fw-bold small text-uppercase">
                                    {{ $status }}
                                </div>
                            </td>
                            <td class="text-center pe-4 d-print-none">
                                <a href="{{ route('kaprodi.equipment.history', $item->id) }}" 
                                   class="btn btn-sm btn-outline-primary rounded-3 px-3 fw-bold transition-all hover-lift">
                                    <i class="fas fa-history me-1"></i> Riwayat
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted small">Data inventaris tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- 5. Footer Tanda Tangan (Hanya muncul saat dicetak) --}}
    <div class="d-none d-print-block mt-5">
        <div class="row">
            <div class="col-8"></div>
            <div class="col-4 text-center">
                <p class="mb-0">Yogyakarta, {{ now()->translatedFormat('d F Y') }}</p>
                <p class="mb-5 fw-bold">Ketua Program Studi,</p>
                <br><br><br>
                <p class="mb-0 fw-bold"><u>( ............................................ )</u></p>
                <p class="small">NIP. ........................................</p>
            </div>
        </div>
    </div>
</div>

<style>
    /* DESKTOP UI ENHANCEMENT */
    .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 8px 15px rgba(0,0,0,0.1); transition: 0.2s; }
    .font-monospace { font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace; }

    /* HARD RESET PRINT - Menghilangkan SEMUA Elemen Dashboard & Template */
    @media print {
        @page { size: landscape; margin: 15mm; }
        
        /* Hilangkan elemen sistem, navigasi, sidebar, header dashboard, dan footer dashboard */
        header, footer, nav, aside, 
        .main-header, .main-sidebar, .main-footer, .content-header,
        .navbar, .sidebar, .breadcrumb, .d-print-none,
        .brand-link, .nav-header, .user-panel, h1, .info-prodi { 
            display: none !important; 
            visibility: hidden !important;
            height: 0 !important;
            width: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Paksa konten utama mengisi seluruh lebar kertas tanpa margin sisa sidebar */
        .content-wrapper, .wrapper, body {
            margin: 0 !important;
            padding: 0 !important;
            background-color: white !important;
        }

        .container-fluid {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        body { 
            background: white !important; 
            color: black !important; 
            font-family: "Times New Roman", Times, serif !important;
            font-size: 11pt !important;
        }

        /* Formatting Tabel Cetak Formal */
        .card { border: none !important; box-shadow: none !important; }
        .table { 
            width: 100% !important; 
            border: 1px solid #000 !important; 
            border-collapse: collapse !important; 
        }
        .table th { 
            background-color: #f2f2f2 !important; 
            border: 1px solid #000 !important; 
            color: #000 !important;
            text-align: center !important;
            font-weight: bold !important;
            -webkit-print-color-adjust: exact;
        }
        .table td { 
            border: 1px solid #000 !important; 
            padding: 6px 8px !important;
            color: #000 !important;
        }
        
        .d-print-black { color: #000 !important; }
        hr { border-top: 2px solid #000 !important; opacity: 1 !important; }
    }
</style>
@endsection