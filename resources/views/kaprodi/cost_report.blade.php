@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4 no-print-bg">
    {{-- Header Section - Hidden when printing --}}
    <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
        <div>
            <h3 class="fw-bold text-dark mb-1">Laporan Realisasi & Biaya</h3>
            <p class="text-muted small mb-0">Rekapitulasi penggunaan anggaran pemeliharaan unit kerja prodi.</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm" onclick="window.print()">
            <i class="bi bi-printer me-2"></i> Cetak Laporan
        </div>
    </div>

    {{-- Laporan Header - Only visible when printing --}}
    <div class="d-none d-print-block mb-5">
        <div class="text-center">
            <h4 class="fw-bold mb-0">LAPORAN REALISASI BIAYA PEMELIHARAAN ALAT</h4>
            <h5 class="text-uppercase mb-1">PRODI {{ Auth::user()->prodi->nama_prodi ?? '' }}</h5>
            <p class="small text-muted">Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }} WIB</p>
        </div>
        <hr>
    </div>

    <div class="row mb-4">
        {{-- Grafik Tren --}}
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="m-0 fw-bold text-primary">Tren Pengeluaran 6 Bulan Terakhir</h6>
                </div>
                <div class="card-body">
                    <canvas id="costChart" style="max-height: 320px;"></canvas>
                </div>
            </div>
        </div>

        {{-- Ringkasan Biaya --}}
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow-sm border-0 rounded-4 mb-4 bg-primary text-white overflow-hidden position-relative">
                <div class="card-body p-4 position-relative" style="z-index: 2;">
                    <h6 class="text-white-50 small fw-bold text-uppercase">Total Realisasi Prodi</h6>
                    <h2 class="display-6 fw-bold mb-2">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</h2>
                    <p class="small text-white-50 mb-0">*Akumulasi tiket berstatus Repairing hingga Closed.</p>
                </div>
                {{-- Dekorasi Latar Belakang --}}
                <i class="bi bi-wallet2 position-absolute end-0 bottom-0 m-3 display-1 opacity-25" style="z-index: 1;"></i>
            </div>

            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="m-0 fw-bold text-dark">Breakdown Per Unit</h6>
                </div>
                <div class="card-body pt-0">
                    @forelse($biayaPerLab as $lab)
                    <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded-3 bg-light border-start border-primary border-3">
                        <span class="small fw-bold text-dark">{{ $lab->lab_name }}</span>
                        <span class="text-primary fw-bold">Rp {{ number_format($lab->total, 0, ',', '.') }}</span>
                    </div>
                    @empty
                    <p class="text-center text-muted small py-3">Belum ada realisasi biaya.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CSS KHUSUS CETAK --}}
<style>
    @media print {
        /* Sembunyikan semua elemen sidebar, navbar, dan tombol */
        .sidebar, .navbar, .d-print-none, .btn, footer {
            display: none !important;
        }
        /* Reset margin dan background untuk hasil cetak bersih */
        .content-wrapper, body {
            margin: 0 !important;
            padding: 0 !important;
            background: #fff !important;
        }
        .card {
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }
        .container-fluid {
            width: 100% !important;
        }
        /* Pastikan chart terlihat di cetakan */
        #costChart {
            max-width: 100% !important;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('costChart').getContext('2d');
    
    // Gradient Background untuk Grafik
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
    gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            // Label Bulan Dinamis dari Controller
            labels: {!! json_encode($monthLabels) !!},
            datasets: [{
                label: 'Realisasi Biaya (IDR)',
                data: {!! json_encode($monthlyTotals) !!},
                borderColor: '#3b82f6',
                borderWidth: 3,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#3b82f6',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                tension: 0.4,
                fill: true,
                backgroundColor: gradient
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return ' Total: Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endsection