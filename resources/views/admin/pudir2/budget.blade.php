@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4" style="background-color: #f1f5f9; min-height: 100vh;">
    
    {{-- Header Section: Hidden when printing --}}
    <div class="d-flex align-items-center justify-content-between mb-5 d-print-none">
        <div>
            <h2 class="fw-extrabold text-slate-800 mb-1" style="letter-spacing: -0.5px;">Realisasi Anggaran Pemeliharaan</h2>
            <p class="text-slate-500 small mb-0">Laporan penyerapan dana untuk pemeliharaan aset Politeknik ATK Yogyakarta.</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold transition-all hover-lift" onclick="window.print()">
            <i class="bi bi-printer me-2"></i> Cetak Laporan
        </button>
    </div>

    {{-- Laporan Header: Only visible when printing --}}
    <div class="d-none d-print-block mb-5 text-center">
        <h4 class="fw-bold mb-0">LAPORAN REALISASI ANGGARAN PEMELIHARAAN ASET</h4>
        <h5 class="text-uppercase mb-1">POLITEKNIK ATK YOGYAKARTA</h5>
        <p class="small text-muted">Periode Laporan: {{ now()->translatedFormat('F Y') }} | Dicetak: {{ now()->translatedFormat('d/m/Y H:i') }}</p>
        <hr style="border-top: 2px solid #000;">
    </div>
    
    {{-- Ringkasan Anggaran (KPI Cards) --}}
    <div class="row mb-5 g-4 stats-row">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-white transition-all hover-lift h-100">
                <div class="rounded-circle d-inline-flex p-3 mb-3 mx-auto" style="background: #6366f115;">
                    <i class="bi bi-wallet2 text-primary fs-3"></i>
                </div>
                <small class="text-slate-400 d-block text-uppercase fw-bold mb-2" style="font-size: 10px; letter-spacing: 1px;">Total Dana Terserap</small>
                <h2 class="text-slate-800 fw-bold mb-0">Rp {{ number_format($completedMaintenance->sum('estimated_cost'), 0, ',', '.') }}</h2>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-white transition-all hover-lift h-100">
                <div class="rounded-circle d-inline-flex p-3 mb-3 mx-auto" style="background: #10b98115;">
                    <i class="bi bi-check-all text-success fs-3"></i>
                </div>
                <small class="text-slate-400 d-block text-uppercase fw-bold mb-2" style="font-size: 10px; letter-spacing: 1px;">Volume Pekerjaan</small>
                <h2 class="text-slate-800 fw-bold mb-0">{{ $completedMaintenance->count() }} Item Selesai</h2>
            </div>
        </div>
    </div>

    {{-- Tabel Rincian --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-header bg-white p-4 border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-slate-800">Rincian Transaksi Anggaran</h5>
            <span class="badge bg-slate-100 text-slate-600 border px-3 py-2 rounded-pill small fw-medium">Tahun Anggaran {{ date('Y') }}</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50 border-top">
                        <tr class="text-slate-400 small fw-bold text-uppercase" style="letter-spacing: 1px;">
                            <th class="ps-4 py-3 border-0">Tanggal / Rekap</th>
                            <th class="border-0">Aset & Kode BMN</th>
                            <th class="border-0">Unit Laboratorium</th>
                            <th class="border-0">Metode Kerja</th>
                            <th class="pe-4 text-end border-0">Biaya Realisasi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($completedMaintenance as $item)
                        <tr>
                            <td class="ps-4 py-4">
                                <div class="fw-bold text-slate-800">{{ $item->updated_at->format('d/m/Y') }}</div>
                                <div class="text-slate-400 small">{{ $item->updated_at->translatedFormat('H:i') }} WIB</div>
                            </td>
                            <td>
                                {{-- PERBAIKAN: equipment -> barang & nama_alat -> nama_barang --}}
                                <div class="fw-bold text-primary">{{ $item->barang?->nama_barang ?? 'N/A' }}</div>
                                <div class="text-slate-400 small font-monospace" style="font-size: 11px;">{{ $item->barang?->kode_bmn ?? '-' }}</div>
                            </td>
                            <td>
                                <span class="badge bg-slate-100 text-slate-600 border px-2 py-1 fw-medium">
                                    {{ $item->lab?->nama_lab ?? '-' }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $isExternal = $item->repair_type == 'External';
                                    $badgeClass = $isExternal ? 'bg-amber-100 text-amber-700' : 'bg-indigo-100 text-indigo-700';
                                @endphp
                                <span class="badge {{ $badgeClass }} px-3 py-1 rounded-pill small fw-bold">
                                    {{ $isExternal ? 'VENDOR' : 'INTERNAL' }}
                                </span>
                            </td>
                            <td class="fw-bold text-slate-800 text-end pe-4 fs-6">
                                Rp {{ number_format($item->estimated_cost, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                                    <i class="bi bi-clipboard-x fs-1 text-slate-300"></i>
                                </div>
                                <h6 class="fw-bold text-slate-800">Belum Ada Transaksi</h6>
                                <p class="text-slate-400 small">Data realisasi anggaran akan muncul di sini setelah tiket berstatus perbaikan atau selesai.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-slate-50 fw-bold border-top">
                        <tr>
                            <td colspan="4" class="ps-4 py-3 text-slate-600">TOTAL PENYERAPAN DANA PERIODE INI</td>
                            <td class="pe-4 text-end text-primary fs-5">Rp {{ number_format($completedMaintenance->sum('estimated_cost'), 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-extrabold { font-weight: 800; }
    .text-slate-800 { color: #1e293b; }
    .text-slate-600 { color: #475569; }
    .text-slate-500 { color: #64748b; }
    .text-slate-400 { color: #94a3b8; }
    .bg-slate-50 { background-color: #f8fafc; }
    .bg-slate-100 { background-color: #f1f5f9; }
    .bg-amber-100 { background-color: #fef3c7; }
    .text-amber-700 { color: #b45309; }
    .bg-indigo-100 { background-color: #e0e7ff; }
    .text-indigo-700 { color: #4338ca; }
    
    .hover-lift:hover { transform: translateY(-5px); }
    .transition-all { transition: all 0.3s cubic-bezier(.4,0,.2,1); }

    @media print {
        .d-print-none, .btn, .sidebar, .navbar { display: none !important; }
        body { background: white !important; }
        .container-fluid { padding: 0 !important; }
        .card { box-shadow: none !important; border: 1px solid #eee !important; }
        .stats-row .card { border: 1px solid #000 !important; }
        .table thead th { background: #eee !important; color: #000 !important; }
        .table tfoot { background: #f9f9f9 !important; border-top: 2px solid #000 !important; }
    }
</style>
@endsection