<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= App::APP_NAME ?> - Peminjaman buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= App::BASE_URL ?>/assets/css/style.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2E7D32; /* green */
            --primary-dark: #1a472a;
            --accent-color: #FFA500; /* orange */
            --muted-bg: #f8f9fa;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Navbar Styles */
        .navbar-home {
            background: linear-gradient(90deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 1rem 0;
            animation: slideInDown 0.6s ease-out;
        }

        .navbar-home .navbar-brand {
            font-size: 1.3rem;
            font-weight: 700;
            color: #fff !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }
        .navbar-home .navbar-brand:hover {
            transform: scale(1.05);
        }

        .navbar-home .navbar-brand i { font-size: 1.5rem; animation: bounce 0.6s ease-out; }

        .navbar-home .nav-link { color: rgba(255,255,255,0.9) !important; margin: 0 0.5rem; transition: all 0.3s ease; }
        .navbar-home .nav-link:hover { color: var(--accent-color) !important; transform: translateY(-2px); }

        .navbar-home .btn-login {
            background: rgba(255,165,0,0.12);
            border: 2px solid var(--accent-color);
            color: var(--accent-color);
            padding: 0.4rem 1rem; 
            border-radius: 20px; 
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .navbar-home .btn-login:hover { background: var(--accent-color); color: #fff; transform: translateY(-2px); }

        .navbar-home .btn-register {
            background: var(--accent-color); 
            border: 2px solid var(--accent-color); 
            color: #fff; 
            padding: 0.4rem 1rem; 
            border-radius: 20px; 
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .navbar-home .btn-register:hover { background: #e59400; border-color: #e59400; transform: translateY(-2px); }

        /* ==================== ANIMATIONS ==================== */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0px) rotate(-6deg);
            }
            50% {
                transform: translateY(-20px) rotate(-6deg);
            }
            100% {
                transform: translateY(0px) rotate(-6deg);
            }
        }

        @keyframes floatShape {
            0% {
                transform: translateY(0px) translateX(0px);
            }
            50% {
                transform: translateY(-15px) translateX(5px);
            }
            100% {
                transform: translateY(0px) translateX(0px);
            }
        }

        @keyframes floatShapeB {
            0% {
                transform: translateY(0px) translateX(0px);
            }
            50% {
                transform: translateY(10px) translateX(-5px);
            }
            100% {
                transform: translateY(0px) translateX(0px);
            }
        }

        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 5px 15px rgba(0,0,0,0.06);
            }
            50% {
                box-shadow: 0 8px 25px rgba(0,0,0,0.12);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes shimmer {
            0% {
                opacity: 0.6;
            }
            50% {
                opacity: 1;
            }
            100% {
                opacity: 0.6;
            }
        }

        @keyframes glow {
            0%, 100% {
                text-shadow: 0 0 5px rgba(255, 255, 255, 0.3);
            }
            50% {
                text-shadow: 0 0 20px rgba(255, 255, 255, 0.6);
            }
        }

        @keyframes countUp {
            from {
                opacity: 0;
                transform: scale(0.5);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Hero Section - two column layout */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #2b7f86 100%);
            color: white;
            padding: 5rem 0;
            animation: fadeInDown 0.8s ease-out;
        }

        .hero-content { text-align: left; padding: 2rem 1rem; animation: slideInLeft 0.8s ease-out 0.1s both; }
        .hero-content h1 { font-size: 2.8rem; font-weight: 800; margin-bottom: 1rem; animation: fadeInUp 0.8s ease-out 0.2s both; }
        .hero-content p { font-size: 1.05rem; margin-bottom: 1.8rem; opacity: 0.95; color: rgba(255,255,255,0.95); animation: fadeInUp 0.8s ease-out 0.3s both; }

        .btn-group-hero { display: flex; gap: 1rem; flex-wrap: wrap; animation: fadeInUp 0.8s ease-out 0.4s both; }

        .btn-hero { padding: 0.75rem 1.8rem; font-size: 1rem; border-radius: 30px; font-weight: 700; transition: all 0.3s ease; }
        .btn-hero-primary { background: #fff; color: var(--primary-color); animation: scaleIn 0.6s ease-out 0.5s both; }
        .btn-hero-primary:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.15); }

        .btn-hero-secondary { background: var(--accent-color); color: #fff; border: 2px solid rgba(255,255,255,0.15); animation: scaleIn 0.6s ease-out 0.6s both; }
        .btn-hero-secondary:hover { background: #fff; color: var(--accent-color); transform: translateY(-3px); }

        /* Right visual mockup */
        .hero-visual { position: relative; display: flex; align-items: center; justify-content: center; padding: 2rem; animation: slideInRight 0.8s ease-out 0.1s both; }
        .device {
            width: 260px; height: 480px; border-radius: 36px; background: #fff; box-shadow: 0 25px 50px rgba(0,0,0,0.15); position: relative; overflow: hidden; transform: rotate(-6deg);
            border: 8px solid rgba(255,255,255,0.06);
            animation: float 3s ease-in-out infinite;
        }
        .device::before { content: ''; position: absolute; top: 8px; left: 50%; transform: translateX(-50%); width: 40px; height: 6px; background: rgba(0,0,0,0.08); border-radius: 4px; }
        .device .screen { padding: 18px; height: 100%; box-sizing: border-box; display: flex; flex-direction: column; gap: 12px; }
        .cover-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 6px; }
        .cover { height: 110px; border-radius: 8px; background: linear-gradient(45deg,#4fb6e7,#7d5df6); box-shadow: inset 0 -6px 18px rgba(0,0,0,0.08); }
        .cover.small { height: 60px; }

        /* floating decorative shapes */
        .hero-visual .shape-a { position: absolute; width: 120px; height: 120px; background: rgba(74,144,226,0.12); border-radius: 24px; left: -20px; top: 20px; animation: floatShape 4s ease-in-out infinite; }
        .hero-visual .shape-b { position: absolute; width: 80px; height: 80px; background: rgba(255,165,0,0.12); border-radius: 50%; right: -10px; bottom: 40px; animation: floatShapeB 4s ease-in-out infinite; }

        /* Features Section */
        .features-section { padding: 4rem 0; background: var(--muted-bg); animation: fadeInUp 0.8s ease-out; }
        .features-section h2 { text-align: center; font-size: 2.2rem; font-weight: 700; margin-bottom: 2.5rem; color: #333; animation: fadeInDown 0.8s ease-out 0.1s both; }

        .feature-card { background: white; border-radius: 15px; padding: 2rem; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.06); transition: all 0.25s ease; height: 100%; cursor: pointer; animation: scaleIn 0.6s ease-out backwards; }
        .feature-card:nth-child(1) { animation-delay: 0.1s; }
        .feature-card:nth-child(2) { animation-delay: 0.2s; }
        .feature-card:nth-child(3) { animation-delay: 0.3s; }
        .feature-card:nth-child(4) { animation-delay: 0.4s; }
        .feature-card:nth-child(5) { animation-delay: 0.5s; }
        .feature-card:nth-child(6) { animation-delay: 0.6s; }
        .feature-card:hover { transform: translateY(-8px); box-shadow: 0 12px 25px rgba(0,0,0,0.12); }
        .feature-card.active { animation: pressAnimation 0.6s ease; }
        .feature-card i { font-size: 2.4rem; color: var(--accent-color); margin-bottom: 1rem; transition: all 0.3s ease; }
        .feature-card:hover i { animation: bounce 0.6s ease-out; }
        
        /* Button Click Animation */
        @keyframes pressAnimation {
            0% { transform: scale(1); }
            50% { transform: scale(0.95); box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
            100% { transform: scale(1); box-shadow: 0 5px 15px rgba(0,0,0,0.06); }
        }
        
        .btn:not(.nav-link).active { animation: buttonPress 0.4s ease; }
        
        @keyframes buttonPress {
            0% { transform: scale(1); }
            50% { transform: scale(0.92); }
            100% { transform: scale(1); }
        }

        /* Statistics Section */
        .stats-section { background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%); color: white; padding: 3rem 0; animation: fadeInUp 0.8s ease-out; }
        .stat-item { animation: countUp 0.8s ease-out backwards; }
        .stat-item:nth-child(1) { animation-delay: 0.2s; }
        .stat-item:nth-child(2) { animation-delay: 0.3s; }
        .stat-item:nth-child(3) { animation-delay: 0.4s; }
        .stat-item:nth-child(4) { animation-delay: 0.5s; }
        .stat-number { font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem; animation: shimmer 2s ease-in-out infinite; }
        .stat-label { font-size: 0.95rem; opacity: 0.9; }

        /* CTA Section */
        .cta-section { background: linear-gradient(135deg, var(--accent-color) 0%, #ff8c00 100%); color: white; padding: 3rem 2rem; text-align: center; border-radius: 12px; margin: 3rem 0; animation: fadeInUp 0.8s ease-out; transition: all 0.3s ease; }
        .cta-section:hover { box-shadow: 0 15px 40px rgba(255, 165, 0, 0.3); transform: translateY(-5px); }
        .cta-section h2 { animation: glow 2s ease-in-out infinite; }
        .cta-section .btn { animation: scaleIn 0.6s ease-out 0.3s both; }

        /* Footer */
        .footer { background: #333; color: white; padding: 2rem 0; text-align: center; animation: fadeInUp 0.8s ease-out; }
        .footer p { margin: 0; }
        
        @media (max-width: 767px) {
            .hero-content h1 { font-size: 1.8rem; }
            .device { transform: none; width: 200px; height: 380px; animation: fadeInUp 0.8s ease-out; }
            .hero-section { padding: 3.5rem 0; }
            .hero-content { text-align: center; }
            .hero-visual { animation: slideInUp 0.8s ease-out 0.1s both; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-home navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="<?= App::BASE_URL ?>/">
                <i class="bi bi-book"></i>
                <span><?= App::APP_NAME ?></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto d-flex align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-login" href="<?= App::BASE_URL ?>/index.php?page=auth&action=login">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-register" href="<?= App::BASE_URL ?>/index.php?page=auth&action=register">
                            <i class="bi bi-person-plus me-1"></i>Register
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 hero-content">
                    <h1>
                        <i class="bi bi-book-half"></i>
                        Peminjaman Buku Untuk Generasi Digital
                    </h1>
                    <p>Sistem Manajemen Peminjaman Buku Modern, Efisien, dan Layanan Peminjaman Buku Digital yang Dirancang
                        dan Dikembangkan Untuk Memenuhi Kebutuhan Khusus Anda</p>

                    <div class="btn-group-hero">
                        <a href="<?= App::BASE_URL ?>/index.php?page=auth&action=register" class="btn btn-hero btn-hero-primary">
                            <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                        </a>
                        <a href="<?= App::BASE_URL ?>/index.php?page=auth&action=login" class="btn btn-hero btn-hero-secondary">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Akun
                        </a>
                    </div>
                </div>

                <div class="col-md-6 d-none d-md-flex hero-visual">
                    <div class="shape-a"></div>
                    <div class="device" aria-hidden="true">
                        <div class="screen">
                            <div style="display:flex;gap:8px;align-items:center;">
                                <div style="flex:1;height:14px;background:linear-gradient(90deg,#e9e9e9,#dcdcdc);border-radius:6px"></div>
                                <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(90deg,#4fb6e7,#7d5df6)"></div>
                            </div>
                            <div class="cover-grid">
                                <div class="cover"></div>
                                <div class="cover"></div>
                                <div class="cover small"></div>
                                <div class="cover small"></div>
                            </div>
                            <div style="flex:1"></div>
                        </div>
                    </div>
                    <div class="shape-b"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <div class="container">
            <h2>Fitur Unggulan</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="bi bi-search"></i>
                        <h4>Pencarian Mudah</h4>
                        <p>Cari buku dengan cepat dan mudah menggunakan berbagai filter dan kategori yang tersedia.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="bi bi-arrow-left-right"></i>
                        <h4>Manajemen Peminjaman</h4>
                        <p>Kelola peminjaman dan pengembalian buku dengan sistem yang transparan dan terintegrasi.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="bi bi-calendar-event"></i>
                        <h4>Jadwal Otomatis</h4>
                        <p>Sistem notifikasi otomatis untuk pengingat pengembalian buku sesuai jadwal yang ditentukan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="bi bi-bar-chart"></i>
                        <h4>Laporan Lengkap</h4>
                        <p>Dapatkan laporan statistik peminjaman dan pengembalian yang terperinci dan akurat.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="bi bi-shield-check"></i>
                        <h4>Keamanan Data</h4>
                        <p>Data Anda dilindungi dengan enkripsi dan sistem keamanan tingkat enterprise.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="bi bi-headset"></i>
                        <h4>Dukungan 24/7</h4>
                        <p>Tim support kami siap membantu Anda kapan saja untuk pertanyaan atau masalah teknis.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">20+</div>
                        <div class="stat-label">Koleksi Buku</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">10+</div>
                        <div class="stat-label">Siswa Aktif</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">20+</div>
                        <div class="stat-label">Peminjaman/Bulan</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">95%</div>
                        <div class="stat-label">Kepuasan Pengguna</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="tentang" class="container">
        <div class="cta-section">
            <h2>Siap Bergabung?</h2>
            <p>Daftar sekarang dan nikmati semua fitur perpustakaan digital kami</p>
            <a href="<?= App::BASE_URL ?>/index.php?page=auth&action=register" class="btn btn-light btn-lg">
                <i class="bi bi-person-plus me-2"></i>Daftar Gratis
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 Peminjaman Buku Umum Digital</p>
            <p>
                <small>
                    <a href="#" class="text-white-50 text-decoration-none">Kebijakan Privasi</a> | 
                    <a href="#" class="text-white-50 text-decoration-none">Syarat & Ketentuan</a> | 
                    <a href="#" class="text-white-50 text-decoration-none">Hubungi Kami</a>
                </small>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling untuk anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && document.querySelector(href)) {
                    e.preventDefault();
                    document.querySelector(href).scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Animasi klik untuk buttons
        document.querySelectorAll('.btn, .feature-card').forEach(element => {
            element.addEventListener('click', function(e) {
                // Hapus class active jika sudah ada
                this.classList.remove('active');
                
                // Trigger animasi dengan menambahkan class active
                void this.offsetWidth; // Force reflow
                this.classList.add('active');
                
                // Hapus class setelah animasi selesai
                setTimeout(() => {
                    this.classList.remove('active');
                }, 600);
            });

            // Tambahkan animasi hover untuk buttons
            if (element.classList.contains('btn')) {
                element.addEventListener('mousedown', function(e) {
                    // Tambahkan ripple effect pada mouse down
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const diameter = Math.max(rect.width, rect.height);
                    const radius = diameter / 2;

                    ripple.style.width = ripple.style.height = diameter + 'px';
                    ripple.style.left = (e.clientX - rect.left - radius) + 'px';
                    ripple.style.top = (e.clientY - rect.top - radius) + 'px';
                    ripple.classList.add('ripple');

                    // Tambahkan style ripple jika belum ada
                    if (!document.getElementById('ripple-styles')) {
                        const style = document.createElement('style');
                        style.id = 'ripple-styles';
                        style.textContent = `
                            .btn {
                                position: relative;
                                overflow: hidden;
                            }
                            .ripple {
                                position: absolute;
                                border-radius: 50%;
                                background: rgba(255, 255, 255, 0.5);
                                transform: scale(0);
                                animation: ripple-animation 0.6s ease-out;
                                pointer-events: none;
                            }
                            @keyframes ripple-animation {
                                to {
                                    transform: scale(4);
                                    opacity: 0;
                                }
                            }
                        `;
                        document.head.appendChild(style);
                    }

                    this.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                });
            }
        });
    </script>
</body>
</html>
