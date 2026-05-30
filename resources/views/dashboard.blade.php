@extends('layouts.admin')

@section('title', 'Dashboard Perawatan')

@section('content')
<div class="container-fluid px-4 py-4" style="background-color: #f8fafc; min-height: 100vh;">
    
    {{-- Notifikasi System --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 fade show d-flex align-items-center p-3" role="alert" style="background: #ecfdf5;">
            <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
            <div class="text-success fw-medium">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Header Section --}}
    <div class="row align-items-center mb-5">
        <div class="col-md-7">
            <h3 class="fw-bold text-dark mb-1">Manajemen Perawatan</h3>
            <p class="text-muted small mb-0">Pemantauan dan pengajuan pemeliharaan fasilitas unit kerja.</p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0">
            @if(Auth::user()->role == 'Kepala Lab')
                <button class="btn btn-primary rounded-pill px-4 py-2 shadow-sm fw-bold transition-all hover-lift" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-plus-lg me-2"></i> Buat Pengajuan
                </button>
            @endif
        </div>
    </div>

    {{-- Statistik KPI --}}
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-bottom border-primary border-4 transition-all hover-lift">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-3">
                        <i class="bi bi-collection text-primary fs-4"></i>
                    </div>
                    <div class="ms-3">
                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 10px;">Total Ajuan</small>
                        <h4 class="mb-0 fw-bold">{{ $maintenances->total() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-bottom border-warning border-4 transition-all hover-lift">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-warning bg-opacity-10 p-3 rounded-3">
                        <i class="bi bi-hourglass-split text-warning fs-4"></i>
                    </div>
                    <div class="ms-3">
                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 10px;">Pending</small>
                        <h4 class="mb-0 fw-bold">{{ $maintenances->whereIn('status', ['pending_kaprodi', 'pending_pudir1', 'pending_pudir2'])->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-bottom border-info border-4 transition-all hover-lift">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-info bg-opacity-10 p-3 rounded-3">
                        <i class="bi bi-tools text-info fs-4"></i>
                    </div>
                    <div class="ms-3">
                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 10px;">Proses</small>
                        <h4 class="mb-0 fw-bold">{{ $maintenances->where('status', 'repairing')->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-bottom border-success border-4 transition-all hover-lift">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded-3">
                        <i class="bi bi-check2-circle text-success fs-4"></i>
                    </div>
                    <div class="ms-3">
                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 10px;">Selesai</small>
                        <h4 class="mb-0 fw-bold">{{ $maintenances->where('status', 'closed')->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Table Section --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center border-bottom">
            <h5 class="fw-bold mb-0 text-dark">Riwayat Perawatan Unit</h5>
            <div class="badge bg-light text-primary border px-3 py-2 rounded-pill small">
                <i class="bi bi-building me-1"></i> {{ Auth::user()->lab->nama_lab ?? 'Seluruh Unit' }}
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: #fcfcfd;">
                    <tr class="text-uppercase small fw-bold text-muted">
                        <th class="ps-4 py-3 border-0">ID Tiket</th>
                        <th class="py-3 border-0">Informasi Alat</th>
                        <th class="py-3 border-0 text-center">Tgl Ajuan</th>
                        <th class="py-3 border-0">Status Progress</th>
                        <th class="py-3 border-0 text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($maintenances as $item)
                    <tr>
                        <td class="ps-4">
                            <span class="text-primary fw-bold">{{ $item->formatted_id }}</span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $item->barang->nama_barang ?? 'Alat Tidak Diketahui' }}</div>
                            <div class="text-muted small font-monospace" style="font-size: 11px;">
                                <i class="bi bi-hash me-1"></i>{{ $item->barang->kode_bmn ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="text-dark small">{{ $item->created_at->format('d M Y') }}</div>
                            <div class="text-muted" style="font-size: 10px;">{{ $item->created_at->format('H:i') }} WIB</div>
                        </td>
                        <td>
                            @php
                                $colorMap = [
                                    'closed' => 'success',
                                    'repairing' => 'info',
                                    'rejected' => 'danger',
                                    'pending_kaprodi' => 'warning',
                                    'pending_pudir1' => 'warning',
                                    'pending_pudir2' => 'warning',
                                ];
                                $color = $colorMap[$item->status] ?? 'secondary';
                            @endphp
                            <div class="d-inline-flex align-items-center px-3 py-1 rounded-pill bg-{{ $color }} bg-opacity-10 text-{{ $color }} fw-bold" style="font-size: 9px; border: 1px solid rgba(var(--bs-{{ $color }}-rgb), 0.2);">
                                <span class="me-1">●</span> {{ strtoupper(str_replace('_', ' ', $item->status)) }}
                            </div>
                        </td>
                        <td class="text-center pe-4">
                            @include('layouts.actions')
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="mb-3 opacity-25">
                            <p class="text-muted small">Tidak ada riwayat perawatan untuk unit ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($maintenances->hasPages())
        <div class="card-footer bg-white border-top py-3 px-4">
            {{ $maintenances->links() }}
        </div>
        @endif
    </div>
</div>

{{-- MODAL TAMBAH PENGAJUAN (NEW SEARCH UI) --}}
@if(Auth::user()->role == 'Kepala Lab')
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden bg-white">
            <form action="{{ route('maintenance.store') }}" method="POST" enctype="multipart/form-data">
                @csrf 
                <div class="modal-header border-0 p-4 pb-0 bg-white">
                    <div>
                        <h5 class="modal-title fw-bold text-dark">Buat Pengajuan Perbaikan</h5>
                        <p class="text-muted small mb-0">Lengkapi detail kerusakan alat unit kerja Anda.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    {{-- Alert Unit Info --}}
                    <div class="p-3 rounded-4 mb-4 d-flex align-items-center" style="background: #eff6ff; border: 1px solid #dbeafe;">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                            <i class="bi bi-info-circle text-primary fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block" style="font-size: 10px; font-weight: 700;">UNIT KERJA TERDETEKSI</small>
                            <span class="text-primary fw-bold small">{{ Auth::user()->lab->nama_lab ?? 'Admin Unit' }}</span>
                        </div>
                    </div>

                    {{-- CARI ALAT (INPUT AUTOCOMPLETE) --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase" style="letter-spacing: 0.5px;">Cari Alat (Ketik Nama / Kode BMN)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-2 border-end-0 rounded-start-3"><i class="bi bi-search text-muted"></i></span>
                            <input list="listAlat" name="barang_display" id="cariAlat" class="form-control border-2 py-2 px-3 rounded-end-3 shadow-none" placeholder="Ketik Nama Alat atau Nomor BMN..." required autocomplete="off">
                        </div>
                        <input type="hidden" name="barang_id" id="barang_id">
                        
                        <datalist id="listAlat">
                            @foreach($barangs as $b)
                                <option data-id="{{ $b->id }}" value="{{ $b->nama_barang }} [{{ $b->kode_bmn }}]">
                            @endforeach
                        </datalist>
                        <small class="text-primary mt-1 d-block" style="font-size: 10px; display: none;" id="infoAlatTerpilih">
                            <i class="bi bi-check-circle-fill"></i> Alat terverifikasi dalam sistem
                        </small>
                    </div>

                    {{-- Tingkat Kerusakan --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase" style="letter-spacing: 0.5px;">Tingkat Kerusakan</label>
                        <div class="row g-2">
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="damage_level" id="dmg-low" value="Ringan">
                                <label class="btn btn-outline-success w-100 border-2 py-2 rounded-3 small fw-bold" for="dmg-low">Ringan</label>
                            </div>
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="damage_level" id="dmg-med" value="Sedang" checked>
                                <label class="btn btn-outline-warning w-100 border-2 py-2 rounded-3 small fw-bold" for="dmg-med">Sedang</label>
                            </div>
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="damage_level" id="dmg-high" value="Berat">
                                <label class="btn btn-outline-danger w-100 border-2 py-2 rounded-3 small fw-bold" for="dmg-high">Berat</label>
                            </div>
                        </div>
                    </div>

                    {{-- Deskripsi Kerusakan --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase" style="letter-spacing: 0.5px;">Deskripsi Gejala / Kerusakan</label>
                        <textarea name="issue_description" class="form-control border-2 py-3 px-3 rounded-3 shadow-none" rows="3" placeholder="Contoh: Mesin macet dan tidak mengeluarkan suara..." required style="resize: none;"></textarea>
                    </div>

                    {{-- Bukti Foto --}}
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-muted text-uppercase" style="letter-spacing: 0.5px;">Foto Bukti Visual</label>
                        <input type="file" name="foto_kerusakan" class="form-control border-2 shadow-none py-2 rounded-3" accept="image/*">
                        <small class="text-muted mt-1 d-block" style="font-size: 10px;">Format: JPG, PNG. Maks: 2MB.</small>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-4 shadow fw-bold transition-all hover-lift">
                        Kirim Laporan Perbaikan <i class="bi bi-send-fill ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JAVASCRIPT UNTUK AUTO-MAPPING ID BARANG --}}
<script>
    document.getElementById('cariAlat').addEventListener('input', function(e) {
        var input = e.target;
        var list = document.getElementById('listAlat');
        var hiddenInput = document.getElementById('barang_id');
        var info = document.getElementById('infoAlatTerpilih');
        var inputValue = input.value;
        
        hiddenInput.value = ""; 
        info.style.display = "none";

        for (var i = 0; i < list.options.length; i++) {
            if (list.options[i].value === inputValue) {
                hiddenInput.value = list.options[i].getAttribute('data-id');
                info.style.display = "block";
                break;
            }
        }
    });
</script>
@endif

<style>
    .hover-lift:hover { transform: translateY(-3px); transition: 0.3s; }
    .transition-all { transition: all 0.3s ease; }
    
    .form-control:focus, .form-select:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
    }

    .btn-outline-warning:checked + label { color: #fff !important; background-color: #ffc107; border-color: #ffc107; }
    .btn-outline-success:checked + label { color: #fff !important; background-color: #198754; border-color: #198754; }
    .btn-outline-danger:checked + label { color: #fff !important; background-color: #dc3545; border-color: #dc3545; }

    #cariAlat::placeholder { font-size: 13px; color: #cbd5e1; }
    .input-group-text { border-right: none !important; }
    #cariAlat { border-left: none !important; }
</style>
@endsection

@if ($errors->any())
    <div class="alert alert-danger rounded-4 small p-2">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif