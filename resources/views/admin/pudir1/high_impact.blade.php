@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="text-white fw-bold mb-1">Prioritas Akademik (Alat Utama)</h3>
            <p class="text-white-50 small mb-0">Daftar alat pendidikan kritis yang sedang dalam proses pemeliharaan</p>
        </div>
        <div class="bg-glass text-white px-3 py-2 rounded-pill small">
            <i class="fas fa-exclamation-circle me-2"></i> {{ $highImpact->total() }} Alat Perlu Perhatian
        </div>
    </div>

    <div class="card shadow border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h6 class="fw-bold text-dark mb-0"><i class="fas fa-tools me-2 text-danger"></i>Monitoring Perbaikan Aktif</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4">Alat Utama</th>
                            <th>Laboratorium</th>
                            <th>Progres Status</th>
                            <th>Urgensi / Catatan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($highImpact as $item) 
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $item->equipment->nama_alat }}</div>
                                <small class="text-muted">SN: {{ $item->equipment->kode_aset ?? '-' }}</small>
                            </td>
                            <td>
                                <span class="badge bg-info-subtle text-info rounded-pill px-3">
                                    {{ $item->equipment->lab->nama_lab }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill">
                                    <i class="fas fa-spinner fa-spin me-1"></i> {{ strtoupper($item->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center text-danger small fw-bold">
                                    <i class="fas fa-clock me-2"></i> Persiapan Sertifikasi / KBM
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-light rounded-circle shadow-sm" title="Lihat Detail">
                                    <i class="fas fa-eye text-primary"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <img src="{{ asset('assets/img/empty-state.png') }}" alt="" style="width: 100px;" class="opacity-50 mb-3">
                                <p class="text-muted mb-0">Tidak ada alat utama praktikum yang sedang dalam perbaikan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Paginasi --}}
        @if($highImpact->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $highImpact->withQueryString()->links() }}
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
    .table thead th { font-weight: 700; letter-spacing: 0.5px; border-bottom: none; }
    .table tbody td { border-bottom: 1px solid #f8f9fa; padding: 1rem 0.75rem; }
</style>
@endsection