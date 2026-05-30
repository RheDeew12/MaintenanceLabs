<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Maintenance Lab ATK</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    
    <style>
        :root {
            --atk-navy: #0f172a;
            --atk-blue: #3b82f6;
            --sidebar-width: 280px;
            --bg-body: #f8fafc;
        }

        body { 
            background-color: var(--bg-body); 
            font-family: 'Inter', sans-serif;
            color: #334155;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6, .fw-bold { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            letter-spacing: -0.02em;
        }

        /* --- SIDEBAR RESPONSIVE FIX --- */
        /* Pastikan sidebar pembungkus di admin tidak menimpa isi sidebar layouts */
        .sidebar-container { 
            z-index: 1050;
        }

        /* Desktop Mode */
        @media (min-width: 992px) {
            .main-content { margin-left: var(--sidebar-width); }
        }

        /* --- TOPBAR GLASSMORPHISM --- */
        .topbar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px) saturate(180%);
            -webkit-backdrop-filter: blur(12px) saturate(180%);
            padding: 0.85rem 2.5rem;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            position: sticky; top: 0; z-index: 1020;
        }

        .page-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--atk-blue), #2563eb);
            color: white; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }

        /* --- USER PROFILE CARD --- */
        .user-profile-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            padding: 6px 14px 6px 6px;
            border-radius: 16px;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex; align-items: center; gap: 12px;
        }
        .user-profile-card:hover { border-color: var(--atk-blue); transform: translateY(-1px); }

        .avatar-box {
            width: 40px; height: 40px;
            background: #f1f5f9; color: var(--atk-blue);
            border-radius: 12px; display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; font-weight: 700; border: 1px solid #e2e8f0;
            position: relative;
        }

        .online-status {
            position: absolute; bottom: -2px; right: -2px;
            width: 12px; height: 12px;
            background: #10b981; border: 2.5px solid #fff; border-radius: 50%;
        }

        /* --- CONTENT AREA --- */
        .content-wrapper { padding: 2.5rem; flex: 1; }
        .footer { background: #fff; border-top: 1px solid #e2e8f0; padding: 1.5rem 2.5rem; }

        @media (max-width: 768px) {
            .topbar { padding: 0.85rem 1.25rem; }
            .content-wrapper { padding: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        
        {{-- 1. BAGIAN SIDEBAR --}}
        {{-- Kita hilangkan tag <aside> tambahan agar tidak bentrok dengan pembungkus di layouts.sidebar --}}
        <div class="sidebar-container">
            @include('layouts.sidebar')
        </div>

        <main class="main-content flex-grow-1">
            <header class="topbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2 gap-md-3">
                    
                    {{-- Tombol Hamburger untuk Mobile --}}
                    <button class="btn btn-light d-lg-none shadow-sm border" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
                        <i class="bi bi-list fs-4"></i>
                    </button>

                    <div class="page-icon d-none d-md-flex">
                        <i class="bi bi-layers-half fs-5"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">@yield('title', 'Dashboard')</h5>
                        <nav aria-label="breadcrumb" class="d-none d-sm-block">
                            <ol class="breadcrumb mb-0" style="--bs-breadcrumb-divider: '›'; font-size: 12px;">
                                <li class="breadcrumb-item text-muted">Aplikasi</li>
                                <li class="breadcrumb-item active fw-semibold text-primary" aria-current="page">Unit Maintenance</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="dropdown">
                    <div class="user-profile-card shadow-none" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                        <div class="avatar-box">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                            <div class="online-status"></div>
                        </div>
                        <div class="text-start d-none d-sm-block ms-1">
                            <div class="fw-bold small lh-1 mb-1 text-dark">{{ Auth::user()->name }}</div>
                            <div class="text-muted fw-medium" style="font-size: 10px; text-transform: uppercase;">
                                <i class="bi bi-patch-check-fill text-primary me-1"></i>{{ Auth::user()->role }}
                            </div>
                        </div>
                        <i class="bi bi-chevron-down small text-muted ms-2 d-none d-lg-block"></i>
                    </div>
                    
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-2 mt-3">
                        <li><a class="dropdown-item d-flex align-items-center" href="#"><i class="bi bi-person me-3 text-muted fs-5"></i> Profil Saya</a></li>
                        <li><a class="dropdown-item d-flex align-items-center" href="#"><i class="bi bi-gear me-3 text-muted fs-5"></i> Pengaturan Sesi</a></li>
                        <li><hr class="dropdown-divider opacity-50"></li>
                        <li>
                            <a href="{{ route('logout') }}" class="dropdown-item logout-btn d-flex align-items-center">
                                <i class="bi bi-box-arrow-right me-3 fs-5"></i> Keluar Sesi
                            </a>
                        </li>
                    </ul>
                </div>
            </header>

            <div class="content-wrapper">
                @yield('content')
            </div>

            <footer class="footer mt-auto">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                    <div class="small text-muted text-center text-md-start">
                        <strong>&copy; {{ date('Y') }} Politeknik ATK Yogyakarta.</strong>
                        <span class="d-none d-md-inline ms-2">Unit Pemeliharaan Laboratorium.</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge bg-light text-muted border px-3 py-2 rounded-pill fw-medium" style="font-size: 11px;">
                            Laravel v{{ Illuminate\Foundation\Application::VERSION }}
                        </span>
                    </div>
                </div>
            </footer>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>