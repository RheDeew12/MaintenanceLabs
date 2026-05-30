@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4" style="background-color: #f1f5f9; min-height: 100vh;">
    
    {{-- Header Section --}}
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div>
            <h2 class="fw-extrabold text-slate-800 mb-1" style="letter-spacing: -0.5px;">Kesehatan & Depresiasi Aset</h2>
            <p class="text-slate-500 small mb-0">Analisis siklus hidup dan masa pakai alat laboratorium Politeknik ATK.</p>
        </div>
        <div class="bg-white px-3 py-2 rounded-3 shadow-sm border d-flex align-items-center">
            <i class="bi bi-calendar-check text-primary me-2"></i>
            <span class="small fw-bold text-slate-600">Analisis: {{ date('Y') }}</span>
        </div>
    </div>

    {{-- Filter & Search Section --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ url()->current() }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-slate-600 text-uppercase">Cari Alat</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 border-2"><i class="bi bi-search text-slate-400"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 border-2 rounded-end-3" 
                               placeholder="Nama barang atau kode BMN..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-slate-600 text-uppercase">Unit Laboratorium</label>
                    <select name="lab_id" class="form-select border-2 rounded-3">
                        <option value="">Semua Lab</option>
                        {{-- Memastikan variabel $labs tersedia dari controller --}}
                        @if(isset($labs))
                            @foreach($labs as $lab)
                                <option value="{{ $lab->id }}" {{ request('lab_id') == $lab->id ? 'selected' : '' }}>
                                    {{ $lab->nama_lab }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-slate-600 text-uppercase">Urutkan Umur</label>
                    <select name="sort_age" class="form-select border-2 rounded-3">
                        <option value="desc" {{ request('sort_age') == 'desc' ? 'selected' : '' }}>Tertua ke Terbaru</option>
                        <option value="asc" {{ request('sort_age') == 'asc' ? 'selected' : '' }}>Terbaru ke Tertua</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100 rounded-3 fw-bold shadow-sm">
                        Filter
                    </button>
                    <a href="{{ url()->current() }}" class="btn btn-light border w-100 rounded-3 fw-bold">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Alert Section: High Profile --}}
    @if($assetHealth->count() > 0)
    <div class="alert border-0 shadow-sm rounded-4 d-flex align-items-start p-4 mb-5" style="background-color: #fffbeb; border-left: 6px solid #f59e0b !important;">
        <i class="bi bi-exclamation-octagon-fill fs-3 me-3 text-warning"></i>
        <div>
            <h6 class="fw-bold text-slate-800 mb-1">Pemberitahuan Ambang Batas Depresiasi</h6>
            <p class="text-slate-600 small mb-0">
                Daftar alat di bawah ini telah beroperasi <strong>lebih dari 10 tahun</strong>. 
                Sesuai kebijakan teknis, aset ini masuk dalam kategori <strong>Prioritas Peremajaan</strong>.
            </p>
        </div>
    </div>
    @endif

    {{-- Asset Health Table --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-header bg-white p-4 border-0 d-flex align-items-center justify-content-between border-bottom">
            <h5 class="fw-bold text-slate-800 mb-0">Katalog Aset Kritis (> 10 Tahun)</h5>
            <span class="badge bg-slate-100 text-slate-600 rounded-pill px-3 py-2 border small fw-medium">
                Total: {{ $assetHealth->count() }} Item Terdeteksi
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50">
                        <tr class="text-slate-400 small fw-bold text-uppercase" style="letter-spacing: 1px;">
                            <th class="ps-4 py-3 border-0">Identitas Alat & BMN</th>
                            <th class="border-0 text-center">Tahun Perolehan</th>
                            <th class="border-0 text-center">Umur Teknis</th>
                            <th class="border-0">Unit Laboratorium</th>
                            <th class="border-0">Kondisi</th>
                            <th class="text-center pe-4 border-0">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($assetHealth as $asset)
                        <tr>
                            <td class="ps-4 py-4">
                                <div class="fw-bold text-slate-800">{{ $asset->nama_barang }}</div>
                                <div class="text-slate-400 small font-monospace" style="font-size: 11px;">{{ $asset->kode_bmn ?? 'SN-UNKNOWN' }}</div>
                            </td>
                            <td class="text-center text-slate-600 fw-bold">{{ $asset->tahun_perolehan }}</td>
                            <td class="text-center">
                                @php 
                                    $age = date('Y') - $asset->tahun_perolehan; 
                                    $ageColor = $age > 15 ? '#ef4444' : '#f59e0b';
                                @endphp
                                <span class="badge px-3 py-2 rounded-3 fw-bold shadow-none" 
                                      style="background: {{ $ageColor }}15; color: {{ $ageColor }}; border: 1px solid {{ $ageColor }}30;">
                                    {{ $age }} Tahun
                                </span>
                            </td>
                            <td>
                                <span class="text-slate-600 fw-medium small">
                                    <i class="bi bi-geo-alt-fill text-primary me-1"></i>
                                    {{ $asset->lab->nama_lab ?? 'Lokasi N/A' }}
                                </span>
                            </td>
                            <td>
                                @php 
                                    // SINKRONISASI: Menganggap 'Normal' dan 'Baik' sebagai status positif
                                    $isNormal = in_array($asset->status_kondisi, ['Normal', 'Baik']); 
                                @endphp
                                <div class="d-inline-flex align-items-center px-3 py-1 rounded-pill fw-bold" 
                                     style="font-size: 10px; background: {{ $isNormal ? '#10b98115' : '#ef444415' }}; color: {{ $isNormal ? '#10b981' : '#ef4444' }}; border: 1px solid {{ $isNormal ? '#10b98130' : '#ef444430' }};">
                                    <span class="rounded-circle me-2" style="width: 6px; height: 6px; background: currentColor;"></span>
                                    {{ strtoupper($asset->status_kondisi) }}
                                </div>
                            </td>
                            <td class="text-center pe-4">
                                <a href="{{ route('kaprodi.equipment.history', $asset->id) }}" 
                                   class="btn btn-white border rounded-3 p-2 shadow-sm transition-all hover-lift">
                                    <i class="bi bi-clock-history text-primary"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-shield-check-fill fs-1 text-success opacity-50 mb-3 d-block"></i>
                                <h6 class="fw-bold text-slate-800">Tidak Ada Data</h6>
                                <p class="text-slate-400 small">Aset dengan kriteria tersebut tidak ditemukan.</p>
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
    .btn-white { background: white; }
    .hover-lift:hover { transform: translateY(-3px); }
    .transition-all { transition: all 0.3s cubic-bezier(.4,0,.2,1); }
    .form-control:focus, .form-select:focus { border-color: #4f46e5; box-shadow: none; }
</style>
@endsection