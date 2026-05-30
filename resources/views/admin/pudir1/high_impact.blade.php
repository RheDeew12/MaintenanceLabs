@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    {{-- Header Section --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="text-white fw-bold mb-1">Prioritas Akademik (Alat Utama)</h3>
            <p class="text-white-50 small mb-0">Daftar alat praktikum kritis yang sedang dalam proses perbaikan/pemeliharaan</p>
        </div>
        <div class="bg-glass text-white px-4 py-2 rounded-pill shadow-sm">
            <i class="fas fa-exclamation-triangle me-2 text-warning"></i> 
            <span class="fw-bold">{{ $highImpact->total() }}</span> Alat Perlu Atensi
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden bg-white">
        <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold text-dark mb-0">
                <i class="fas fa-microscope me-2 text-danger"></i>Monitoring Perbaikan Aktif
            </h6>
            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2 small">
                High Impact Tool
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3">Informasi Alat</th>
                            <th>Unit Laboratorium</th>
                            <th>Progress Status</th>
                            <th>Indikator Urgensi</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($highImpact as $item) 
                        <tr>
                            <td class="ps-4">
                                {{-- PERBAIKAN: equipment -> barang & nama_alat -> nama_barang --}}
                                <div class="fw-bold text-dark">{{ $item->barang?->nama_barang ?? 'N/A' }}</div>
                                <div class="badge bg-light text-primary border rounded-pill font-monospace mt-1" style="font-size: 10px;">
                                    BMN: {{ $item->barang?->kode_bmn ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 border border-info border-opacity-25 rounded-pill fw-medium">
                                    <i class="fas fa-door-open me-1"></i> {{ $item->lab?->nama_lab ?? ($item->barang?->lab?->nama_lab ?? 'Unit N/A') }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusClass = 'warning';
                                    if($item->status == 'repairing') $statusClass = 'primary';
                                    if($item->status == 'pending_pudir1') $statusClass = 'danger';
                                @endphp
                                <div class="d-inline-flex align-items-center px-3 py-1 rounded-pill bg-{{ $statusClass }} bg-opacity-10 text-{{ $statusClass }} fw-bold" style="font-size: 11px; border: 1px solid rgba(var(--bs-{{ $statusClass }}-rgb), 0.2);">
                                    <i class="fas fa-spinner fa-spin me-2"></i> {{ strtoupper(str_replace('_', ' ', $item->status)) }}
                                </div>
                            </td>
                            <td>
                                <div class="small fw-bold {{ $item->status == 'pending_pudir1' ? 'text-danger' : 'text-muted' }}">
                                    @if($item->status == 'pending_pudir1')
                                        <i class="fas fa-bolt me-1"></i> Memerlukan Verifikasi Anda
                                    @else
                                        <i class="fas fa-clock me-1"></i> Sedang Ditangani Teknisi
                                    @endif
                                </div>
                                <div class="text-muted x-small mt-1 italic">
                                    Catatan: {{ Str::limit($item->technical_recommendation ?? 'Dalam proses pengecekan.', 40) }}
                                </div>
                            </td>
                            <td class="text-center pe-4">
                                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-white border shadow-sm rounded-pill px-3 fw-bold transition-all hover-lift">
                                    <i class="fas fa-search me-1 text-primary"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 bg-light bg-opacity-50">
                                <div class="opacity-25 mb-3">
                                    <i class="fas fa-check-circle fa-4x text-success"></i>
                                </div>
                                <h6 class="fw-bold text-dark">Kondisi Aman</h6>
                                <p class="text-muted small mb-0">Tidak ada alat utama praktikum yang sedang dalam perbaikan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($highImpact->hasPages())
        <div class="card-footer bg-white border-top py-3">
            <div class="d-flex justify-content-center">
                {{ $highImpact->withQueryString()->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .bg-glass {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .hover-lift:hover { transform: translateY(-2px); }
    .transition-all { transition: all 0.3s ease; }
    .x-small { font-size: 0.75rem; }
    .table thead th { font-weight: 700; letter-spacing: 0.5px; border-bottom: none; }
    .table tbody td { padding: 1.1rem 0.75rem; border-bottom: 1px solid #f1f5f9; }
</style>
@endsection