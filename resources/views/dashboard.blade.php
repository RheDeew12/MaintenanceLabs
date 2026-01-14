@extends('layouts.admin')

@section('title', 'Dashboard Perawatan')

@section('content')
<div class="container-fluid px-4 py-4">
    {{-- BAGIAN PESAN NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4 border-0" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                <div><strong>Berhasil!</strong> {{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm mb-4 border-0" role="alert">
            <div class="d-flex">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                <div>
                    <strong>Mohon Maaf!</strong> Ada beberapa kesalahan:
                    <ul class="mb-0 mt-1 small">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Header Section --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
        <div>
            <h3 class="fw-extrabold text-dark mb-1">Manajemen Perawatan</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted small">Dashboard</a></li>
                    <li class="breadcrumb-item active small" aria-current="page">Transaksi Perawatan</li>
                </ol>
            </nav>
        </div>
        @if(Auth::user()->role == 'Kepala Lab')
            <button class="btn btn-primary rounded-4 px-4 py-2 shadow-sm d-flex align-items-center transition-all hover-lift" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-lg me-2"></i>
                <span class="fw-semibold">Buat Pengajuan</span>
            </button>
        @endif
    </div>

    {{-- Widget Ringkasan (KPI) --}}
    @if(in_array(Auth::user()->role, ['Kaprodi', 'Super Admin']))
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 rounded-4 bg-primary text-white">
                <small class="opacity-75 text-uppercase fw-bold" style="font-size: 10px;">Total Pengajuan</small>
                <h3 class="mb-0 fw-bold">{{ $maintenances->total() }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 rounded-4 bg-warning text-white">
                <small class="opacity-75 text-uppercase fw-bold" style="font-size: 10px;">Menunggu Verifikasi</small>
                <h3 class="mb-0 fw-bold">{{ $maintenances->whereIn('status', ['pending_kaprodi', 'pending_pudir1', 'pending_pudir2'])->count() }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 rounded-4 bg-info text-white">
                <small class="opacity-75 text-uppercase fw-bold" style="font-size: 10px;">Sedang Dikerjakan</small>
                <h3 class="mb-0 fw-bold">{{ $maintenances->where('status', 'repairing')->count() }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 rounded-4 bg-success text-white">
                <small class="opacity-75 text-uppercase fw-bold" style="font-size: 10px;">Selesai (Closed)</small>
                <h3 class="mb-0 fw-bold">{{ $maintenances->where('status', 'closed')->count() }}</h3>
            </div>
        </div>
    </div>
    @endif

    {{-- Table Card --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-4 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">Riwayat Perawatan</h5>
                <form action="{{ route('dashboard') }}" method="GET" class="d-flex align-items-center">
                    <div class="input-group shadow-sm" style="width: 320px;">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari nama alat atau ID..." value="{{ request('search') }}">
                    </div>
                </form>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light-subtle border-bottom">
                    <tr class="text-uppercase small fw-bold text-muted">
                        <th class="ps-4">ID Tiket</th>
                        <th>Alat & Lokasi</th>
                        <th>Kategori</th>
                        <th>Tgl Ajuan</th>
                        <th>Metode</th>
                        <th>Estimasi</th>
                        <th>Status</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($maintenances as $item)
                    <tr class="transition-all hover-bg-light">
                        <td class="ps-4">
                            <div class="d-flex flex-column">
                                <span class="text-primary fw-bold mb-0">#{{ $item->id_tiket ?? 'TIC-'.$item->id }}</span>
                                <span class="text-muted font-monospace" style="font-size: 10px;">REF: {{ $item->equipment->kode_aset ?? 'N/A' }}</span>
                            </div>
                        </td>

                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-3 bg-primary-subtle text-primary rounded-4 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="bi bi-tools fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark lh-sm">{{ $item->equipment->nama_alat ?? 'Alat Tidak Diketahui' }}</div>
                                    <div class="d-flex align-items-center mt-1 text-nowrap">
                                        <span class="badge bg-secondary-subtle text-secondary px-2 py-1 rounded-2 fw-medium border border-secondary-subtle me-2" style="font-size: 10px;">
                                            {{ $item->equipment->klasifikasi_fungsi ?? 'Pendidikan' }}
                                        </span>
                                        <span class="text-primary small fw-semibold" style="font-size: 11px;">
                                            <i class="bi bi-geo-alt-fill me-1"></i>{{ $item->equipment->lab->nama_lab ?? 'Lokasi Belum Diatur' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="text-dark small fw-medium">
                                <i class="bi bi-tag-fill text-muted me-1"></i>
                                {{ $item->equipment->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                        </td>

                        <td><span class="fw-semibold text-dark small">{{ $item->created_at->format('d/m/Y') }}</span></td>

                        <td>
                            @php $isInternal = $item->repair_type == 'Internal'; @endphp
                            <div class="d-inline-flex align-items-center px-3 py-1 rounded-pill border {{ $isInternal ? 'bg-info-subtle border-info-subtle text-info' : 'bg-dark-subtle border-dark-subtle text-dark' }}" style="font-size: 11px; font-weight: 600;">
                                <i class="bi {{ $isInternal ? 'bi-person-workspace' : 'bi-truck' }} me-2"></i>
                                {{ $isInternal ? 'MANDIRI' : 'VENDOR' }}
                            </div>
                        </td>

                        <td><span class="text-dark fw-bold">{{ $item->estimated_cost ? 'Rp ' . number_format($item->estimated_cost, 0, ',', '.') : '—' }}</span></td>

                        <td>
                            @php
                                $statusConfig = [
                                    'pending_kaprodi' => ['class' => 'bg-primary-subtle text-primary', 'icon' => 'bi-hourglass-split'],
                                    'pending_pudir1'  => ['class' => 'bg-info-subtle text-info', 'icon' => 'bi-clock-history'],
                                    'pending_pudir2'  => ['class' => 'bg-warning-subtle text-warning', 'icon' => 'bi-shield-lock'],
                                    'repairing'       => ['class' => 'bg-warning text-white shadow-sm', 'icon' => 'bi-gear-wide-connected'],
                                    'waiting_verification' => ['class' => 'bg-info text-white', 'icon' => 'bi-eye'],
                                    'closed'          => ['class' => 'bg-success text-white', 'icon' => 'bi-check-circle-fill'],
                                    'rejected'        => ['class' => 'bg-danger text-white', 'icon' => 'bi-x-octagon-fill']
                                ];
                                $current = $statusConfig[$item->status] ?? ['class' => 'bg-secondary-subtle text-muted', 'icon' => 'bi-dot'];
                            @endphp
                            <div class="badge {{ $current['class'] }} px-3 py-2 rounded-pill d-flex align-items-center border-0">
                                <i class="{{ $current['icon'] }} me-2"></i>
                                <span style="letter-spacing: 0.5px;">{{ str_replace('_', ' ', strtoupper($item->status)) }}</span>
                            </div>
                        </td>

                        <td class="text-center pe-4">@include('layouts.actions')</td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center py-5 text-muted">Tidak ada riwayat perawatan yang ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-0 py-3 px-4">
            {{ $maintenances->appends(['search' => request('search')])->links() }}
        </div>
    </div>
</div>

{{-- MODAL TAMBAH PENGAJUAN --}}
@if(Auth::user()->role == 'Kepala Lab')
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form action="{{ route('maintenance.store') }}" method="POST" enctype="multipart/form-data">
                @csrf 
                <div class="modal-header border-0 pt-4 px-4 bg-primary text-white">
                    <h5 class="modal-title fw-bold">Form Pengajuan Perbaikan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    {{-- Pilih Alat --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Pilih Alat Laboratorium</label>
                        <select name="equipment_id" id="selectAlat" class="form-select border-0 bg-light py-2 rounded-3 shadow-sm" required onchange="toggleManualInput()">
                            <option value="" disabled selected>-- Pilih Alat Dari Master --</option>
                            @foreach($equipments as $eq)
                                <option value="{{ $eq->id }}" data-lab="{{ $eq->id_lab }}">[{{ $eq->kode_aset }}] {{ $eq->nama_alat }}</option>
                            @endforeach
                            <option value="manual" class="text-primary fw-bold">+ Alat Baru (Belum Terdaftar)</option>
                        </select>
                    </div>

                    {{-- Lokasi Lab --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Lokasi Lab Saat Ini</label>
                        <div class="input-group shadow-sm rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-geo-alt text-primary"></i></span>
                            <select name="id_lab" id="id_lab_input" class="form-select border-0 bg-light border-start-0 py-2" required>
                                <option value="" disabled selected>-- Pilih Lokasi Keberadaan Alat --</option>
                                @foreach($labs as $lab)
                                    <option value="{{ $lab->id }}">{{ $lab->nama_lab }}</option>
                                @endforeach
                            </select>
                        </div>
                        <small class="text-muted" style="font-size: 10px;">Informasikan lokasi fisik alat saat ini untuk memudahkan tim teknis.</small>
                    </div>

                    {{-- Area Input Manual (Alat Baru) --}}
                    <div id="inputManualArea" style="display: none;" class="p-3 border rounded-4 bg-light-subtle mb-4 slide-in shadow-sm">
                        <h6 class="small fw-bold text-primary mb-3 text-uppercase"><i class="bi bi-plus-square me-2"></i>Detail Alat Baru</h6>
                        <div class="mb-3">
                            <input type="text" name="manual_name" id="manual_name" class="form-control border-0 shadow-sm" placeholder="Nama Alat">
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <input type="text" name="manual_merk" id="manual_merk" class="form-control border-0 shadow-sm" placeholder="Merk/Tipe">
                            </div>
                            <div class="col-6">
                                <input type="text" name="manual_code" id="manual_code" class="form-control border-0 shadow-sm" placeholder="Kode Aset (BMN)">
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <input type="number" name="tahun_perolehan" id="tahun_perolehan" class="form-control border-0 shadow-sm" placeholder="Thn Perolehan" min="1900" max="{{ date('Y') }}">
                            </div>
                            <div class="col-6">
                                <select name="id_kategori" id="id_kategori" class="form-select border-0 shadow-sm small">
                                    <option value="">-- Kategori --</option>
                                    <option value="1">Mesin Berat</option>
                                    <option value="2">Alat Gelas</option>
                                    <option value="3">Elektronik</option>
                                </select>
                            </div>
                        </div>
                        
                        {{-- PENAMBAHAN KLASIFIKASI FUNGSI --}}
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Klasifikasi Fungsi</label>
                            <select name="klasifikasi_fungsi" id="klasifikasi_fungsi" class="form-select border-0 shadow-sm small">
                                <option value="Pendidikan">Pendidikan</option>
                                <option value="Non-Pendidikan">Non-Pendidikan</option>
                            </select>
                        </div>

                        <div class="mb-0">
                            <label class="form-label small fw-bold text-muted text-uppercase">Foto Identifikasi Alat</label>
                            <input type="file" name="foto_alat" id="foto_alat" class="form-control border-0 shadow-sm" accept="image/*">
                        </div>
                    </div>

                    {{-- Tingkat Kerusakan --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Tingkat Kerusakan</label>
                        <div class="d-flex gap-2">
                            <input type="radio" class="btn-check" name="damage_level" id="dmg-low" value="Ringan">
                            <label class="btn btn-outline-success border-0 bg-light flex-grow-1 small py-2 rounded-3" for="dmg-low">Ringan</label>
                            <input type="radio" class="btn-check" name="damage_level" id="dmg-med" value="Sedang" checked>
                            <label class="btn btn-outline-warning border-0 bg-light flex-grow-1 small py-2 rounded-3" for="dmg-med">Sedang</label>
                            <input type="radio" class="btn-check" name="damage_level" id="dmg-high" value="Berat">
                            <label class="btn btn-outline-danger border-0 bg-light flex-grow-1 small py-2 rounded-3" for="dmg-high">Berat</label>
                        </div>
                    </div>

                    {{-- Deskripsi Masalah --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Deskripsi Gejala / Masalah</label>
                        <textarea name="issue_description" class="form-control border-0 bg-light py-3 rounded-3 shadow-sm" rows="3" placeholder="Jelaskan detail kerusakan..." required></textarea>
                    </div>

                    {{-- Foto Kerusakan --}}
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-muted text-uppercase">Foto Kerusakan (Opsional)</label>
                        <input type="file" name="foto_kerusakan" class="form-control border-0 shadow-sm" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-4 shadow-sm fw-bold">Kirim Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<style>
    body { background-color: #f8f9fa; font-family: 'Inter', sans-serif; }
    .card { border-radius: 1rem; }
    .btn-primary { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border: none; }
    .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; transition: all 0.3s; }
    .hover-bg-light:hover { background-color: rgba(78, 115, 223, 0.03) !important; }
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    tr:hover .bi-gear-wide-connected { animation: spin 2s linear infinite; }
    @keyframes slideIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    .slide-in { animation: slideIn 0.3s ease-out; }
</style>

<script>
    function toggleManualInput() {
        const selectAlat = document.getElementById('selectAlat');
        const manualArea = document.getElementById('inputManualArea');
        const labInput = document.getElementById('id_lab_input');
        const isManual = selectAlat.value === 'manual';
        
        manualArea.style.display = isManual ? 'block' : 'none';
        
        if(!isManual && selectAlat.value !== "") {
            const selectedOption = selectAlat.options[selectAlat.selectedIndex];
            const labId = selectedOption.getAttribute('data-lab');
            if(labId) labInput.value = labId;
        }

        // UPDATE LIST FIELD MANUAL UNTUK REQUIREMENT
        const manualFields = ['manual_name', 'manual_merk', 'manual_code', 'id_kategori', 'tahun_perolehan', 'klasifikasi_fungsi'];
        manualFields.forEach(id => {
            const el = document.getElementById(id);
            if(el) {
                if(isManual) el.setAttribute('required', 'required');
                else { el.removeAttribute('required'); el.value = ''; }
            }
        });
    }
</script>
@endsection