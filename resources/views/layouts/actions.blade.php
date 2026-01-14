<div class="d-flex justify-content-center gap-1">
    {{-- 1. AKSES KEPALA LAB / ADMIN LAB --}}
    @if(Auth::user()->role == 'Kepala Lab')
        {{-- Tombol Hapus: Hanya jika status masih pengajuan awal --}}
        @if($item->status == 'pending_kaprodi')
            <form action="{{ route('maintenance.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pengajuan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle shadow-sm" title="Hapus Pengajuan">
                    <i class="bi bi-trash"></i>
                </button>
            </form>
        @endif

        {{-- TAHAP VERIFIKASI AKHIR: Verifikasi Fungsi Alat (Tahap 2 Closing) --}}
        @if($item->status == 'waiting_verification') 
            <form action="{{ route('maintenance.verify', $item->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm" onclick="return confirm('Konfirmasi bahwa alat sudah dicek fisik dan berfungsi normal?')">
                    <i class="bi bi-check-circle me-1"></i> Verifikasi & Terima
                </button>
            </form>
            <button class="btn btn-sm btn-outline-warning rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalComplain{{ $item->id }}">
                <i class="bi bi-exclamation-triangle me-1"></i> Komplain
            </button>
        @endif
    @endif

    {{-- 2. AKSES KAPRODI: Verifikasi Prioritas KBM --}}
    @if(Auth::user()->role == 'Kaprodi' && $item->status == 'pending_kaprodi')
        <form action="{{ route('maintenance.approve', $item->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
                <i class="bi bi-check-lg me-1"></i> Setujui
            </button>
        </form>
        <button class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalReject{{ $item->id }}">
            Tolak
        </button>
    @endif

    {{-- 3. AKSES PUDIR 1 (Persetujuan Bidang Akademik) --}}
    @if(Auth::user()->role == 'Pembantu Direktur 1' && $item->status == 'pending_pudir1')
        <form action="{{ route('maintenance.approve.pudir1', $item->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                <i class="bi bi-check-all me-1"></i> Approve Pudir 1
            </button>
        </form>
    @endif

    {{-- 4. AKSES TIM PEMELIHARA (Inspeksi & Eksekusi) --}}
    @if(Auth::user()->role == 'Tim Pemelihara')
        @if($item->status == 'checking_technical')
            <button class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTechnical{{ $item->id }}">
                <i class="bi bi-tools me-1"></i> Isi Analisis Teknis
            </button>
        @endif

        @if($item->status == 'repairing') 
            <form action="{{ route('maintenance.finish', $item->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-info text-white rounded-pill px-3 shadow-sm">
                    <i class="bi bi-send-check me-1"></i> Lapor Selesai 
                </button>
            </form>
        @endif
    @endif

    {{-- 5. AKSES PUDIR 2 (Persetujuan Anggaran) --}}
    @if(Auth::user()->role == 'Pembantu Direktur 2' && $item->status == 'pending_pudir2')
        <form action="{{ route('maintenance.approve.pudir2', $item->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
                <i class="bi bi-currency-dollar me-1"></i> Setujui Anggaran
            </button>
        </form>
    @endif

    {{-- 6. AKSES SUPER ADMIN (Closing Final) --}}
    @if(Auth::user()->role == 'Super Admin' && $item->status == 'ready_to_close') 
        <form action="{{ route('maintenance.close', $item->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-dark rounded-pill px-3 shadow-sm" onclick="return confirm('Tutup tiket secara permanen?')">
                <i class="bi bi-lock-fill me-1"></i> Close Ticket
            </button>
        </form>
    @endif

    {{-- Tombol Riwayat (Aktifkan rute yang sudah kita buat) --}}
    <a href="{{ route('kaprodi.equipment.history', $item->equipment_id) }}" 
    class="btn btn-sm btn-outline-primary rounded-circle shadow-sm" 
    title="Riwayat Servis">
        <i class="bi bi-clock-history"></i>
    </a>

    {{-- Tombol Detail --}}
    <button class="btn btn-sm btn-light border rounded-circle shadow-sm" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id }}" title="Lihat Detail">
        <i class="bi bi-eye"></i>
    </button>
</div>

