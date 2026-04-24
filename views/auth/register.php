<?php $pageTitle = 'Register'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - <?= App::APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= App::BASE_URL ?>/assets/css/style.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #575e57;
            --secondary-color: #FFA500;
        }

        body {
            background: linear-gradient(135deg, #1a472a 0%, #2b7f86 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Navbar Styles */
        .navbar-auth {
            background: linear-gradient(90deg, #1a472a 0%, #2E7D32 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }

        .navbar-auth .navbar-brand {
            font-size: 1.3rem;
            font-weight: 700;
            color: #fff !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-auth .navbar-brand i {
            font-size: 1.5rem;
        }

        .navbar-auth .nav-link {
            color: rgba(255,255,255,0.8) !important;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .navbar-auth .nav-link:hover {
            color: #FFA500 !important;
        }

        .navbar-auth .btn-login {
            background: rgba(255,165,0,0.2);
            border: 2px solid #FFA500;
            color: #FFA500;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            transition: all 0.3s ease;
            margin: 0 0.25rem;
            font-weight: 600;
        }

        .navbar-auth .btn-login:hover {
            background: #FFA500;
            color: #fff;
        }

        .navbar-auth .btn-register {
            background: #FFA500;
            border: 2px solid #FFA500;
            color: #fff;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            transition: all 0.3s ease;
            margin: 0 0.25rem;
            font-weight: 600;
        }

        .navbar-auth .btn-register:hover {
            background: #E59400;
            border-color: #E59400;
        }

        .register-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 80px);
            padding: 2rem 1rem;
        }

        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 450px;
            overflow: hidden;
        }

        .register-header {
            background: linear-gradient(135deg, #2E7D32 0%, #1a472a 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .register-header i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .register-header h3 {
            margin: 0.5rem 0;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .register-header p {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .register-body {
            padding: 2rem;
        }

        .input-group-text {
            background: #f8f9fa;
            border: 1px solid #ddd;
            color: #666;
        }

        .form-control {
            border: 1px solid #ddd;
            padding: 0.6rem 0.75rem;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: #FFA500;
            box-shadow: 0 0 0 0.2rem rgba(255, 165, 0, 0.25);
        }

        .btn-register-submit {
            background: linear-gradient(135deg, #FFA500 0%, #FF8C00 100%);
            border: none;
            padding: 0.7rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            color: white;
        }

        .btn-register-submit:hover {
            background: linear-gradient(135deg, #FF8C00 0%, #FF7F00 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 165, 0, 0.3);
        }

        .form-label {
            color: #333;
            font-size: 0.95rem;
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #eee;
        }

        .login-link a {
            color: #FFA500;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
            color: #FF8C00;
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        .alert-danger {
            background: #fee;
            color: #c33;
        }

        .alert-success {
            background: #efe;
            color: #3c3;
        }

        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.85rem;
        }

        .strength-bar {
            height: 5px;
            border-radius: 3px;
            background: #ddd;
            margin-top: 0.25rem;
        }

        .strength-bar.weak {
            background: #dc3545;
        }

        .strength-bar.fair {
            background: #ffc107;
        }

        .strength-bar.good {
            background: #b4baba;
        }

        .strength-bar.strong {
            background: #6c6d6c;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-auth navbar-expand-lg">
        <div class="container-fluid">
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
                        <a class="nav-link" href="<?= App::BASE_URL ?>/">
                            <i class="bi bi-house me-1"></i>Beranda
                        </a>
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

    <div class="register-wrapper">
        <div class="register-card card">
            <div class="register-header">
                <i class="bi bi-person-plus"></i>
                <h3>Buat Akun Baru</h3>
                <p>Perpustakaan Umum</p>
            </div>
            <div class="register-body card-body">
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success py-2 mb-3">
                        <i class="bi bi-check-circle me-2"></i><?= $success ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger py-2 mb-3">
                        <i class="bi bi-exclamation-triangle me-2"></i><?= $error ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= App::BASE_URL ?>/index.php?page=auth&action=register" id="formRegister">
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap" value="<?= htmlspecialchars($_POST['nama_lengkap'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label fw-semibold">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-at"></i></span>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Pilih username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required minlength="4">
                        </div>
                        <small class="text-muted">Minimal 4 karakter</small>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Buat password" required minlength="6" oninput="checkPasswordStrength(this.value)">
                                <button class="btn btn-outline-secondary" type="button" id="toggleRegPassword" title="Tampilkan / sembunyikan password">
                                    <i class="bi bi-eye" id="toggleRegPasswordIcon"></i>
                                </button>
                            </div>
                        <small class="text-muted">Minimal 6 karakter</small>
                        <div class="password-strength">
                            <div class="strength-bar" id="strengthBar"></div>
                            <small id="strengthText" class="text-muted"></small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirm" class="form-label fw-semibold">Konfirmasi Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-check"></i></span>
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Konfirmasi password" required>
                            <button class="btn btn-outline-secondary" type="button" id="toggleRegConfirm" title="Tampilkan / sembunyikan konfirmasi password">
                                <i class="bi bi-eye" id="toggleRegConfirmIcon"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-register-submit w-100 fw-semibold">
                        <i class="bi bi-person-plus me-2"></i>Daftar Akun
                    </button>
                </form>

                <div class="login-link">
                    <small class="text-muted">
                        Sudah punya akun? 
                        <a href="<?= App::BASE_URL ?>/index.php?page=auth&action=login">Masuk di sini</a>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            
            let strength = 0;
            
            if (password.length >= 6) strength++;
            if (password.length >= 10) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;
            
            strengthBar.classList.remove('weak', 'fair', 'good', 'strong');
            
            if (strength <= 1) {
                strengthBar.classList.add('weak');
                strengthText.textContent = 'Password lemah';
            } else if (strength <= 2) {
                strengthBar.classList.add('fair');
                strengthText.textContent = 'Password cukup';
            } else if (strength <= 3) {
                strengthBar.classList.add('good');
                strengthText.textContent = 'Password baik';
            } else {
                strengthBar.classList.add('strong');
                strengthText.textContent = 'Password kuat';
            }
        }
        document.getElementById('formRegister').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const passwordConfirm = document.getElementById('password_confirm').value;
            
            if (password !== passwordConfirm) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok!');
                return false;
            }
        });

        // Toggle register password visibility
        (function(){
            var t1 = document.getElementById('toggleRegPassword');
            var p1 = document.getElementById('password');
            var i1 = document.getElementById('toggleRegPasswordIcon');
            if (t1) {
                t1.addEventListener('click', function(){
                    if (p1.type === 'password') { p1.type = 'text'; i1.classList.remove('bi-eye'); i1.classList.add('bi-eye-slash'); }
                    else { p1.type = 'password'; i1.classList.remove('bi-eye-slash'); i1.classList.add('bi-eye'); }
                });
            }

            var t2 = document.getElementById('toggleRegConfirm');
            var p2 = document.getElementById('password_confirm');
            var i2 = document.getElementById('toggleRegConfirmIcon');
            if (t2) {
                t2.addEventListener('click', function(){
                    if (p2.type === 'password') { p2.type = 'text'; i2.classList.remove('bi-eye'); i2.classList.add('bi-eye-slash'); }
                    else { p2.type = 'password'; i2.classList.remove('bi-eye-slash'); i2.classList.add('bi-eye'); }
                });
            }
        })();
    </script>
</body>
</html>
