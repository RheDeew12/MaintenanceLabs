@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4" style="background-color: #f1f5f9; min-height: 100vh;">
    
    {{-- Header Section: Focused on Partnership & Evaluation --}}
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div>
            <h2 class="fw-extrabold text-slate-800 mb-1" style="letter-spacing: -0.5px;">Performa Vendor & Pihak Luar</h2>
            <p class="text-slate-500 small mb-0">Evaluasi efektivitas biaya dan kualitas pengerjaan dari mitra pemeliharaan eksternal.</p>
        </div>
        <div class="d-flex gap-3">
            <div class="bg-indigo-600 text-white px-4 py-2 rounded-4 shadow-sm d-flex align-items-center transition-all hover-lift">
                <i class="bi bi-handshake me-2"></i>
                <span class="small fw-bold">Total Riwayat: {{ $vendorRepairs->total() }}</span>
            </div>
        </div>
    </div>

    {{-- Summary Table Area --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-header bg-white p-4 border-0 d-flex align-items-center justify-content-between">
            <h5 class="fw-bold text-slate-800 mb-0"><i class="bi bi-list-stars me-2 text-primary"></i>Log Transaksi Pemeliharaan Eksternal</h5>
            <span class="badge bg-slate-100 text-slate-600 rounded-pill px-3 py-2 border small fw-medium">
                Penyedia Jasa Pihak Ketiga
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50 border-top">
                        <tr class="text-slate-400 small fw-bold text-uppercase" style="letter-spacing: 1px;">
                            <th class="ps-4 py-3 border-0">Aset & Kode BMN</th>
                            <th class="border-0">Partner / Vendor</th>
                            <th class="border-0">Total Biaya Realisasi</th>
                            <th class="text-center border-0">Status Tiket</th>
                            <th class="text-center pe-4 border-0">Dokumentasi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($vendorRepairs as $item)
                        <tr>
                            <td class="ps-4 py-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-3 p-2 me-3 d-flex align-items-center justify-content-center bg-indigo-100 text-indigo-600" style="width: 40px; height: 40px;">
                                        <i class="bi bi-cpu"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-slate-800">{{ $item->barang?->nama_barang ?? 'Unknown Asset' }}</div>
                                        <div class="text-slate-400 small font-monospace" style="font-size: 10px;">{{ $item->barang?->kode_bmn ?? 'SN-UNKNOWN' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-slate-700">{{ $item->nama_vendor ?? 'Vendor Pihak Ketiga' }}</div>
                                <div class="d-flex align-items-center mt-1">
                                    <span class="badge bg-amber-100 text-amber-700 px-2 py-1 rounded-pill" style="font-size: 9px;">MITRA LUAR</span>
                                </div>
                            </td>
                            <td>
                                <div class="text-slate-800 fw-extrabold fs-6">
                                    Rp {{ number_format($item->estimated_cost, 0, ',', '.') }}
                                </div>
                                <small class="text-success fw-bold" style="font-size: 10px;">
                                    <i class="bi bi-check-circle-fill me-1"></i>PAID / REALIZED
                                </small>
                            </td>
                            <td class="text-center">
                                @php
                                    $st = match($item->status) {
                                        'closed' => ['c' => '#10b981', 'bg' => '#10b98115', 'l' => 'SELESAI'],
                                        'repairing' => ['c' => '#3b82f6', 'bg' => '#3b82f615', 'l' => 'PROSES'],
                                        default => ['c' => '#64748b', 'bg' => '#64748b15', 'l' => strtoupper($item->status)]
                                    };
                                @endphp
                                <span class="badge px-3 py-2 rounded-pill fw-bold" 
                                      style="background: {{ $st['bg'] }}; color: {{ $st['c'] }}; border: 1px solid {{ $st['c'] }}30; font-size: 10px;">
                                    {{ $st['l'] }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('maintenance.print', $item->id) }}" target="_blank" 
                                       class="btn btn-white border rounded-3 p-2 shadow-sm transition-all hover-lift" 
                                       title="Cetak Faktur">
                                        <i class="bi bi-printer text-primary"></i>
                                    </a>
                                    <a href="{{ route('dashboard') }}" 
                                       class="btn btn-white border rounded-3 p-2 shadow-sm transition-all hover-lift" 
                                       title="Detail Pekerjaan">
                                        <i class="bi bi-eye text-slate-400"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 bg-light bg-opacity-50">
                                <div class="bg-white rounded-circle d-inline-flex p-4 mb-3 shadow-sm">
                                    <i class="bi bi-truck-flatbed fs-1 text-slate-200"></i>
                                </div>
                                <h6 class="fw-bold text-slate-800">Tidak Ada Data Vendor</h6>
                                <p class="text-slate-400 small">Belum ada riwayat perbaikan oleh pihak ketiga yang tercatat di sistem.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- Custom Pagination Styling --}}
        @if($vendorRepairs->hasPages())
        <div class="card-footer bg-white border-top p-4">
            <div class="d-flex justify-content-center">
                {{ $vendorRepairs->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .fw-extrabold { font-weight: 800; }
    .text-slate-800 { color: #1e293b; }
    .text-slate-700 { color: #334155; }
    .text-slate-600 { color: #475569; }
    .text-slate-500 { color: #64748b; }
    .text-slate-400 { color: #94a3b8; }
    .bg-slate-50 { background-color: #f8fafc; }
    .bg-indigo-100 { background-color: #e0e7ff; }
    .text-indigo-600 { color: #4f46e5; }
    .bg-amber-100 { background-color: #fef3c7; }
    .text-amber-700 { color: #b45309; }
    
    .hover-lift:hover { transform: translateY(-3px); }
    .transition-all { transition: all 0.3s cubic-bezier(.4,0,.2,1); }
    
    .table thead th { font-weight: 700; letter-spacing: 0.5px; border-bottom: none; }
    .table tbody td { border-bottom: 1px solid #f1f5f9; }
</style>
@endsection