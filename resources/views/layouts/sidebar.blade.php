<div class="offcanvas-lg offcanvas-start d-flex flex-column h-100 shadow-lg border-0" 
     id="sidebarMenu"
     style="background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%); width: 280px; z-index: 1050; border: none;">

    {{-- Header Khusus Mobile --}}
    <div class="offcanvas-header d-lg-none justify-content-between align-items-center border-bottom border-white border-opacity-10 mb-2 px-4 py-3">
        <div class="d-flex align-items-center">
            <div class="bg-primary p-2 rounded-3 me-2 shadow-sm" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-shield-check text-white fs-5"></i>
            </div>
            <span class="text-white fw-bold tracking-tight" style="font-size: 14px;">ATK LABS</span>
        </div>
        <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu"></button>
    </div>

    {{-- Header Sidebar Desktop --}}
    <div class="sidebar-brand p-4 text-center border-bottom border-white border-opacity-10 d-none d-lg-block">
        <div class="d-flex align-items-center justify-content-center">
            <div class="bg-primary p-2 rounded-3 me-2 shadow-sm">
                <i class="bi bi-shield-check text-white fs-4"></i>
            </div>
            <div class="text-start">
                <span class="text-white fw-bold fs-5 d-block lh-1 tracking-tight">ATK LABS</span>
                <small style="font-size: 9px; color: #88a9c9;">MAINTENANCE SYSTEM</small>
            </div>
        </div>
    </div>

    {{-- Menu Container Utama --}}
    <div class="flex-grow-1 w-100 custom-scrollbar" style="overflow-y: auto; overflow-x: hidden; min-height: 0;">
        
        <div class="nav flex-column px-3 mt-4 w-100" style="display: block !important;">
            
            <div class="mb-3 ps-3">
                <span class="text-white-50 fw-bold text-uppercase" style="font-size: 9px; letter-spacing: 1.5px; opacity: 0.6;">Menu Utama</span>
            </div>

            @php
                $userRole = Auth::user()->role;
                
                // Logika Penentuan Dashboard Landing Page
                $dashboardRoute = route('dashboard');
                if($userRole == 'Kaprodi') {
                    $dashboardRoute = route('kaprodi.dashboard');
                } elseif($userRole == 'Pembantu Direktur 2') {
                    $dashboardRoute = route('pudir2.index');
                }
            @endphp

            {{-- Dashboard Link --}}
            <a class="nav-link py-3 px-3 rounded-4 mb-2 d-flex align-items-center transition-all 
                {{ Request::routeIs('dashboard') || Request::routeIs('kaprodi.dashboard') || Request::routeIs('pudir2.index') ? 'active-gradient' : 'text-secondary hover-bg' }}" 
                href="{{ $dashboardRoute }}">
                <i class="bi bi-grid-fill me-3 fs-5"></i>
                <span class="fw-medium">Dashboard</span>
            </a>

            {{-- MENU KHUSUS: PEMBANTU DIREKTUR 1 --}}
            @if($userRole == 'Pembantu Direktur 1')
                <div class="mt-4 mb-2 ps-3 border-top border-secondary border-opacity-10 pt-4">
                    <span class="text-white-50 fw-bold text-uppercase" style="font-size: 9px; letter-spacing: 1.5px; opacity: 0.6;">Kesiapan Akademik</span>
                </div>

                <a href="{{ route('pudir1.total_assets') }}" 
                    class="nav-link py-3 px-3 rounded-4 mb-2 d-flex align-items-center transition-all {{ Request::routeIs('pudir1.total_assets') ? 'active-gradient' : 'text-secondary hover-bg' }}">
                    <i class="bi bi-archive me-3 fs-5"></i>
                    <span class="fw-medium">Laporan Seluruh Aset</span>
                </a>

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

                <a href="{{ route('pudir2.total_assets') }}" 
                    class="nav-link py-3 px-3 rounded-4 mb-2 d-flex align-items-center transition-all {{ Request::routeIs('pudir2.total_assets') ? 'active-gradient' : 'text-secondary hover-bg' }}">
                    <i class="bi bi-archive me-3 fs-5"></i>
                    <span class="fw-medium">Laporan Seluruh Aset</span>
                </a>

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

            {{-- ADMINISTRASI SECTION --}}
            @if(in_array($userRole, ['Super Admin', 'Kepala Lab']))
                <div class="mt-4 mb-2 ps-3 border-top border-secondary border-opacity-10 pt-4">
                    <span class="text-white-50 fw-bold text-uppercase" style="font-size: 9px; letter-spacing: 1.5px; opacity: 0.6;">Administrasi</span>
                </div>

                <a href="{{ route('barangs.index') }}" 
                    class="nav-link py-3 px-3 rounded-4 mb-2 d-flex align-items-center transition-all {{ Request::routeIs('barangs.*') ? 'active-gradient' : 'text-secondary hover-bg' }}">
                    <i class="bi bi-box me-3 fs-5"></i>
                    <span class="fw-medium">Master Barang</span>
                </a>

                @if($userRole == 'Super Admin')
                    <a href="{{ route('units.index') }}" 
                        class="nav-link py-3 px-3 rounded-4 mb-2 d-flex align-items-center transition-all {{ Request::routeIs('units.*') ? 'active-gradient' : 'text-secondary hover-bg' }}">
                        <i class="bi bi-houses me-3 fs-5"></i>
                        <span class="fw-medium">Unit Management</span>
                    </a>

                    <a href="{{ route('users.index') }}" 
                        class="nav-link py-3 px-3 rounded-4 mb-2 d-flex align-items-center transition-all {{ Request::routeIs('users.*') ? 'active-gradient' : 'text-secondary hover-bg' }}">
                        <i class="bi bi-people me-3 fs-5"></i>
                        <span class="fw-medium">User Management</span>
                    </a>
                @endif
            @endif

            <div class="py-4"></div>
        </div>
    </div>

    {{-- Footer Status --}}
    <div class="p-4 mt-auto border-top border-secondary border-opacity-10 bg-black bg-opacity-20">
        <div class="d-flex align-items-center justify-content-center text-white-50 small font-monospace" style="font-size: 10px;">
            <div class="pulse-green me-2"></div>
            <span style="letter-spacing: 1px;">SYSTEM ONLINE</span>
        </div>
    </div>
</div>

<style>
    /* Desktop Sidebar Logic */
    @media (min-width: 992px) {
        #sidebarMenu {
            position: fixed !important;
            transform: none !important;
            visibility: visible !important;
            height: 100vh !important;
            left: 0 !important;
        }
    }

    /* Memastikan teks menu berwarna putih/abu terang */
    .nav-link {
        color: #94a3b8 !important; 
        text-decoration: none !important;
    }
    
    .nav-link:hover, .nav-link.active-gradient {
        color: #ffffff !important; 
    }

    .active-gradient {
        background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
    }

    .hover-bg:hover {
        background: rgba(255, 255, 255, 0.05);
        transform: translateX(5px);
    }

    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
    
    .pulse-green { width: 8px; height: 8px; background-color: #10b981; border-radius: 50%; animation: pulse 2s infinite; }
    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
</style>