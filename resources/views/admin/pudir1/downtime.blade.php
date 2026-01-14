@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="text-white fw-bold mb-1">Downtime Analytics</h3>
            <p class="text-white-50 small mb-0">Analisis durasi kerusakan alat terhadap kelancaran KBM</p>
        </div>
        <div class="bg-glass text-white px-3 py-2 rounded-pill small">
            <i class="fas fa-history me-2"></i> Real-time Monitoring
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-danger text-white">
                <div class="card-body p-3">
                    <h6 class="small text-uppercase opacity-75">Critical Downtime (>14 Hari)</h6>
                    <h3 class="fw-bold mb-0">{{ $downtime->filter(fn($row) => now()->diffInDays($row->created_at) > 14)->count() }} Alat</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-warning text-dark">
                <div class="card-body p-3">
                    <h6 class="small text-uppercase opacity-75">Warning (7-14 Hari)</h6>
                    <h3 class="fw-bold mb-0">{{ $downtime->filter(fn($row) => now()->diffInDays($row->created_at) >= 7 && now()->diffInDays($row->created_at) <= 14)->count() }} Alat</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between">
            <h6 class="fw-bold text-dark mb-0"><i class="fas fa-chart-line me-2 text-primary"></i>Daftar Alat Non-Aktif</h6>
            <span class="text-muted small">Menampilkan {{ $downtime->count() }} Permintaan Aktif</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4">Informasi Alat & Lab</th>
                            <th class="text-center">Tgl Kerusakan</th>
                            <th class="text-center">Durasi Downtime</th>
                            <th>Dampak Operasional (KBM)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($downtime as $row)
                        @php 
                            $days = now()->diffInDays($row->created_at);
                            $statusColor = $days > 14 ? 'danger' : ($days >= 7 ? 'warning' : 'info');
                            $impactText = $days > 14 ? 'Sangat Terganggu' : ($days >= 7 ? 'Terhambat' : 'Resiko Rendah');
                        @endphp
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $row->equipment->nama_alat }}</div>
                                <div class="badge bg-light text-primary border rounded-pill x-small">
                                    {{ $row->equipment->lab->nama_lab }}
                                </div>
                            </td>
                            <td class="text-center text-muted small">
                                {{ $row->created_at->format('d M Y') }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }} px-3 py-2 rounded-pill fw-bold" style="font-size: 0.9rem;">
                                    {{ $days }} Hari
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <div class="progress rounded-pill mb-1" style="height: 6px;">
                                            <div class="progress-bar bg-{{ $statusColor }}" style="width: {{ min(($days/21)*100, 100) }}%"></div>
                                        </div>
                                        <small class="fw-bold text-{{ $statusColor }}">{{ $impactText }}</small>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-check-circle fa-3x mb-3 text-success opacity-25"></i>
                                <p>Semua alat saat ini berfungsi normal atau dalam respon cepat.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($downtime->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $downtime->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .bg-glass { background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); }
    .x-small { font-size: 0.7rem; }
    .table thead th { font-weight: 700; border-bottom: none; }
    .bg-danger-subtle { background-color: #fee2e2; }
    .text-danger { color: #dc2626; }
    .bg-warning-subtle { background-color: #fef3c7; }
    .text-warning { color: #d97706; }
    .bg-info-subtle { background-color: #e0f2fe; }
    .text-info { color: #0284c7; }
</style>
@endsection