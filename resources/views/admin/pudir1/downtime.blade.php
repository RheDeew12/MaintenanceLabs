@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4" style="background-color: #f1f5f9; min-height: 100vh;">
    
    {{-- Header Section: Minimalist & Professional --}}
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div>
            <h2 class="fw-extrabold text-slate-800 mb-1" style="letter-spacing: -0.5px;">Analisis Downtime Alat</h2>
            <p class="text-slate-500 small mb-0">Pemantauan durasi ketidaksiapan alat praktikum untuk mendukung keputusan akademik.</p>
        </div>
        <div class="d-flex gap-3">
            <div class="bg-white px-4 py-2 rounded-4 shadow-sm border d-flex align-items-center">
                <i class="bi bi-clock-history text-primary me-2"></i>
                <span class="small fw-bold text-slate-600">Update: {{ now()->format('H:i') }} WIB</span>
            </div>
        </div>
    </div>

    {{-- Stats Cards: Premium Definition --}}
    <div class="row g-4 mb-5">
        @php
            $criticalCount = $downtime->filter(fn($row) => now()->diffInDays($row->created_at) > 14)->count();
            $warningCount = $downtime->filter(fn($row) => now()->diffInDays($row->created_at) >= 7 && now()->diffInDays($row->created_at) <= 14)->count();
            
            $summaryCards = [
                ['label' => 'Kritis (>14 Hari)', 'val' => $criticalCount, 'color' => '#ef4444', 'icon' => 'bi-exclamation-octagon'],
                ['label' => 'Peringatan (7-14 Hari)', 'val' => $warningCount, 'color' => '#f59e0b', 'icon' => 'bi-hourglass-split'],
                ['label' => 'Total Downtime Aktif', 'val' => $downtime->total(), 'color' => '#6366f1', 'icon' => 'bi-activity'],
            ];
        @endphp

        @foreach($summaryCards as $card)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 position-relative overflow-hidden transition-all hover-lift h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="rounded-3 p-2 d-flex align-items-center justify-content-center" style="background: {{ $card['color'] }}15; width: 48px; height: 48px;">
                            <i class="bi {{ $card['icon'] }} fs-4" style="color: {{ $card['color'] }}"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-slate-800 mb-1">{{ $card['val'] }} <span class="fs-6 fw-normal text-slate-400">Alat</span></h3>
                    <p class="text-slate-500 small mb-0 fw-medium">{{ $card['label'] }}</p>
                </div>
                <div class="position-absolute bottom-0 start-0 w-100" style="height: 4px; background: {{ $card['color'] }}"></div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Main Table Area --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white p-4 border-0">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="fw-bold text-slate-800 mb-0">Daftar Alat Non-Aktif</h5>
                <span class="badge bg-slate-100 text-slate-600 rounded-pill px-3 py-2 border">Filter: Status Repairing</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50 border-top">
                        <tr class="text-slate-400 small fw-bold text-uppercase" style="letter-spacing: 1px;">
                            <th class="ps-4 py-3 border-0">Informasi Alat & Unit</th>
                            <th class="text-center border-0">Tgl Lapor</th>
                            <th class="text-center border-0">Durasi Downtime</th>
                            <th class="border-0" style="width: 30%;">Analisis Dampak KBM</th>
                            <th class="text-center pe-4 border-0">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($downtime as $row)
                        @php 
                            $days = now()->diffInDays($row->created_at);
                            $color = $days > 14 ? '#ef4444' : ($days >= 7 ? '#f59e0b' : '#3b82f6');
                            $impact = $days > 14 ? 'KRITIS' : ($days >= 7 ? 'TERHAMBAT' : 'NORMAL');
                        @endphp
                        <tr>
                            <td class="ps-4 py-4">
                                <div class="fw-bold text-slate-800">{{ $row->barang?->nama_barang ?? 'N/A' }}</div>
                                <div class="text-slate-400 small d-flex align-items-center mt-1">
                                    <i class="bi bi-geo-alt-fill me-1 text-primary"></i>
                                    {{ $row->lab?->nama_lab ?? 'Unit N/A' }}
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="text-slate-600 fw-medium small">{{ $row->created_at->format('d/m/Y') }}</div>
                                <div class="text-slate-400 x-small">{{ $row->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="text-center">
                                <span class="badge px-3 py-2 rounded-3 fw-bold shadow-none" 
                                      style="background: {{ $color }}15; color: {{ $color }}; border: 1px solid {{ $color }}30;">
                                    <i class="bi bi-clock me-1"></i> {{ $days }} Hari
                                </span>
                            </td>
                            <td>
                                <div class="pe-4">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="fw-bold small" style="color: {{ $color }}">{{ $impact }}</span>
                                        <span class="text-slate-400 x-small">{{ min(round(($days/30)*100), 100) }}% Risk</span>
                                    </div>
                                    <div class="progress rounded-pill" style="height: 6px; background-color: #e2e8f0;">
                                        <div class="progress-bar" style="width: {{ min(($days/30)*100, 100) }}%; background-color: {{ $color }};"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center pe-4">
                                <a href="{{ route('dashboard') }}" class="btn btn-white border rounded-3 p-2 shadow-sm transition-all hover-lift">
                                    <i class="bi bi-arrow-up-right-square text-primary"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                                    <i class="bi bi-shield-check fs-1 text-success"></i>
                                </div>
                                <h6 class="fw-bold text-slate-800">Zero Downtime</h6>
                                <p class="text-slate-400 small">Seluruh alat saat ini berfungsi normal atau dalam respon cepat.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white p-4 border-0">
            {{ $downtime->links() }}
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
    .x-small { font-size: 10px; }
    
    .hover-lift:hover { transform: translateY(-3px); }
    .transition-all { transition: all 0.3s cubic-bezier(.4,0,.2,1); }
    
    .bg-glass {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .progress-bar {
        transition: width 0.6s ease;
    }
</style>
@endsection