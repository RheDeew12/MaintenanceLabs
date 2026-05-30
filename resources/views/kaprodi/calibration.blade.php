@extends('layouts.admin')

@section('title', 'Monitoring Kalibrasi')

@section('content')
<div class="container-fluid py-4">
    {{-- Header Section dengan Statistik Ringkas --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6">
            <h3 class="fw-bold text-dark mb-1">Preventive Maintenance (Kalibrasi)</h3>
            <p class="text-muted small mb-0">Pemantauan akurasi alat ukur laboratorium Politeknik ATK Yogyakarta.</p>
        </div>
        <div class="col-12 col-md-6 d-flex justify-content-md-end align-items-center gap-2">
            <div class="bg-white border rounded-4 px-3 py-2 shadow-sm d-flex align-items-center">
                <div class="page-icon me-2" style="width: 32px; height: 32px;">
                    <i class="bi bi-calendar-check fs-6"></i>
                </div>
                <div class="small">
                    <div class="text-muted" style="font-size: 10px;">Hari Ini</div>
                    <strong class="text-dark">{{ now()->translatedFormat('d F Y') }}</strong>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Info untuk Masa Kalibrasi --}}
    <div class="alert alert-primary border-0 shadow-sm rounded-4 d-flex align-items-center p-3 mb-4" role="alert">
        <i class="bi bi-info-circle-fill fs-4 me-3"></i>
        <div class="small">
            <strong>Informasi:</strong> Alat dengan status <span class="badge bg-danger">OVERDUE</span> memerlukan tindakan kalibrasi segera untuk menjamin akurasi hasil praktikum.
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden bg-white">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="m-0 fw-bold text-primary">
                <i class="bi bi-clock-history me-2"></i>Monitoring Masa Kalibrasi Alat
            </h6>
            <div class="d-flex gap-2">
                <input type="text" id="searchInput" class="form-control form-control-sm rounded-pill px-3" placeholder="Cari alat atau kode...">
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="calibrationTable">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3" style="width: 50px;">No</th>
                            <th>Informasi Alat</th>
                            <th>Laboratorium</th>
                            <th class="text-center">Jadwal Kalibrasi</th>
                            <th class="text-center">Sisa Waktu</th>
                            <th class="text-center">Status</th>
                            <th class="pe-4 text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($needs_calibration as $index => $item)
                        @php
                            $nextCal = $item->next_calibration ? \Carbon\Carbon::parse($item->next_calibration) : null;
                            $daysLeft = $nextCal ? now()->startOfDay()->diffInDays($nextCal->startOfDay(), false) : null;
                            
                            // Logika Warna & Label
                            if ($daysLeft === null) {
                                $status = ['color' => 'secondary', 'label' => 'NO DATA', 'icon' => 'bi-question-circle'];
                            } elseif ($daysLeft < 0) {
                                $status = ['color' => 'danger', 'label' => 'OVERDUE', 'icon' => 'bi-exclamation-triangle-fill'];
                            } elseif ($daysLeft <= 30) {
                                $status = ['color' => 'warning', 'label' => 'NEAR DUE', 'icon' => 'bi-hourglass-split'];
                            } else {
                                $status = ['color' => 'success', 'label' => 'SAFE', 'icon' => 'bi-check-circle-fill'];
                            }
                        @endphp
                        <tr class="{{ $daysLeft < 0 ? 'table-danger-soft' : '' }}">
                            <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->nama_barang }}</div>
                                <div class="small text-muted font-monospace" style="font-size: 11px;">{{ $item->kode_bmn ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-primary border rounded-pill fw-medium">
                                    {{ $item->lab->nama_lab ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($nextCal)
                                    <div class="fw-bold">{{ $nextCal->format('d/m/Y') }}</div>
                                    <div class="text-muted" style="font-size: 10px;">{{ $nextCal->diffForHumans() }}</div>
                                @else
                                    <span class="text-muted small">Belum diatur</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($daysLeft !== null)
                                    <div class="fw-bold text-{{ $status['color'] }}">
                                        {{ $daysLeft < 0 ? 'Terlambat ' . abs($daysLeft) : $daysLeft }} Hari
                                    </div>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="status-badge bg-{{ $status['color'] }} bg-opacity-10 text-{{ $status['color'] }} border border-{{ $status['color'] }} border-opacity-25">
                                    <i class="bi {{ $status['icon'] }} me-1"></i> {{ $status['label'] }}
                                </div>
                            </td>
                            <td class="pe-4 text-center">
                                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-{{ $status['color'] }} rounded-pill px-3 fw-bold shadow-sm btn-action">
                                    <i class="bi bi-file-earmark-plus me-1"></i> Ajukan
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-clipboard-check text-muted opacity-25" style="font-size: 4rem;"></i>
                                <p class="text-muted fw-medium mt-3">Seluruh alat saat ini dalam kondisi terkalibrasi.</p>
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
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 50rem;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.5px;
    }
    .table-danger-soft { background-color: rgba(220, 53, 69, 0.02); }
    .btn-action { transition: all 0.2s ease; font-size: 11px; }
    .btn-action:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
    #calibrationTable thead th { font-size: 11px; letter-spacing: 0.8px; border-top: none; }
</style>

<script>
    // Fitur Pencarian Real-time
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll('#calibrationTable tbody tr');
        
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
        });
    });
</script>
@endsection