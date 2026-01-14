@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark mb-0">Realisasi Anggaran Pemeliharaan</h3>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm" onclick="window.print()">
            <i class="bi bi-printer me-2"></i> Cetak Laporan
        </button>
    </div>
    
    {{-- Ringkasan Anggaran (KPI Cards) --}}
    <div class="row mb-4 g-3">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4 p-4 text-center bg-white transition-all hover-lift">
                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                    <i class="bi bi-wallet2 text-primary fs-3"></i>
                </div>
                <small class="text-muted d-block text-uppercase fw-bold mb-1" style="font-size: 11px; letter-spacing: 1px;">Total Anggaran Terserap</small>
                {{-- Menggunakan sum('estimated_cost') untuk akumulasi biaya --}}
                <h2 class="text-primary fw-bold mb-0">Rp {{ number_format($completedMaintenance->sum('estimated_cost'), 0, ',', '.') }}</h2>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4 p-4 text-center bg-white transition-all hover-lift">
                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                    <i class="bi bi-check-all text-success fs-3"></i>
                </div>
                <small class="text-muted d-block text-uppercase fw-bold mb-1" style="font-size: 11px; letter-spacing: 1px;">Jumlah Pekerjaan Realisasi</small>
                <h2 class="text-success fw-bold mb-0">{{ $completedMaintenance->count() }} Item</h2>
            </div>
        </div>
    </div>

    {{-- Tabel Rincian --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white py-4 px-4 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark">Rincian Transaksi Anggaran</h5>
                <span class="badge bg-light text-muted border px-3 py-2 rounded-pill small">Data Tahun {{ date('Y') }}</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase fw-bold">
                        <tr>
                            <th class="ps-4">Tgl Selesai / Update</th>
                            <th>Aset & Kode BMN</th>
                            <th>Laboratorium</th>
                            <th>Metode Kerja</th>
                            <th class="pe-4 text-end">Biaya Realisasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($completedMaintenance as $item)
                        <tr class="transition-all hover-bg-light">
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $item->updated_at->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $item->updated_at->diffForHumans() }}</small>
                            </td>
                            <td>
                                <div class="fw-bold text-primary">{{ $item->equipment->nama_alat ?? 'Alat Tidak Ditemukan' }}</div>
                                <div class="text-muted small font-monospace">{{ $item->equipment->kode_aset ?? '-' }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border border-opacity-25 px-2 py-1">
                                    <i class="bi bi-geo-alt-fill text-primary me-1"></i>
                                    {{ $item->equipment->lab->nama_lab ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $item->repair_type == 'Internal' ? 'bg-info-subtle text-info' : 'bg-secondary-subtle text-dark' }} px-3 py-1 rounded-pill">
                                    {{ $item->repair_type ?? 'MANDIRI' }}
                                </span>
                            </td>
                            {{-- Penyesuaian nama kolom database: estimated_cost --}}
                            <td class="fw-bold text-dark text-end pe-4">
                                Rp {{ number_format($item->estimated_cost, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted fst-italic">
                                <i class="bi bi-clipboard-x fs-1 d-block mb-3 opacity-25"></i>
                                Belum ada realisasi anggaran pemeliharaan yang tercatat dalam sistem.
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
    .hover-lift:hover { transform: translateY(-5px); transition: all 0.3s ease; }
    .hover-bg-light:hover { background-color: rgba(0,0,0,0.02); }
    .transition-all { transition: all 0.2s ease-in-out; }
</style>
@endsection