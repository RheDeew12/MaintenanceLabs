@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    {{-- Header Section --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="text-white fw-bold mb-1">Lab Readiness Index</h3>
            <p class="text-white-50 small mb-0">Status Kesiapan Infrastruktur Berdasarkan Inventaris Terkini</p>
        </div>
        <div class="bg-glass text-white px-3 py-2 rounded-pill small">
            <i class="fas fa-microscope me-2"></i> Total: {{ $readiness->count() }} Unit Laboratorium
        </div>
    </div>

    <div class="row">
        @foreach($readiness as $lab)
            @php 
                // Perhitungan Persentase: Menganggap status 'Normal' & 'Baik' sebagai Siap
                $persen = $lab->total_alat > 0 ? round(($lab->alat_siap / $lab->total_alat) * 100) : 0;
                
                // Indikator Warna Dinamis
                $colorClass = $persen >= 80 ? 'success' : ($persen >= 50 ? 'warning' : 'danger');
            @endphp
            
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                    <div class="card-body p-4">
                        {{-- Top Info --}}
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">{{ $lab->nama_lab }}</h5>
                                <span class="badge bg-slate-100 text-slate-500 border small">ID: #{{ $lab->id }}</span>
                            </div>
                            <span class="badge bg-{{ $colorClass }}-subtle text-{{ $colorClass }} px-3 py-2 rounded-pill fw-bold">
                                {{ $persen }}% Fungsional
                            </span>
                        </div>

                        {{-- Progress Bar --}}
                        <div class="mb-4">
                            <div class="d-flex justify-content-between small mb-2">
                                <span class="text-muted small fw-semibold">Distribusi Alat Siap Pakai</span>
                                <span class="fw-bold">{{ $lab->alat_siap }} / {{ $lab->total_alat }} Unit</span>
                            </div>
                            <div class="progress rounded-pill bg-light" style="height: 12px;">
                                <div class="progress-bar bg-{{ $colorClass }} progress-bar-striped progress-bar-animated" 
                                     role="progressbar" 
                                     style="width: {{ $persen }}%" 
                                     aria-valuenow="{{ $persen }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>

                        {{-- Bottom Stats --}}
                        <div class="row text-center border-top pt-3">
                            <div class="col-6 border-end">
                                <p class="text-muted small mb-1">Siap Pakai</p>
                                <h6 class="fw-bold text-success mb-0">
                                    <i class="fas fa-check-circle me-1 small"></i> {{ $lab->alat_siap }}
                                </h6>
                                <small class="text-slate-400" style="font-size: 9px;">(Normal & Baik)</small>
                            </div>
                            <div class="col-6">
                                <p class="text-muted small mb-1">Bermasalah</p>
                                <h6 class="fw-bold text-danger mb-0">
                                    <i class="fas fa-exclamation-triangle me-1 small"></i> {{ $lab->total_alat - $lab->alat_siap }}
                                </h6>
                                <small class="text-slate-400" style="font-size: 9px;">(Rusak / Mainten)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    /* Styling khusus agar tampilan lebih premium dan sinkron */
    .bg-glass {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .transition-hover { 
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
    }
    .transition-hover:hover { 
        transform: translateY(-8px); 
        box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important;
    }
    .text-slate-500 { color: #64748b; }
    .text-slate-400 { color: #94a3b8; }
    .bg-slate-100 { background-color: #f1f5f9; }
    
    /* Warna Subtile Bootstrap 5 */
    .bg-success-subtle { background-color: #d1e7dd; }
    .bg-warning-subtle { background-color: #fff3cd; }
    .bg-danger-subtle { background-color: #f8d7da; }
</style>
@endsection