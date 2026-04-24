<?php
$pageTitle = 'Laporan Statistik';
$pageIcon = 'bar-chart';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<div class="card data-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Laporan Lengkap</h5>
            <div class="btn-group">
                <a href="<?= App::BASE_URL ?>/index.php?page=laporan&action=export&format=csv" class="btn btn-sm btn-success">
                    <i class="bi bi-download me-1"></i>Export CSV
                </a>
                <a href="<?= App::BASE_URL ?>/index.php?page=laporan&action=export&format=pdf" class="btn btn-sm btn-danger">
                    <i class="bi bi-file-pdf me-1"></i>Export PDF
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <!-- Statistik Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card" style="border-left: 4px solid #7b2ff7;">
                    <div class="stat-label">Total Peminjaman</div>
                    <div class="stat-value"><?= $statistikPeminjaman->total_peminjaman ?? 0 ?></div>
                    <small class="text-muted">Sepanjang waktu</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="border-left: 4px solid #36b9cc;">
                    <div class="stat-label">Total Pengembalian</div>
                    <div class="stat-value"><?= $statistikPengembalian->total_pengembalian ?? 0 ?></div>
                    <small class="text-muted">Buku dikembalikan</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="border-left: 4px solid #f6c23e;">
                    <div class="stat-label">Total Denda</div>
                    <div class="stat-value">Rp <?= number_format($statistikPengembalian->total_denda ?? 0, 0, ',', '.') ?></div>
                    <small class="text-muted">Dari pengembalian</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="border-left: 4px solid #e74a3b;">
                    <div class="stat-label">Peminjaman Terlambat</div>
                    <div class="stat-value"><?= count($peminjamanTerlambat) ?></div>
                    <small class="text-muted">Belum dikembalikan</small>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <!-- Charts Section -->
        <div class="row">
            <!-- Peminjaman per Status -->
            <div class="col-md-6">
                <div class="chart-container">
                    <h6 class="mb-3">Peminjaman per Status</h6>
                    <canvas id="chartStatus"></canvas>
                </div>
            </div>

            <!-- Peminjaman per Bulan -->
            <div class="col-md-6">
                <div class="chart-container">
                    <h6 class="mb-3">Peminjaman Setiap Bulan (<?= date('Y') ?>)</h6>
                    <canvas id="chartBulan"></canvas>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Buku Paling Dipinjam -->
            <div class="col-md-6">
                <div class="chart-container">
                    <h6 class="mb-3">5 Buku Paling Dipinjam</h6>
                    <canvas id="chartBuku"></canvas>
                </div>
            </div>

            <!-- Stok Buku -->
            <div class="col-md-6">
                <div class="chart-container">
                    <h6 class="mb-3">Status Stok Buku</h6>
                    <canvas id="chartStok"></canvas>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <!-- Detail Statistik -->
        <div class="row">
            <div class="col-md-12">
                <h6 class="mb-3">Detail Status Peminjaman</h6>
                <div class="row">
                    <div class="col-md-2">
                        <div class="detail-stat">
                            <span class="badge bg-warning text-dark">Pengajuan</span>
                            <div class="stat-number"><?= $statistikPeminjaman->pengajuan ?? 0 ?></div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="detail-stat">
                            <span class="badge bg-info">Disetujui</span>
                            <div class="stat-number"><?= $statistikPeminjaman->disetujui ?? 0 ?></div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="detail-stat">
                            <span class="badge bg-primary">Dipinjam</span>
                            <div class="stat-number"><?= $statistikPeminjaman->dipinjam ?? 0 ?></div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="detail-stat">
                            <span class="badge bg-success">Dikembalikan</span>
                            <div class="stat-number"><?= $statistikPeminjaman->dikembalikan ?? 0 ?></div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="detail-stat">
                            <span class="badge bg-danger">Terlambat</span>
                            <div class="stat-number"><?= count($peminjamanTerlambat) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <!-- Pengguna Paling Aktif -->
        <div class="row">
            <div class="col-md-6">
                <h6 class="mb-3">5 Pengguna Paling Aktif</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Total Peminjaman</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($penggunaPalingAktif as $user): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($user->nama_lengkap) ?></td>
                                <td><span class="badge bg-info"><?= $user->total_peminjaman ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Buku Paling Dipinjam Table -->
            <div class="col-md-6">
                <h6 class="mb-3">5 Buku Paling Dipinjam</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Total Pinjam</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($bukuPalingDipinjam as $buku): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars(substr($buku->judul, 0, 30)) ?>...</td>
                                <td><span class="badge bg-primary"><?= $buku->total_peminjaman ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>

