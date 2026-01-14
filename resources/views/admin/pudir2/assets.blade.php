@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">Kesehatan & Depresiasi Aset</h3>
        <span class="badge bg-primary px-3 py-2 rounded-pill shadow-sm">
            Tahun Analisis: {{ date('Y') }}
        </span>
    </div>

    <div class="alert alert-warning border-0 shadow-sm rounded-4 d-flex align-items-center">
        <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-warning"></i>
        <div>
            <strong>Pemberitahuan Depresiasi:</strong> Daftar alat di bawah ini telah beroperasi <strong>lebih dari 5 tahun</strong>. 
            Disarankan untuk mengevaluasi kelayakan teknis atau merencanakan pengadaan baru.
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="mb-0 fw-bold text-muted small text-uppercase">Daftar Aset Kritis (> 5 Tahun)</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase fw-bold">
                    <tr>
                        <th class="ps-4">Nama Alat & Kode</th>
                        <th>Tahun Perolehan</th>
                        <th>Umur Aset</th>
                        <th>Lokasi Lab</th>
                        <th>Status Kondisi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assetHealth as $asset)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark">{{ $asset->nama_alat }}</div>
                            <small class="text-muted">{{ $asset->kode_aset ?? '-' }}</small>
                        </td>
                        <td><span class="fw-bold text-secondary">{{ $asset->tahun_perolehan }}</span></td>
                        <td>
                            @php 
                                $age = date('Y') - $asset->tahun_perolehan; 
                            @endphp
                            <span class="badge {{ $age > 5? 'bg-danger' : 'bg-warning text-dark' }} px-3 py-2 rounded-pill shadow-sm">
                                {{ $age }} Tahun
                            </span>
                        </td>
                        <td>
                            <span class="text-primary fw-semibold small">
                                <i class="bi bi-geo-alt-fill me-1"></i>{{ $asset->lab->nama_lab ?? 'Lokasi Belum Diatur' }}
                            </span>
                        </td>
                        <td>
                            @if($asset->status_kondisi == 'Normal')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                    {{ $asset->status_kondisi }}
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">
                                    {{ $asset->status_kondisi }}
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('kaprodi.equipment.history', $asset->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm transition-all">
                                <i class="bi bi-clock-history me-1"></i> Riwayat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted fst-italic">
                            <i class="bi bi-shield-check fs-1 d-block mb-2 opacity-25 text-success"></i>
                            Tidak ada aset yang melebihi masa depresiasi 5 tahun dalam database Anda.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .transition-all { transition: all 0.2s ease-in-out; }
    .transition-all:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
</style>
@endsection