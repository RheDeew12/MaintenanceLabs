@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <a href="{{ route('kaprodi.inventory') }}" class="btn btn-link text-decoration-none mb-3">
        <i class="fas fa-arrow-left"></i> Kembali ke Inventaris
    </a>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="fw-bold">{{ $item->nama_alat }}</h4>
            <span class="text-muted small">ID Asset: {{ $item->kode_aset }}</span>
        </div>
    </div>

    <h5 class="mb-3"><i class="fas fa-tools me-2"></i>Log Riwayat Perbaikan</h5>
    
    @foreach($item->maintenanceRequests as $history)
    <div class="card border-0 border-start border-4 border-primary shadow-sm mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h6 class="fw-bold mb-1">Tiket #{{ $history->id }} - {{ $history->status }}</h6>
                <small class="text-muted">{{ $history->created_at->format('d M Y') }}</small>
            </div>
            <p class="mb-1 small">{{ $history->issue_description }}</p>
            <div class="text-primary fw-bold small">Biaya: Rp {{ number_format($history->estimated_cost, 0, ',', '.') }}</div>
        </div>
    </div>
    @endforeach
</div>
@endsection