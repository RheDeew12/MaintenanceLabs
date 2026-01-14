@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 bg-primary p-4 rounded-3 shadow">
        <div>
            <h2 class="text-white mb-0 fw-bold">Master Inventaris Alat</h2>
            <p class="text-white-50 mb-0">Program Studi: {{ Auth::user()->prodi->nama_prodi ?? 'N/A' }}</p>
        </div>
        <button class="btn btn-light shadow-sm" onclick="window.print()">
            <i class="fas fa-file-pdf me-2"></i>Cetak Laporan Aset
        </button>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body">
                    <h6>Siap Pakai</h6>
                    <h3>{{ $equipment->where('status_kondisi', 'Normal')->count() }} Unit</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-warning text-dark">
                <div class="card-body">
                    <h6>Dalam Pemeliharaan</h6>
                    <h3>{{ $equipment->whereNotIn('status_kondisi', ['Normal', 'Rusak'])->count() }} Unit</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-danger text-white">
                <div class="card-body">
                    <h6>Rusak/Afkir</h6>
                    <h3>{{ $equipment->where('status_kondisi', 'Rusak')->count() }} Unit</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-secondary">
                            <th class="ps-4">No</th>
                            <th>Info Alat</th>
                            <th>Spesifikasi</th>
                            <th>Lokasi</th>
                            <th>Kondisi</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($equipment as $index => $item)
                        <tr>
                            <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->nama_alat }}</div>
                                <small class="text-primary font-monospace">{{ $item->kode_aset }}</small>
                            </td>
                            <td>
                                <div class="small">Merk: <span class="text-muted">{{ $item->merk }}</span></div>
                                <div class="small">Tahun: <span class="text-muted">{{ $item->tahun_perolehan }}</span></div>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark fw-normal">
                                    <i class="fas fa-door-open me-1"></i> {{ $item->lab->nama_lab ?? '-' }}
                                </span>
                            </td>
                            <td>
                                @if($item->status_kondisi == 'Normal')
                                    <span class="badge rounded-pill bg-success-soft text-success border border-success px-3">
                                        <i class="fas fa-check-circle me-1"></i> Siap Pakai
                                    </span>
                                @elseif($item->status_kondisi == 'Rusak')
                                    <span class="badge rounded-pill bg-danger-soft text-danger border border-danger px-3">
                                        <i class="fas fa-times-circle me-1"></i> Rusak
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-warning-soft text-warning border border-warning px-3">
                                        <i class="fas fa-tools me-1"></i> Maintenance
                                    </span>
                                @endif
                            </td>
                            <td class="text-center pe-4">
                                <a href="{{ route('kaprodi.equipment.history', $item->id) }}" 
                                   class="btn btn-sm btn-primary shadow-sm px-3">
                                    <i class="fas fa-history me-1"></i> Riwayat Servis
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="mb-3 opacity-25">
                                <p class="text-muted">Tidak ada data alat ditemukan untuk prodi ini.</p>
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
    /* Custom Styling untuk UI soft-badge */
    .bg-success-soft { background-color: #e8f5e9; }
    .bg-danger-soft { background-color: #ffebee; }
    .bg-warning-soft { background-color: #fff3e0; }
    .table thead th { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; }
    @media print {
        .btn, .mb-4.bg-primary, .stats-row, .card-header, .text-center.pe-4 { display: none !important; }
        .container-fluid { width: 100%; padding: 0; }
        .card { box-shadow: none !important; border: 1px solid #ddd !important; }
    }
</style>
@endsection