@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="text-white fw-bold mb-1">Dashboard Keuangan & Umum</h2>
            <p class="text-white-50 small mb-0">Selamat datang kembali, Pembantu Direktur 2</p>
        </div>
        <div class="text-end">
            <span class="badge bg-glass text-white px-3 py-2 rounded-pill">
                <i class="far fa-calendar-alt me-2"></i> {{ now()->translatedFormat('d F Y') }}
            </span>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase small fw-bold mb-2">Antrean Persetujuan</h6>
                            <h2 class="fw-extrabold mb-0">{{ $approvalQueue->total() }}</h2>
                        </div>
                        <div class="icon-shape bg-primary-subtle text-primary rounded-4 p-3">
                            <i class="fas fa-file-invoice-dollar fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('pudir2.approval') }}" class="text-primary fw-bold small text-decoration-none">
                            Tinjau Permintaan <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase small fw-bold mb-2">Realisasi Anggaran</h6>
                            {{-- Sesuaikan 'estimated_cost' dengan nama kolom di DB Anda --}}
                            <h2 class="fw-extrabold mb-0">Rp {{ number_format($completedMaintenance->sum('estimated_cost'), 0, ',', '.') }}</h2>
                        </div>
                        <div class="icon-shape bg-success-subtle text-success rounded-4 p-3">
                            <i class="fas fa-wallet fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('pudir2.budget') }}" class="text-success fw-bold small text-decoration-none">
                            Laporan Detail <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-12 mb-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase small fw-bold mb-2">Vendor Aktif</h6>
                            <h2 class="fw-extrabold mb-0">{{ $completedMaintenance->where('metode_perbaikan', 'vendor')->count() }}</h2>
                        </div>
                        <div class="icon-shape bg-warning-subtle text-warning rounded-4 p-3">
                            <i class="fas fa-truck-loading fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('pudir2.vendor') }}" class="text-warning fw-bold small text-decoration-none">
                            Analisis Vendor <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-glass {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
    }
    .fw-extrabold { font-weight: 800; }
    .icon-shape {
        width: 64px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection