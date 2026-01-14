@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="text-white fw-bold mb-1">Lab Readiness Index</h3>
            <p class="text-white-50 small mb-0">Kesiapan Infrastruktur Laboratorium untuk KBM</p>
        </div>
        <div class="bg-glass text-white px-3 py-2 rounded-pill small">
            <i class="fas fa-microscope me-2"></i> Total: {{ $readiness->count() }} Lab
        </div>
    </div>

    <div class="row">
        @foreach($readiness as $lab)
            @php 
                $persen = $lab->total_alat > 0 ? round(($lab->alat_siap / $lab->total_alat) * 100) : 0;
                // Menentukan warna berdasarkan persentase
                $colorClass = $persen >= 80 ? 'success' : ($persen >= 50 ? 'warning' : 'danger');
            @endphp
            
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">{{ $lab->nama_lab }}</h5>
                                <span class="text-muted small">ID Lab: #{{ $lab->id }}</span>
                            </div>
                            <span class="badge bg-{{ $colorClass }}-subtle text-{{ $colorClass }} px-3 py-2 rounded-pill">
                                {{ $persen }}% Siap
                            </span>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between small mb-2">
                                <span class="text-muted">Status Kesiapan Alat</span>
                                <span class="fw-bold">{{ $lab->alat_siap }} / {{ $lab->total_alat }} Unit</span>
                            </div>
                            <div class="progress rounded-pill" style="height: 10px;">
                                <div class="progress-bar bg-{{ $colorClass }} shadow-none" 
                                     role="progressbar" 
                                     style="width: {{ $persen }}%" 
                                     aria-valuenow="{{ $persen }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                </div>
                            </div>
                        </div>

                        <div class="row text-center border-top pt-3">
                            <div class="col-6 border-end">
                                <p class="text-muted small mb-0">Normal</p>
                                <h6 class="fw-bold text-success mb-0">{{ $lab->alat_siap }}</h6>
                            </div>
                            <div class="col-6">
                                <p class="text-muted small mb-0">Bermasalah</p>
                                <h6 class="fw-bold text-danger mb-0">{{ $lab->total_alat - $lab->alat_siap }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .bg-glass {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .card { transition: transform 0.2s ease; }
    .card:hover { transform: translateY(-5px); }
</style>
@endsection