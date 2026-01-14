@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="text-white fw-bold mb-1">Performa Vendor & Pihak Luar</h3>
            <p class="text-white-50 small mb-0">Evaluasi biaya dan efektivitas mitra pemeliharaan eksternal</p>
        </div>
        <div class="bg-glass text-white px-3 py-2 rounded-pill small">
            <i class="fas fa-handshake me-2"></i> Total Riwayat: {{ $completedMaintenance->total() }}
        </div>
    </div>

    <div class="card shadow border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h6 class="fw-bold text-dark mb-0">
                <i class="fas fa-list-ul me-2 text-primary"></i>Daftar Transaksi Pemeliharaan Eksternal
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4">Alat & Kode Aset</th>
                            <th>Partner / Vendor</th>
                            <th>Total Biaya</th>
                            <th class="text-center">Status Akhir</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($completedMaintenance as $item)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="icon-shape bg-primary-subtle text-primary rounded-3 me-3">
                                        <i class="fas fa-tools"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $item->equipment->nama_alat }}</div>
                                        <small class="text-muted text-xs">{{ $item->equipment->kode_aset ?? 'Tanpa Kode' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->nama_vendor ?? 'Vendor Eksternal' }}</div>
                                <span class="badge bg-light text-muted rounded-pill border x-small">Pihak Ketiga</span>
                            </td>
                            <td>
                                <div class="text-dark fw-bold">Rp {{ number_format($item->estimated_cost ?? $item->estimasi_biaya, 0, ',', '.') }}</div>
                                <small class="text-success text-xs"><i class="fas fa-check-circle me-1"></i>Telah Direalisasi</small>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusClass = [
                                        'closed' => 'success',
                                        'repairing' => 'warning',
                                        'waiting_verification' => 'info'
                                    ][$item->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $statusClass }}-subtle text-{{ $statusClass }} border border-{{ $statusClass }}-subtle px-3 py-2 rounded-pill">
                                    <i class="fas fa-circle me-1 small"></i> {{ strtoupper($item->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('maintenance.print', $item->id) }}" target="_blank" class="btn btn-sm btn-light rounded-circle shadow-sm" title="Cetak Kwitansi/Tiket">
                                    <i class="fas fa-print text-primary"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="opacity-25 mb-3">
                                    <i class="fas fa-file-invoice-dollar fa-4x"></i>
                                </div>
                                <p class="text-muted">Belum ada data perbaikan vendor yang tercatat.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Link Paginasi --}}
        @if($completedMaintenance->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $completedMaintenance->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .bg-glass { background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); }
    .icon-shape { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
    .x-small { font-size: 0.7rem; }
    .text-xs { font-size: 0.75rem; }
    .table tbody td { padding-top: 1rem; padding-bottom: 1rem; }
</style>
@endsection