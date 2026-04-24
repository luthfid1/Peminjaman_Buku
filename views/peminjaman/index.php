<?php
$pageTitle = 'Data Peminjaman';
$pageIcon = 'arrow-left-right';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<div class="card data-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-arrow-left-right me-2"></i><?= $_SESSION['role'] === 'admin' ? 'Daftar Peminjaman' : 'Peminjaman Saya' ?></h5>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="<?= App::BASE_URL ?>/index.php?page=peminjaman&action=create" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i>Tambah Peminjaman
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body p-0">
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <!-- Tab untuk Admin -->
            <ul class="nav nav-tabs px-3 pt-3" role="tablist" style="border-bottom: 2px solid #e3e6f0;">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="tab-pengajuan" href="#content-pengajuan" data-bs-toggle="tab" role="tab" aria-controls="content-pengajuan" aria-selected="true" style="cursor: pointer;">
                        <i class="bi bi-hourglass-split me-1"></i>Menunggu Persetujuan
                        <span class="badge bg-danger ms-2"><?= count(array_filter($peminjaman, fn($p) => $p->status === 'pengajuan')) ?></span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-disetujui" href="#content-disetujui" data-bs-toggle="tab" role="tab" aria-controls="content-disetujui" aria-selected="false" style="cursor: pointer;">
                        <i class="bi bi-check-circle me-1"></i>Disetujui & Dipinjam
                        <span class="badge bg-info ms-2"><?= count(array_filter($peminjaman, fn($p) => in_array($p->status, ['disetujui', 'dipinjam']))) ?></span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-dikembalikan" href="#content-dikembalikan" data-bs-toggle="tab" role="tab" aria-controls="content-dikembalikan" aria-selected="false" style="cursor: pointer;">
                        <i class="bi bi-check-double me-1"></i>Dikembalikan
                        <span class="badge bg-success ms-2"><?= count(array_filter($peminjaman, fn($p) => $p->status === 'dikembalikan')) ?></span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-ditolak" href="#content-ditolak" data-bs-toggle="tab" role="tab" aria-controls="content-ditolak" aria-selected="false" style="cursor: pointer;">
                        <i class="bi bi-x-circle me-1"></i>Ditolak
                        <span class="badge bg-dark ms-2"><?= count(array_filter($peminjaman, fn($p) => $p->status === 'ditolak')) ?></span>
                    </a>
                </li>
            </ul>

            <div class="tab-content" style="padding-top: 1.5rem;">
                <!-- Tab Menunggu Persetujuan -->
                <div class="tab-pane fade show active" id="content-pengajuan" role="tabpanel" aria-labelledby="tab-pengajuan">
                    <?php 
                    $peminjamanPengajuan = array_filter($peminjaman, fn($p) => $p->status === 'pengajuan');
                    ?>
                    <?php if (!empty($peminjamanPengajuan)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Peminjam</th>
                                        <th>Buku</th>
                                        <th>Tgl Pinjam</th>
                                        <th>Tgl Kembali</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($peminjamanPengajuan as $i => $p): ?>
                                        <tr>
                                            <td><?= count($peminjamanPengajuan) - $i ?></td>
                                            <td><strong><?= htmlspecialchars($p->nama_lengkap) ?></strong></td>
                                            <td><?= htmlspecialchars($p->judul) ?></td>
                                            <td><?= date('d/m/Y', strtotime($p->tanggal_pinjam)) ?></td>
                                            <td><?= date('d/m/Y', strtotime($p->tanggal_kembali)) ?></td>
                                            <td>
                                                <span class="badge bg-warning text-dark">Pengajuan</span>
                                            </td>
                                            <td>
                                                <a href="<?= App::BASE_URL ?>/index.php?page=peminjaman&action=approve&id=<?= $p->id ?>" class="btn btn-success btn-sm" title="Setujui" onclick="return confirm('Setujui peminjaman ini?')">
                                                    <i class="bi bi-check-lg"></i>
                                                </a>
                                                <a href="<?= App::BASE_URL ?>/index.php?page=peminjaman&action=reject&id=<?= $p->id ?>" class="btn btn-danger btn-sm" title="Tolak" onclick="return confirm('Tolak peminjaman ini?')">
                                                    <i class="bi bi-x-lg"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="bi bi-check-circle d-block"></i>
                            <h5>Tidak ada pengajuan</h5>
                            <p class="text-muted">Semua peminjaman sudah diproses</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Tab Disetujui & Dipinjam -->
                <div class="tab-pane fade" id="content-disetujui" role="tabpanel" aria-labelledby="tab-disetujui">
                    <?php 
                    $peminjamanAktif = array_filter($peminjaman, fn($p) => in_array($p->status, ['disetujui', 'dipinjam']));
                    ?>
                    <?php if (!empty($peminjamanAktif)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Peminjam</th>
                                        <th>Buku</th>
                                        <th>Tgl Pinjam</th>
                                        <th>Tgl Kembali</th>
                                        <th>Status</th>
                                        <th>Keterlambatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($peminjamanAktif as $i => $p): ?>
                                        <tr <?= (!empty($p->hari_terlambat) && $p->hari_terlambat > 0) ? 'class="table-danger"' : '' ?>>
                                            <td><?= count($peminjamanAktif) - $i ?></td>
                                            <td><strong><?= htmlspecialchars($p->nama_lengkap) ?></strong></td>
                                            <td><?= htmlspecialchars($p->judul) ?></td>
                                            <td><?= date('d/m/Y', strtotime($p->tanggal_pinjam)) ?></td>
                                            <td><?= date('d/m/Y', strtotime($p->tanggal_kembali)) ?></td>
                                            <td>
                                                <?php if ($p->status === 'disetujui'): ?>
                                                    <span class="badge bg-info">Disetujui</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success">Dipinjam</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($p->hari_terlambat) && $p->hari_terlambat > 0): ?>
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-exclamation-circle me-1"></i>
                                                        <?= $p->hari_terlambat ?> hari
                                                    </span>
                                                    <small class="d-block mt-1 text-dark">
                                                        <strong>Denda Est: Rp <?= number_format($p->estimasi_denda, 0, ',', '.') ?></strong>
                                                    </small>
                                                <?php else: ?>
                                                    <small class="text-success">Tepat waktu</small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= App::BASE_URL ?>/index.php?page=peminjaman&action=edit&id=<?= $p->id ?>" class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="<?= App::BASE_URL ?>/index.php?page=pengembalian&action=create" onclick="setPeminjamanId(<?= $p->id ?>)" class="btn btn-info btn-sm" title="Kembalikan Buku">
                                                        <i class="bi bi-arrow-return-left"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="bi bi-inbox d-block"></i>
                            <h5>Tidak ada peminjaman aktif</h5>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Tab Dikembalikan -->
                <div class="tab-pane fade" id="content-dikembalikan" role="tabpanel" aria-labelledby="tab-dikembalikan">
                    <?php 
                    $peminjamanKembali = array_filter($peminjaman, fn($p) => $p->status === 'dikembalikan');
                    ?>
                    <?php if (!empty($peminjamanKembali)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Peminjam</th>
                                        <th>Buku</th>
                                        <th>Tgl Pinjam</th>
                                        <th>Tgl Dikembalikan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($peminjamanKembali as $i => $p): ?>
                                        <tr>
                                            <td><?= count($peminjamanKembali) - $i ?></td>
                                            <td><strong><?= htmlspecialchars($p->nama_lengkap) ?></strong></td>
                                            <td><?= htmlspecialchars($p->judul) ?></td>
                                            <td><?= date('d/m/Y', strtotime($p->tanggal_pinjam)) ?></td>
                                            <td><?= date('d/m/Y', strtotime($p->tanggal_kembali)) ?></td>
                                            <td>
                                                <span class="badge bg-success">Dikembalikan</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="bi bi-check-all d-block"></i>
                            <h5>Belum ada buku yang dikembalikan</h5>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Tab Ditolak -->
                <div class="tab-pane fade" id="content-ditolak" role="tabpanel" aria-labelledby="tab-ditolak">
                    <?php 
                    $peminjamanDitolak = array_filter($peminjaman, fn($p) => $p->status === 'ditolak');
                    ?>
                    <?php if (!empty($peminjamanDitolak)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Peminjam</th>
                                        <th>Buku</th>
                                        <th>Tgl Pinjam</th>
                                        <th>Tgl Kembali</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($peminjamanDitolak as $i => $p): ?>
                                        <tr>
                                            <td><?= count($peminjamanDitolak) - $i ?></td>
                                            <td><strong><?= htmlspecialchars($p->nama_lengkap) ?></strong></td>
                                            <td><?= htmlspecialchars($p->judul) ?></td>
                                            <td><?= date('d/m/Y', strtotime($p->tanggal_pinjam)) ?></td>
                                            <td><?= date('d/m/Y', strtotime($p->tanggal_kembali)) ?></td>
                                            <td>
                                                <span class="badge bg-danger">Ditolak</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="bi bi-emoji-smile d-block"></i>
                            <h5>Tidak ada peminjaman yang ditolak</h5>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <!-- Tampilan untuk Siswa -->
            <?php if (!empty($peminjaman)): ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Buku</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($peminjaman as $i => $p): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= htmlspecialchars($p->judul) ?></td>
                                    <td><?= date('d/m/Y', strtotime($p->tanggal_pinjam)) ?></td>
                                    <td><?= date('d/m/Y', strtotime($p->tanggal_kembali)) ?></td>
                                    <td>
                                        <?php if ($p->status === 'pengajuan'): ?>
                                            <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                                        <?php elseif ($p->status === 'disetujui'): ?>
                                            <span class="badge bg-info">Disetujui (Ambil Buku)</span>
                                        <?php elseif ($p->status === 'dipinjam'): ?>
                                            <span class="badge bg-success">Sedang Dipinjam</span>
                                        <?php elseif ($p->status === 'ditolak'): ?>
                                            <span class="badge bg-danger">Ditolak</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Dikembalikan</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="bi bi-inbox d-block"></i>
                    <h5>Belum ada peminjaman</h5>
                    <p class="text-muted">Kamu belum meminjam buku apapun. Kunjungi Katalog Buku untuk memulai.</p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<script>
    // Flag untuk memastikan hanya jalan sekali
    let tabInitialized = false;

    function initializeTabs() {
        if (tabInitialized) return;
        tabInitialized = true;

        const hash = window.location.hash;
        
        // Jika ada hash, activate tab yang sesuai
        if (hash && hash.startsWith('#content-')) {
            switchToTab(hash);
        }

        // Listen untuk hash change (back/forward button)
        window.addEventListener('hashchange', function() {
            const newHash = window.location.hash;
            if (newHash && newHash.startsWith('#content-')) {
                switchToTab(newHash);
            }
        });
    }

    function switchToTab(contentId) {
        // Hapus active dari semua tab
        document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
            tab.classList.remove('active');
            tab.setAttribute('aria-selected', 'false');
        });

        // Hapus show active dari semua tab pane
        document.querySelectorAll('.tab-pane').forEach(pane => {
            pane.classList.remove('show', 'active');
        });

        // Aktifkan tab yang sesuai
        const tabLink = document.querySelector('a[href="' + contentId + '"]');
        if (tabLink) {
            tabLink.classList.add('active');
            tabLink.setAttribute('aria-selected', 'true');
        }

        // Aktifkan tab pane yang sesuai
        const tabPane = document.querySelector(contentId);
        if (tabPane) {
            tabPane.classList.add('show', 'active');
        }
    }

    function initializeSessionStorage() {
        const peminjamanId = sessionStorage.getItem('peminjamanId');
        if (peminjamanId) {
            const selectElement = document.getElementById('peminjaman_id');
            if (selectElement) {
                selectElement.value = peminjamanId;
                selectElement.dispatchEvent(new Event('change'));
                sessionStorage.removeItem('peminjamanId');
            }
        }
    }

    function setPeminjamanId(peminjamanId) {
        sessionStorage.setItem('peminjamanId', peminjamanId);
    }

    // Trigger saat DOMContentLoaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initializeTabs();
            initializeSessionStorage();
        });
    } else {
        // Jika sudah loaded sebelum script ini dijalankan
        initializeTabs();
        initializeSessionStorage();
    }

    // Trigger juga saat load event (extra safety)
    window.addEventListener('load', function() {
        initializeTabs();
        initializeSessionStorage();
    });
</script>