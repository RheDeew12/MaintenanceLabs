<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Mainten-Lab</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #00bcd4; 
            --dark-panel: #111827;      
            --input-bg: #1f2937;     
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Background Gambar Utama */
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), 
                        url('https://images.unsplash.com/photo-1581092160562-40aa08e78837?q=80&w=1920');
            background-size: cover;
            background-position: center;
        }

        /* Container Utama yang membungkus 2 Window */
        .glass-wrapper {
            display: flex;
            width: 90%;
            max-width: 1000px;
            height: 600px;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.8s ease-out;
        }

        /* Window Kiri: Informasi (Semi-Transparent) */
        .window-info {
            flex: 1.2;
            background: rgba(0, 188, 212, 0.85); /* Warna biru toska dengan transparansi */
            backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 50px;
            color: white;
            text-align: center;
            border-right: 1px solid rgba(255,255,255,0.1);
        }

        .logo-box {
            background: white;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            margin-bottom: 25px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .logo-box i {
            font-size: 2.5rem;
            color: var(--dark-panel);
        }

        .window-info h2 {
            font-weight: 800;
            font-size: 2.2rem;
            margin-bottom: 15px;
        }

        .window-info p {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .btn-register {
            background: transparent;
            border: 2px solid white;
            color: white;
            padding: 12px 35px;
            border-radius: 12px;
            font-weight: 700;
            text-transform: uppercase;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-register:hover {
            background: white;
            color: var(--primary-color);
        }

        /* Window Kanan: Form Login (Solid Dark) */
        .window-login {
            flex: 1;
            background: var(--dark-panel);
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .window-login h1 {
            color: white;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .window-login .subtitle {
            color: #9ca3af;
            margin-bottom: 35px;
        }

        .form-label {
            color: #d1d5db;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .form-control {
            background: var(--input-bg);
            border: 1px solid #374151;
            color: white;
            padding: 12px 15px;
            border-radius: 12px;
            margin-bottom: 5px;
        }

        .form-control:focus {
            background: var(--input-bg);
            border-color: var(--primary-color);
            color: white;
            box-shadow: 0 0 0 4px rgba(0, 188, 212, 0.1);
        }

        .btn-login {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            width: 100%;
            margin-top: 20px;
            transition: 0.3s;
        }

        .btn-login:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .forgot-link {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.8rem;
            transition: 0.2s;
        }

        /* Animasi */
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        /* Responsive */
        @media (max-width: 850px) {
            .window-info { display: none; }
            .glass-wrapper { max-width: 450px; height: auto; }
        }
    </style>
</head>
<body>

    <div class="glass-wrapper">
        <div class="window-info">
            <div class="logo-box">
                <i class="bi bi-shield-check"></i>
            </div>
            <h2>Mainten-Lab</h2>
            <h3>Politeknik ATK Yogyakarta</h3>
            <p>Sistem Informasi Pemeliharaan Laboratorium Terintegrasi untuk mendukung kegiatan akademik dan riset.</p>
            
            <small class="d-block mb-3 opacity-75">Belum memiliki akses?</small>
            <a href="#" class="btn-register">Hubungi Admin</a>

            <div class="d-flex gap-2 mt-5">
                <div style="width: 8px; height: 8px; background: rgba(255,255,255,0.4); border-radius: 50%;"></div>
                <div style="width: 25px; height: 8px; background: white; border-radius: 10px;"></div>
                <div style="width: 8px; height: 8px; background: rgba(255,255,255,0.4); border-radius: 50%;"></div>
            </div>
        </div>

        <div class="window-login">
            <h1>Sign In</h1>
            <p class="subtitle">Selamat datang kembali!</p>

            @if ($errors->any())
                <div class="alert alert-danger py-2 small mb-4" style="border-radius: 10px;">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" name="email" value="{{ old('email') }}" class="form-control" placeholder="user@maintenlab.com" required>
                </div>

                <div class="mb-2">
                    <div class="d-flex justify-content-between">
                        <label class="form-label">Password</label>
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" name="submit" class="btn btn-login text-uppercase">
                    Login ke Dashboard
                </button>
            </form>

            <div class="mt-auto text-center pt-4">
                <small style="color: #4b5563;">&copy; 2026 Maintenance-Lab</small>
            </div>
        </div>
    </div>

</body>
</html>