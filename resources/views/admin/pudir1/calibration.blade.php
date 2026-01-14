@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="text-white fw-bold mb-1">Monitoring Kalibrasi Alat</h3>
            <p class="text-white-50 small mb-0">Penjaminan mutu akurasi alat ukur laboratorium</p>
        </div>
        <div class="bg-glass text-white px-3 py-2 rounded-pill small">
            <i class="fas fa-check-double me-2"></i> Standar ISO/IEC 17025
        </div>
    </div>

    <div class="row mb-4 text-center">
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    <div class="icon-shape bg-success-subtle text-success rounded-circle mx-auto mb-3">
                        <i class="fas fa-certificate fa-2x"></i>
                    </div>
                    <h5 class="text-muted small text-uppercase fw-bold">Alat Terkalibrasi</h5>
                    <h1 class="fw-extrabold text-success mb-0">{{ $terkalibrasi }}</h1>
                    <small class="text-muted">Akurasi Terjamin</small>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    <div class="icon-shape bg-danger-subtle text-danger rounded-circle mx-auto mb-3">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                    <h5 class="text-muted small text-uppercase fw-bold">Kalibrasi Kadaluarsa</h5>
                    <h1 class="fw-extrabold text-danger mb-0">{{ $expired }}</h1>
                    <small class="text-muted">Perlu Tindakan Segera</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h6 class="fw-bold text-dark mb-0">
                <i class="fas fa-hourglass-half me-2 text-warning"></i>Perhatian Khusus (Expired < 30 Hari)
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-4">Nama Alat</th>
                            <th>Laboratorium</th>
                            <th>Tgl Kalibrasi Terakhir</th>
                            <th>Jadwal Kalibrasi Ulang</th>
                            <th class="text-center">Sisa Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($upcoming as $item)
                        <tr>
                            <td class="ps-4 fw-bold text-dark">{{ $item->nama_alat }}</td>
                            <td>{{ $item->lab->nama_lab }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->last_calibration)->format('d/m/Y') }}</td>
                            <td class="text-danger fw-bold">{{ \Carbon\Carbon::parse($item->next_calibration)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill">
                                    {{ now()->diffInDays($item->next_calibration) }} Hari lagi
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-shield-check fa-3x mb-3 text-success opacity-25"></i>
                                <p>Tidak ada alat yang mendekati masa kadaluarsa kalibrasi dalam waktu dekat.</p>
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
    .bg-glass { background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); }
    .fw-extrabold { font-weight: 800; }
    .icon-shape { width: 70px; height: 70px; display: flex; align-items: center; justify-content: center; }
    .bg-success-subtle { background-color: #dcfce7; }
    .bg-danger-subtle { background-color: #fee2e2; }
    .bg-warning-subtle { background-color: #fef3c7; }
</style>
@endsection