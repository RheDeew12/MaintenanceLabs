<div class="d-flex flex-column h-100 shadow-lg" style="background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%); min-height: 100vh;">

    <div class="nav flex-column px-3 flex-grow-1">
        <div class="mt-4 mb-2 ps-3">
            <span class="text-white-50 fw-bold text-uppercase" style="font-size: 9px; letter-spacing: 1.5px; opacity: 0.6;">Menu Utama</span>
        </div>

        {{-- Logika Penentuan Dashboard Landing Page Berdasarkan Role --}}
        @php
            $userRole = Auth::user()->role;
            
            // Secara default semua role menggunakan route global 'dashboard'
            $dashboardRoute = route('dashboard');
            
            if($userRole == 'Kaprodi') {
                $dashboardRoute = route('kaprodi.dashboard');
            } elseif($userRole == 'Pembantu Direktur 2') {
                $dashboardRoute = route('pudir2.index');
            }
            // Untuk Pudir 1, secara otomatis menggunakan route('dashboard') yang telah difilter di Controller
        @endphp

        {{-- Dashboard Link - Menggunakan route global untuk Pudir 1, Super Admin, KaLab, dan Tim Pemelihara --}}
        <a class="nav-link py-3 px-3 rounded-4 mb-2 d-flex align-items-center transition-all 
            {{ Request::routeIs('dashboard') || Request::routeIs('kaprodi.dashboard') ? 'active-gradient' : 'text-secondary hover-bg' }}" 
            href="{{ $dashboardRoute }}">
            <i class="bi bi-grid-fill me-3 fs-5"></i>
            <span class="fw-medium">Dashboard</span>
        </a>

        {{-- MENU KHUSUS: PEMBANTU DIREKTUR 1 --}}
        @if($userRole == 'Pembantu Direktur 1')
            <div class="mt-4 mb-2 ps-3 border-top border-secondary border-opacity-10 pt-4">
                <span class="text-white-50 fw-bold text-uppercase" style="font-size: 9px; letter-spacing: 1.5px; opacity: 0.6;">Kesiapan Akademik</span>
            </div>

            {{-- Link menu analitik spesifik Pudir 1 --}}
            <a href="{{ route('pudir1.readiness') }}" 
                class="nav-link py-3 px-3 rounded-4 mb-2 d-flex align-items-center transition-all {{ Request::routeIs('pudir1.readiness') ? 'active-gradient' : 'text-secondary hover-bg' }}">
                <i class="bi bi-award me-3 fs-5"></i>
                <span class="fw-medium">Lab Readiness Index</span>
            </a>

            <a href="{{ route('pudir1.high_impact') }}" 
                class="nav-link py-3 px-3 rounded-4 mb-2 d-flex align-items-center transition-all {{ Request::routeIs('pudir1.high_impact') ? 'active-gradient' : 'text-secondary hover-bg' }}">
                <i class="bi bi-exclamation-octagon me-3 fs-5"></i>
                <span class="fw-medium">Prioritas Praktikum</span>
            </a>

            <a href="{{ route('pudir1.downtime') }}" 
                class="nav-link py-3 px-3 rounded-4 mb-2 d-flex align-items-center transition-all {{ Request::routeIs('pudir1.downtime') ? 'active-gradient' : 'text-secondary hover-bg' }}">
                <i class="bi bi-hourglass-split me-3 fs-5"></i>
                <span class="fw-medium">Analisis Downtime</span>
            </a>

            <a href="{{ route('pudir1.calibration') }}" 
                class="nav-link py-3 px-3 rounded-4 mb-2 d-flex align-items-center transition-all {{ Request::routeIs('pudir1.calibration') ? 'active-gradient' : 'text-secondary hover-bg' }}">
                <i class="bi bi-patch-check me-3 fs-5"></i>
                <span class="fw-medium">Monitoring Kalibrasi</span>
            </a>
        @endif

        {{-- MENU KHUSUS: PEMBANTU DIREKTUR 2 --}}
        @if($userRole == 'Pembantu Direktur 2')
            <div class="mt-4 mb-2 ps-3 border-top border-secondary border-opacity-10 pt-4">
                <span class="text-white-50 fw-bold text-uppercase" style="font-size: 9px; letter-spacing: 1.5px; opacity: 0.6;">Manajemen Keuangan</span>
            </div>

            <a href="{{ route('pudir2.approval') }}" 
                class="nav-link py-3 px-3 rounded-4 mb-2 d-flex align-items-center transition-all {{ Request::routeIs('pudir2.approval') ? 'active-gradient' : 'text-secondary hover-bg' }}">
                <i class="bi bi-check2-square me-3 fs-5"></i>
                <span class="fw-medium">Antrean Persetujuan</span>
            </a>

            <a href="{{ route('pudir2.budget') }}" 
                class="nav-link py-3 px-3 rounded-4 mb-2 d-flex align-items-center transition-all {{ Request::routeIs('pudir2.budget') ? 'active-gradient' : 'text-secondary hover-bg' }}">
                <i class="bi bi-wallet2 me-3 fs-5"></i>
                <span class="fw-medium">Realisasi Anggaran</span>
            </a>

            <a href="{{ route('pudir2.assets') }}" 
                class="nav-link py-3 px-3 rounded-4 mb-2 d-flex align-items-center transition-all {{ Request::routeIs('pudir2.assets') ? 'active-gradient' : 'text-secondary hover-bg' }}">
                <i class="bi bi-shield-exclamation me-3 fs-5"></i>
                <span class="fw-medium">Kesehatan Aset</span>
            </a>

            <a href="{{ route('pudir2.vendor') }}" 
                class="nav-link py-3 px-3 rounded-4 mb-2 d-flex align-items-center transition-all {{ Request::routeIs('pudir2.vendor') ? 'active-gradient' : 'text-secondary hover-bg' }}">
                <i class="bi bi-truck me-3 fs-5"></i>
                <span class="fw-medium">Performa Vendor</span>
            </a>
        @endif

        {{-- MENU KHUSUS: KAPRODI --}}
        @if($userRole == 'Kaprodi')
            <div class="mt-4 mb-2 ps-3 border-top border-secondary border-opacity-10 pt-4">
                <span class="text-white-50 fw-bold text-uppercase" style="font-size: 9px; letter-spacing: 1.5px; opacity: 0.6;">Monitoring Prodi</span>
            </div>

            <a href="{{ route('kaprodi.inventory') }}" 
                class="nav-link py-3 px-3 rounded-4 mb-2 d-flex align-items-center transition-all {{ Request::routeIs('kaprodi.inventory') ? 'active-gradient' : 'text-secondary hover-bg' }}">
                <i class="bi bi-box-seam me-3 fs-5"></i>
                <span class="fw-medium">Inventaris Alat</span>
            </a>

            <a href="{{ route('kaprodi.cost_report') }}" 
                class="nav-link py-3 px-3 rounded-4 mb-2 d-flex align-items-center transition-all {{ Request::routeIs('kaprodi.cost_report') ? 'active-gradient' : 'text-secondary hover-bg' }}">
                <i class="bi bi-file-earmark-bar-graph me-3 fs-5"></i>
                <span class="fw-medium">Laporan Biaya</span>
            </a>

            <a href="{{ route('kaprodi.calibration') }}" 
                class="nav-link py-3 px-3 rounded-4 mb-2 d-flex align-items-center transition-all {{ Request::routeIs('kaprodi.calibration') ? 'active-gradient' : 'text-secondary hover-bg' }}">
                <i class="bi bi-tools me-3 fs-5"></i>
                <span class="fw-medium">Jadwal Kalibrasi</span>
            </a>
        @endif

        {{-- Administrasi Section (Hanya Super Admin & Kepala Lab) --}}
        @if(in_array($userRole, ['Super Admin', 'Kepala Lab']))
            <div class="mt-4 mb-2 ps-3 border-top border-secondary border-opacity-10 pt-4">
                <span class="text-white-50 fw-bold text-uppercase" style="font-size: 9px; letter-spacing: 1.5px; opacity: 0.6;">Administrasi</span>
            </div>

            @if($userRole == 'Super Admin')
                <a href="{{ route('users.index') }}" 
                    class="nav-link py-3 px-3 rounded-4 mb-2 d-flex align-items-center transition-all {{ Request::routeIs('users.*') ? 'active-gradient' : 'text-secondary hover-bg' }}">
                    <i class="bi bi-people me-3 fs-5"></i>
                    <span class="fw-medium">User Management</span>
                </a>
            @endif
        @endif
    </div>

    {{-- Footer Status --}}
    <div class="p-4 mt-auto border-top border-secondary border-opacity-10 bg-black bg-opacity-10">
        <div class="d-flex align-items-center justify-content-center text-white-50 small font-monospace" style="font-size: 10px;">
            <div class="pulse-green me-2"></div>
            <span style="letter-spacing: 1px;">SYSTEM ONLINE</span>
        </div>
    </div>
</div>

<style>
    .transition-all { transition: all 0.3s ease; }
    
    .hover-bg:hover {
        background: rgba(255, 255, 255, 0.05);
        color: white !important;
        transform: translateX(5px);
    }

    .active-gradient {
        background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
        color: white !important;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
    }

    .pulse-green {
        width: 8px;
        height: 8px;
        background-color: #10b981;
        border-radius: 50%;
        box-shadow: 0 0 0 rgba(16, 185, 129, 0.4);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
</style>