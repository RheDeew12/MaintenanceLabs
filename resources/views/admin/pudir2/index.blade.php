@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4" style="background-color: #f1f5f9; min-height: 100vh;">
    
    {{-- Header Section --}}
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div>
            <h2 class="fw-extrabold text-slate-800 mb-1" style="letter-spacing: -0.5px;">Dashboard Keuangan & Umum</h2>
            <p class="text-slate-500 small mb-0">Selamat datang kembali, Pembantu Direktur 2. Pantau realisasi anggaran hari ini.</p>
        </div>
        <div class="d-flex gap-2">
            <div class="bg-white px-3 py-2 rounded-3 shadow-sm border d-flex align-items-center">
                <i class="bi bi-calendar3 text-primary me-2"></i>
                <span class="small fw-bold text-slate-600">{{ now()->translatedFormat('d F Y') }}</span>
            </div>
        </div>
    </div>

    {{-- Statistik Cards: High Definition Design --}}
    <div class="row g-4 mb-5">
        {{-- Antrean Persetujuan --}}
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 position-relative overflow-hidden transition-all hover-lift h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="rounded-3 p-2 d-flex align-items-center justify-content-center" style="background: #6366f115; width: 48px; height: 48px;">
                            <i class="bi bi-file-earmark-check fs-4" style="color: #6366f1"></i>
                        </div>
                        <a href="{{ route('pudir2.approval') }}" class="btn btn-sm btn-light rounded-pill px-3 fw-bold small border">Tinjau</a>
                    </div>
                    {{-- FIX: Menggunakan total() dari Paginator --}}
                    <h3 class="fw-bold text-slate-800 mb-1">{{ $approvalQueue->total() }}</h3>
                    <p class="text-slate-500 small mb-0 fw-medium text-uppercase" style="letter-spacing: 0.5px;">Antrean Persetujuan</p>
                </div>
                <div class="position-absolute bottom-0 start-0 w-100" style="height: 4px; background: #6366f1"></div>
            </div>
        </div>

        {{-- Realisasi Anggaran --}}
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 position-relative overflow-hidden transition-all hover-lift h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="rounded-3 p-2 d-flex align-items-center justify-content-center" style="background: #10b98115; width: 48px; height: 48px;">
                            <i class="bi bi-wallet2 fs-4" style="color: #10b981"></i>
                        </div>
                        <a href="{{ route('pudir2.budget') }}" class="btn btn-sm btn-light rounded-pill px-3 fw-bold small border">Laporan</a>
                    </div>
                    <h3 class="fw-bold text-slate-800 mb-1">Rp {{ number_format($totalRealisasi, 0, ',', '.') }}</h3>
                    <p class="text-slate-500 small mb-0 fw-medium text-uppercase" style="letter-spacing: 0.5px;">Total Realisasi (Closed)</p>
                </div>
                <div class="position-absolute bottom-0 start-0 w-100" style="height: 4px; background: #10b981"></div>
            </div>
        </div>

        {{-- Vendor Aktif --}}
        <div class="col-xl-4 col-md-12">
            <div class="card border-0 shadow-sm rounded-4 position-relative overflow-hidden transition-all hover-lift h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="rounded-3 p-2 d-flex align-items-center justify-content-center" style="background: #f59e0b15; width: 48px; height: 48px;">
                            <i class="bi bi-truck fs-4" style="color: #f59e0b"></i>
                        </div>
                        <a href="{{ route('pudir2.vendor') }}" class="btn btn-sm btn-light rounded-pill px-3 fw-bold small border">Analisis</a>
                    </div>
                    {{-- FIX: Menyesuaikan filter vendor --}}
                    <h3 class="fw-bold text-slate-800 mb-1">{{ \App\Models\MaintenanceRequest::where('repair_type', 'External')->count() }}</h3>
                    <p class="text-slate-500 small mb-0 fw-medium text-uppercase" style="letter-spacing: 0.5px;">Pekerjaan Vendor Aktif</p>
                </div>
                <div class="position-absolute bottom-0 start-0 w-100" style="height: 4px; background: #f59e0b"></div>
            </div>
        </div>
    </div>

    {{-- Quick Preview Table --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-header bg-white p-4 border-0 d-flex align-items-center justify-content-between">
            <h5 class="fw-bold text-slate-800 mb-0">Permintaan Persetujuan Terbaru</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50 border-top">
                        <tr class="text-slate-400 small fw-bold text-uppercase" style="letter-spacing: 1px;">
                            <th class="ps-4 py-3 border-0">Aset & Kode</th>
                            <th class="border-0">Laboratorium</th>
                            <th class="border-0 text-center">Estimasi Biaya</th>
                            <th class="text-center pe-4 border-0">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($approvalQueue as $req)
                        <tr>
                            <td class="ps-4 py-4">
                                <div class="fw-bold text-slate-800">{{ $req->barang?->nama_barang }}</div>
                                <div class="text-slate-400 small font-monospace">{{ $req->barang?->kode_bmn ?? '-' }}</div>
                            </td>
                            <td>
                                <span class="badge bg-slate-100 text-slate-600 border px-2 py-1">{{ $req->lab?->nama_lab }}</span>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold text-primary">Rp {{ number_format($req->estimated_cost ?? 0, 0, ',', '.') }}</span>
                            </td>
                            <td class="text-center pe-4">
                                <a href="{{ route('pudir2.approval') }}" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <i class="bi bi-check2-circle fs-1 text-success opacity-25"></i>
                                <p class="text-slate-400 small mt-2">Tidak ada permintaan persetujuan anggaran saat ini.</p>
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
    .fw-extrabold { font-weight: 800; }
    .text-slate-800 { color: #1e293b; }
    .text-slate-600 { color: #475569; }
    .text-slate-500 { color: #64748b; }
    .text-slate-400 { color: #94a3b8; }
    .bg-slate-50 { background-color: #f8fafc; }
    .hover-lift:hover { transform: translateY(-5px); }
    .transition-all { transition: all 0.3s cubic-bezier(.4,0,.2,1); }
</style>
@endsection