<script>
    // Color palette
    const colors = {
        primary: '#7b2ff7',
        success: '#1cc88a',
        info: '#36b9cc',
        warning: '#f6c23e',
        danger: '#e74a3b',
        muted: '#858796'
    };

    // Chart 1: Peminjaman per Status
    const contexStatus = document.getElementById('chartStatus').getContext('2d');
    new Chart(contexStatus, {
        type: 'doughnut',
        data: {
            labels: [
                'Pengajuan (<?= $statistikPeminjaman->pengajuan ?? 0 ?>)',
                'Disetujui (<?= $statistikPeminjaman->disetujui ?? 0 ?>)',
                'Dipinjam (<?= $statistikPeminjaman->dipinjam ?? 0 ?>)',
                'Dikembalikan (<?= $statistikPeminjaman->dikembalikan ?? 0 ?>)'
            ],
            datasets: [{
                data: [
                    <?= $statistikPeminjaman->pengajuan ?? 0 ?>,
                    <?= $statistikPeminjaman->disetujui ?? 0 ?>,
                    <?= $statistikPeminjaman->dipinjam ?? 0 ?>,
                    <?= $statistikPeminjaman->dikembalikan ?? 0 ?>
                ],
                backgroundColor: [
                    colors.warning,
                    colors.info,
                    colors.primary,
                    colors.success
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 15 }
                }
            }
        }
    });

    // Chart 2: Peminjaman per Bulan
    const contextBulan = document.getElementById('chartBulan').getContext('2d');
    new Chart(contextBulan, {
        type: 'line',
        data: {
            labels: [
                <?php foreach ($peminjamanPerBulan as $bulan): ?>
                '<?= $bulan->nama_bulan ?>',
                <?php endforeach; ?>
            ],
            datasets: [{
                label: 'Peminjaman',
                data: [
                    <?php foreach ($peminjamanPerBulan as $bulan): ?>
                    <?= $bulan->total_peminjaman ?>,
                    <?php endforeach; ?>
                ],
                borderColor: colors.primary,
                backgroundColor: 'rgba(123, 47, 247, 0.1)',
                borderWidth: 3,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Chart 3: Buku Paling Dipinjam
    const contextBuku = document.getElementById('chartBuku').getContext('2d');
    new Chart(contextBuku, {
        type: 'bar',
        data: {
            labels: [
                <?php foreach ($bukuPalingDipinjam as $buku): ?>
                '<?= substr(htmlspecialchars($buku->judul), 0, 20) ?>...',
                <?php endforeach; ?>
            ],
            datasets: [{
                label: 'Total Peminjaman',
                data: [
                    <?php foreach ($bukuPalingDipinjam as $buku): ?>
                    <?= $buku->total_peminjaman ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: colors.primary,
                borderColor: colors.primary,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            indexAxis: 'y',
            plugins: {
                legend: { display: false }
            }
        }
    });

    // Chart 4: Status Stok Buku
    const contextStok = document.getElementById('chartStok').getContext('2d');
    new Chart(contextStok, {
        type: 'pie',
        data: {
            labels: [
                'Stok Ada (<?= ($statistikStok->total_buku - $statistikStok->buku_habis) ?? 0 ?>)',
                'Stok Habis (<?= $statistikStok->buku_habis ?? 0 ?>)',
                'Hampir Habis (<?= $statistikStok->buku_hampir_habis ?? 0 ?>)'
            ],
            datasets: [{
                data: [
                    <?= (($statistikStok->total_buku ?? 0) - ($statistikStok->buku_habis ?? 0) - ($statistikStok->buku_hampir_habis ?? 0)) ?>,
                    <?= $statistikStok->buku_habis ?? 0 ?>,
                    <?= $statistikStok->buku_hampir_habis ?? 0 ?>
                ],
                backgroundColor: [
                    colors.success,
                    colors.danger,
                    colors.warning
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 15 }
                }
            }
        }
    });
</script>

<style>
    .stat-card {
        background: #fff;
        padding: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        margin-bottom: 1rem;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #858796;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #2c3e50;
    }

    .chart-container {
        background: #fff;
        padding: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        margin-bottom: 1rem;
    }

    .detail-stat {
        text-align: center;
        padding: 1rem;
        background: #f8f9fc;
        border-radius: 0.5rem;
    }

    .detail-stat .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #7b2ff7;
        margin-top: 0.5rem;
    }

    @media (max-width: 768px) {
        .chart-container {
            margin-bottom: 2rem;
        }
    }
</style>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>