<?php $pageTitle = 'Login'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?= App::APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= App::BASE_URL ?>/assets/css/style.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2E7D32;
            --secondary-color: #FFA500;
        }

        body {
            background: linear-gradient(135deg, #3d4941 0%, #2b7f86 100%);
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

        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 80px);
            padding: 2rem 1rem;
        }

        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 420px;
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, #2E7D32 0%, #1a472a 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .login-header i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .login-header h3 {
            margin: 0.5rem 0;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .login-header p {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .login-body {
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
            border-color: #2E7D32;
            box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, #2E7D32 0%, #1a472a 100%);
            border: none;
            padding: 0.7rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1a472a 0%, #113d20 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 125, 50, 0.3);
        }

        .form-label {
            color: #333;
            font-size: 0.95rem;
        }

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #eee;
        }

        .register-link a {
            color: #2E7D32;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .register-link a:hover {
            color: #FFA500;
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

    <div class="login-wrapper">
        <div class="login-card card">
            <div class="login-header">
                <i class="bi bi-box-arrow-in-right"></i>
                <h3>Masuk Akun</h3>
                <p>Perpustakaan Umum</p>
            </div>
            <div class="login-body card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger py-2 mb-3">
                        <i class="bi bi-exclamation-triangle me-2"></i><?= $error ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= App::BASE_URL ?>/index.php?page=auth&action=login">
                    <div class="mb-3">
                        <label for="username" class="form-label fw-semibold">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required autofocus>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword" title="Tampilkan / sembunyikan password">
                                    <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-semibold">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                    </button>
                </form>

                <script>
                    // Toggle password visibility
                    (function(){
                        var toggle = document.getElementById('togglePassword');
                        var pwd = document.getElementById('password');
                        var icon = document.getElementById('togglePasswordIcon');
                        if (toggle) {
                            toggle.addEventListener('click', function(){
                                if (pwd.type === 'password') {
                                    pwd.type = 'text';
                                    icon.classList.remove('bi-eye'); icon.classList.add('bi-eye-slash');
                                } else {
                                    pwd.type = 'password';
                                    icon.classList.remove('bi-eye-slash'); icon.classList.add('bi-eye');
                                }
                            });
                        }
                    })();
                </script>

                <div class="register-link">
                    <small class="text-muted">
                        Belum punya akun? 
                        <a href="<?= App::BASE_URL ?>/index.php?page=auth&action=register">Daftar di sini</a>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
