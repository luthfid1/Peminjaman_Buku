<?php
$pageTitle = 'Tambah Peminjaman';
$pageIcon = 'plus-circle';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card form-card">
            <div class="card-header">
                <h5><i class="bi bi-plus-circle me-2"></i>Tambah Peminjaman Baru</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><i class="bi bi-exclamation-triangle me-2"></i><?= $error ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Peminjam (Siswa) <span class="text-danger">*</span></label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            <option value="">-- Pilih Siswa --</option>
                            <?php foreach ($siswa as $s): ?>
                                <option value="<?= $s->id ?>" <?= (isset($_POST['user_id']) && $_POST['user_id'] == $s->id) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($s->nama_lengkap) ?> (<?= $s->username ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="buku_id" class="form-label">Buku <span class="text-danger">*</span></label>
                        <select class="form-select" id="buku_id" name="buku_id" required>
                            <option value="">-- Pilih Buku --</option>
                            <?php foreach ($buku as $b): ?>
                                <option value="<?= $b->id ?>" <?= (isset($_POST['buku_id']) && $_POST['buku_id'] == $b->id) ? 'selected' : '' ?> <?= $b->jumlah_stok <= 0 ? 'disabled' : '' ?>>
                                    <?= htmlspecialchars($b->judul) ?> (Stok: <?= $b->jumlah_stok ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" value="<?= htmlspecialchars($_POST['tanggal_pinjam'] ?? date('Y-m-d')) ?>" min="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_kembali" class="form-label">Tanggal Kembali <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" value="<?= htmlspecialchars($_POST['tanggal_kembali'] ?? date('Y-m-d', strtotime('+7 days'))) ?>" min="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                        <a href="<?= App::BASE_URL ?>/index.php?page=peminjaman" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>