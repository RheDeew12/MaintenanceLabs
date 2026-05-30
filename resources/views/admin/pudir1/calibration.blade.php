@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4" style="background-color: #f1f5f9; min-height: 100vh;">
    
    {{-- Header Section: Professional & Focused --}}
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div>
            <h2 class="fw-extrabold text-slate-800 mb-1" style="letter-spacing: -0.5px;">Monitoring Kalibrasi Alat</h2>
            <p class="text-slate-500 small mb-0">Penjaminan mutu akurasi alat ukur laboratorium sesuai Standar ISO/IEC 17025.</p>
        </div>
        <div class="d-flex gap-3">
            <div class="bg-glass text-white px-4 py-2 rounded-4 shadow-sm border d-flex align-items-center">
                <i class="bi bi-shield-check me-2"></i>
                <span class="small fw-bold">Quality Assurance System</span>
            </div>
        </div>
    </div>

    {{-- High-Definition Status Cards --}}
    <div class="row g-4 mb-5 text-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden transition-all hover-lift h-100">
                <div class="card-body p-5">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" 
                         style="background: #10b98115; width: 80px; height: 80px;">
                        <i class="bi bi-patch-check-fill fs-1" style="color: #10b981"></i>
                    </div>
                    <h6 class="text-slate-400 small text-uppercase fw-bold mb-2">Alat Terkalibrasi</h6>
                    <h1 class="fw-extrabold text-slate-800 mb-1">{{ $terkalibrasi }}</h1>
                    <p class="text-success small fw-bold mb-0"><i class="bi bi-shield-fill-check me-1"></i>Akurasi Terjamin</p>
                </div>
                <div class="position-absolute bottom-0 start-0 w-100" style="height: 4px; background: #10b981"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden transition-all hover-lift h-100">
                <div class="card-body p-5">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" 
                         style="background: #ef444415; width: 80px; height: 80px;">
                        <i class="bi bi-exclamation-triangle-fill fs-1" style="color: #ef4444"></i>
                    </div>
                    <h6 class="text-slate-400 small text-uppercase fw-bold mb-2">Kalibrasi Expired</h6>
                    <h1 class="fw-extrabold text-slate-800 mb-1">{{ $expired }}</h1>
                    <p class="text-danger small fw-bold mb-0"><i class="bi bi- megaphone-fill me-1"></i>Perlu Tindakan Segera</p>
                </div>
                <div class="position-absolute bottom-0 start-0 w-100" style="height: 4px; background: #ef4444"></div>
            </div>
        </div>
    </div>

    {{-- Attention Table Area --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-header bg-white p-4 border-0 d-flex align-items-center justify-content-between">
            <h5 class="fw-bold text-slate-800 mb-0">
                <i class="bi bi-hourglass-split me-2 text-warning"></i>Perhatian Khusus (Kadaluarsa < 30 Hari)
            </h5>
            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2 border border-warning border-opacity-25 small">
                Near Expiration
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50 border-top">
                        <tr class="text-slate-400 small fw-bold text-uppercase" style="letter-spacing: 1px;">
                            <th class="ps-4 py-3 border-0">Informasi Alat & BMN</th>
                            <th class="border-0">Laboratorium</th>
                            <th class="text-center border-0">Tgl Kalibrasi</th>
                            <th class="text-center border-0">Jatuh Tempo</th>
                            <th class="text-center pe-4 border-0">Countdown</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($upcoming as $item)
                        @php 
                            $daysLeft = now()->diffInDays(\Carbon\Carbon::parse($item->next_calibration), false);
                        @endphp
                        <tr>
                            <td class="ps-4 py-4">
                                <div class="fw-bold text-slate-800">{{ $item->nama_barang }}</div>
                                <div class="text-slate-400 small font-monospace">{{ $item->kode_bmn ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <span class="text-slate-600 fw-medium small">{{ $item->lab->nama_lab }}</span>
                            </td>
                            <td class="text-center">
                                <div class="text-slate-500 small">{{ \Carbon\Carbon::parse($item->last_calibration)->format('d/m/Y') }}</div>
                            </td>
                            <td class="text-center">
                                <div class="fw-bold text-danger small">{{ \Carbon\Carbon::parse($item->next_calibration)->format('d/m/Y') }}</div>
                                <div class="text-slate-400 x-small">{{ \Carbon\Carbon::parse($item->next_calibration)->diffForHumans() }}</div>
                            </td>
                            <td class="text-center pe-4">
                                <span class="badge px-3 py-2 rounded-3 fw-bold shadow-none" 
                                      style="background: #f59e0b15; color: #f59e0b; border: 1px solid #f59e0b30;">
                                    <i class="bi bi-alarm me-1"></i> {{ $daysLeft }} Hari Lagi
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                                    <i class="bi bi-shield-check fs-1 text-success"></i>
                                </div>
                                <h6 class="fw-bold text-slate-800">Akurasi Terjamin</h6>
                                <p class="text-slate-400 small">Tidak ada alat yang mendekati masa kadaluarsa kalibrasi dalam waktu dekat.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
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
    .x-small { font-size: 10px; }
    .hover-lift:hover { transform: translateY(-5px); }
    .transition-all { transition: all 0.3s cubic-bezier(.4,0,.2,1); }
    .bg-glass {
        background: rgba(30, 41, 59, 0.7);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
</style>
@endsection