{{-- MODAL DETAIL --}}
<div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
            <div class="modal-header bg-primary text-white p-4 border-0">
                <div class="d-flex align-items-center">
                    <div class="bg-white bg-opacity-25 p-3 rounded-circle me-3">
                        <i class="bi bi-file-earmark-text-fill fs-3"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0">Rincian Transaksi Perawatan</h5>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <span class="badge bg-white text-primary fw-bold">#{{ $item->id_tiket ?? 'TIC-'.$item->id }}</span>
                            <span class="opacity-75 small">Diajukan: {{ $item->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-0 bg-light">
                <div class="row g-0">
                    {{-- SISI KIRI --}}
                    <div class="col-lg-4 border-end bg-white p-4">
                        <h6 class="text-uppercase small fw-bold text-muted mb-4">Informasi Aset</h6>
                        
                        <div class="position-relative mb-4">
                            @if($item->equipment?->foto_alat)
                                <img src="{{ asset('storage/' . $item->equipment->foto_alat) }}" class="img-fluid rounded-4 border shadow-sm" style="width: 100%; height: 220px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex flex-column align-items-center justify-content-center rounded-4 border" style="height: 220px;">
                                    <i class="bi bi-image text-muted fs-1 mb-2"></i>
                                    <span class="text-muted small">Tanpa Foto Alat</span>
                                </div>
                            @endif
                            <div class="position-absolute bottom-0 end-0 m-2">
                                <span class="badge bg-dark px-3 py-2 rounded-pill">Thn: {{ $item->equipment?->tahun_perolehan ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="card border-0 bg-primary bg-opacity-10 p-3 rounded-4 mb-4">
                            <h5 class="fw-bold text-dark mb-1">{{ $item->equipment?->nama_alat ?? 'Aset Tidak Ditemukan' }}</h5>
                            <span class="text-muted font-monospace small">BMN: {{ $item->equipment?->kode_aset ?? '-' }}</span>
                        </div>

                        <div class="p-3 rounded-4 border bg-white">
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="text-muted d-block small mb-1">Merk</label>
                                    <span class="fw-bold text-dark small">{{ $item->equipment?->merk ?? '-' }}</span>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted d-block small mb-1">Klasifikasi</label>
                                    <span class="fw-bold text-dark small">{{ $item->equipment?->klasifikasi_fungsi ?? 'Pendidikan' }}</span>
                                </div>
                                <div class="col-12 border-top pt-3">
                                    <label class="text-muted d-block small mb-1">Lokasi Lab (Data Terkini)</label>
                                    <span class="fw-bold text-primary small">
                                        <i class="bi bi-geo-alt-fill me-1"></i>{{ $item->equipment?->lab?->nama_lab ?? 'Lab Belum Diatur' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SISI KANAN --}}
                    <div class="col-lg-8 p-4">
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="p-3 border rounded-4 bg-white shadow-sm h-100 border-start border-4 {{ $item->urgency == 'High' ? 'border-danger' : 'border-success' }}">
                                    <small class="text-muted d-block mb-1">Prioritas</small>
                                    <span class="fw-bold {{ $item->urgency == 'High' ? 'text-danger' : 'text-success' }}">
                                        {{ strtoupper($item->urgency) }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 border rounded-4 bg-white shadow-sm h-100 border-start border-4 border-primary">
                                    <small class="text-muted d-block mb-1">Estimasi Biaya</small>
                                    <span class="fw-bold text-primary">
                                        {{ $item->estimated_cost ? 'Rp ' . number_format($item->estimated_cost, 0, ',', '.') : 'Rp —' }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 border rounded-4 bg-white shadow-sm h-100 border-start border-4 border-dark">
                                    <small class="text-muted d-block mb-1">Status Tiket</small>
                                    <span class="fw-bold text-dark small">{{ str_replace('_', ' ', strtoupper($item->status)) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-chat-left-text me-2 text-primary"></i>Deskripsi Masalah</h6>
                            <div class="p-3 rounded-4 bg-white border">
                                <p class="mb-0 text-muted fst-italic">"{{ $item->description ?? $item->issue_description }}"</p>
                            </div>
                        </div>

                        @if($item->technical_recommendation)
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-clipboard-check me-2 text-info"></i>Analisis Teknis</h6>
                            <div class="p-3 rounded-4 bg-info bg-opacity-10 border border-info border-opacity-25">
                                <p class="mb-0 text-dark small">{{ $item->technical_recommendation }}</p>
                            </div>
                        </div>
                        @endif
                        
                        {{-- Foto Kerusakan (Jika ada) --}}
                        @if($item->foto_kerusakan)
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-camera me-2 text-primary"></i>Foto Kerusakan</h6>
                            <img src="{{ asset('storage/' . $item->foto_kerusakan) }}" class="img-fluid rounded-4 border shadow-sm" style="max-height: 200px; object-fit: cover;">
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="modal-footer bg-white border-top p-4 d-flex justify-content-between">
                <div class="text-muted small">UID: {{ $item->id }}</div>
                <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL REKOMENDASI TEKNIS (TIM PEMELIHARA) --}}
@if(Auth::user()->role == 'Tim Pemelihara')
<div class="modal fade" id="modalTechnical{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form action="{{ route('maintenance.update.technical', $item->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white border-0 px-4 pt-4">
                    <h5 class="modal-title fw-bold">Input Analisis Teknis</h5>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Metode Perbaikan</label>
                        <select name="type" class="form-select bg-light border-0 py-2" required>
                            <option value="Internal">Mandiri (Internal)</option>
                            <option value="External">Vendor (Pihak Luar)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Estimasi Biaya (Rp)</label>
                        <input type="number" name="cost" class="form-control bg-light border-0 py-2" placeholder="0" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-muted text-uppercase">Rekomendasi Detail</label>
                        <textarea name="recommendation" class="form-control bg-light border-0 py-2" rows="3" placeholder="Jelaskan kebutuhan suku cadang atau perbaikan..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-4 fw-bold">Kirim Rekomendasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

{{-- MODAL KOMPLAIN (USER LAB) --}}
<div class="modal fade" id="modalComplain{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form action="{{ route('maintenance.complain', $item->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-warning text-dark border-0 px-4 pt-4">
                    <h5 class="modal-title fw-bold">Komplain Hasil</h5>
                </div>
                <div class="modal-body p-4 pt-2">
                    <p class="small text-muted mb-3">Jelaskan mengapa alat belum bisa diterima kembali.</p>
                    <textarea name="note" class="form-control bg-light border-0" rows="3" required placeholder="Contoh: Alat masih mati total..."></textarea>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-warning w-100 py-2 rounded-3 fw-bold">Kirim Komplain</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL REJECT (KAPRODI/ADMIN) --}}
<div class="modal fade" id="modalReject{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form action="{{ route('maintenance.reject', $item->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-danger text-white border-0 px-4 pt-4">
                    <h5 class="modal-title fw-bold">Tolak Pengajuan</h5>
                </div>
                <div class="modal-body p-4 pt-2">
                    <label class="form-label small fw-bold text-muted text-uppercase">Alasan Penolakan</label>
                    <textarea name="note" class="form-control bg-light border-0" rows="3" required></textarea>
                </div>
                <div class="modal-footer border-0 p-4 pt-0 d-flex gap-2">
                    <button type="button" class="btn btn-light flex-fill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger flex-fill">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>