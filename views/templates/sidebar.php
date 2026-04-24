<?php $currentPage = $_GET['page'] ?? 'dashboard'; ?>

<!-- Sidebar -->
<div class="sidebar">
    <a href="<?= App::BASE_URL ?>/index.php?page=dashboard" class="sidebar-brand">
        <i class="bi bi-book-half"></i>
        <span><?= App::APP_NAME ?></span>
    </a>

    <div class="sidebar-menu">
        <div class="sidebar-heading">Menu Utama</div>
        
        <a href="<?= App::BASE_URL ?>/index.php?page=dashboard" class="sidebar-item <?= $currentPage === 'dashboard' ? 'active' : '' ?>">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>

        <?php if ($_SESSION['role'] === 'admin'): ?>
            <div class="sidebar-heading">Master Data</div>
            
            <a href="<?= App::BASE_URL ?>/index.php?page=kategori" class="sidebar-item <?= $currentPage === 'kategori' ? 'active' : '' ?>">
                <i class="bi bi-tags"></i>
                <span>Kategori</span>
            </a>

            <a href="<?= App::BASE_URL ?>/index.php?page=buku" class="sidebar-item <?= $currentPage === 'buku' ? 'active' : '' ?>">
                <i class="bi bi-journal-bookmark"></i>
                <span>Buku</span>
            </a>

            <a href="<?= App::BASE_URL ?>/index.php?page=anggota" class="sidebar-item <?= $currentPage === 'anggota' ? 'active' : '' ?>">
                <i class="bi bi-people"></i>
                <span>Anggota</span>
            </a>

            <div class="sidebar-heading">Transaksi</div>
            
            <a href="<?= App::BASE_URL ?>/index.php?page=peminjaman" class="sidebar-item <?= $currentPage === 'peminjaman' ? 'active' : '' ?>">
                <i class="bi bi-arrow-left-right"></i>
                <span>Peminjaman</span>
            </a>

            <a href="<?= App::BASE_URL ?>/index.php?page=pengembalian" class="sidebar-item <?= $currentPage === 'pengembalian' ? 'active' : '' ?>">
                <i class="bi bi-arrow-return-left"></i>
                <span>Pengembalian</span>
            </a>

            <div class="sidebar-heading">Laporan</div>
            
            <a href="<?= App::BASE_URL ?>/index.php?page=laporan" class="sidebar-item <?= $currentPage === 'laporan' ? 'active' : '' ?>">
                <i class="bi bi-bar-chart"></i>
                <span>Statistik</span>
            </a>
        <?php else: ?>
            <div class="sidebar-heading">Menu Siswa</div>
            
            <a href="<?= App::BASE_URL ?>/index.php?page=buku" class="sidebar-item <?= $currentPage === 'buku' ? 'active' : '' ?>">
                <i class="bi bi-book"></i>
                <span>Katalog Buku</span>
            </a>

            <a href="<?= App::BASE_URL ?>/index.php?page=peminjaman" class="sidebar-item <?= $currentPage === 'peminjaman' ? 'active' : '' ?>">
                <i class="bi bi-journal-text"></i>
                <span>Peminjaman Saya</span>
            </a>

            <a href="<?= App::BASE_URL ?>/index.php?page=panduan" class="sidebar-item <?= $currentPage === 'panduan' ? 'active' : '' ?>">
                <i class="bi bi-question-circle"></i>
                <span>Cara Meminjam</span>
            </a>
        <?php endif; ?>
    </div>

    <div class="sidebar-user">
        <div class="user-info">
            <div class="user-avatar">
                <?= strtoupper(substr($_SESSION['nama_lengkap'], 0, 1)) ?>
            </div>
            <div>
                <div class="user-name"><?= htmlspecialchars($_SESSION['nama_lengkap']) ?></div>
                <div class="user-role"><?= $_SESSION['role'] ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Topbar -->
    <div class="topbar">
        <h4><i class="bi bi-<?= $pageIcon ?? 'house' ?> me-2"></i><?= $pageTitle ?? 'Dashboard' ?></h4>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted small"><?= date('d M Y') ?></span>
            
            <!-- Notification Bell -->
            <div class="notification-dropdown">
                <button class="notification-btn" id="notificationBtn">
                    <i class="bi bi-bell"></i>
                    <span class="notification-badge" id="notificationBadge">0</span>
                </button>
                <div class="notification-menu" id="notificationMenu">
                    <div class="notification-header">
                        <h6><i class="bi bi-bell-fill"></i> Notifikasi</h6>
                        <button class="btn-close-notif" onclick="closeNotificationMenu()">×</button>
                    </div>
                    <div class="notification-list" id="notificationList">
                        <div class="notification-empty">
                            <i class="bi bi-inbox"></i>
                            <p>Tidak ada notifikasi</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <a href="<?= App::BASE_URL ?>/index.php?page=auth&action=logout" class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin logout?');">
                <i class="bi bi-box-arrow-right me-1"></i>Logout
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="content-wrapper">
        <?php if (isset($_SESSION['flash_success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i><?= $_SESSION['flash_success'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash_success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['flash_error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i><?= $_SESSION['flash_error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash_error']); ?>
        <?php endif; ?>
