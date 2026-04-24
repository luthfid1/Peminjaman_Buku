<?php
$pageTitle = 'Edit Buku';
$pageIcon = 'pencil';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card form-card">
            <div class="card-header">
                <h5><i class="bi bi-pencil me-2"></i>Edit Buku</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><i class="bi bi-exclamation-triangle me-2"></i><?= $error ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="judul" class="form-label">Judul Buku <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="judul" name="judul" value="<?= htmlspecialchars($_POST['judul'] ?? $buku_item->judul) ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="kategori_id" class="form-label">Kategori</label>
                            <select class="form-select" id="kategori_id" name="kategori_id">
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($kategori as $k): ?>
                                    <option value="<?= $k->id ?>" <?= ($buku_item->kategori_id == $k->id) ? 'selected' : '' ?>><?= htmlspecialchars($k->nama_kategori) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pengarang" class="form-label">Pengarang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="pengarang" name="pengarang" value="<?= htmlspecialchars($_POST['pengarang'] ?? $buku_item->pengarang) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="penerbit" class="form-label">Penerbit <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?= htmlspecialchars($_POST['penerbit'] ?? $buku_item->penerbit) ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                            <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" value="<?= htmlspecialchars($_POST['tahun_terbit'] ?? $buku_item->tahun_terbit) ?>" min="1900" max="<?= date('Y') ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" class="form-control" id="isbn" name="isbn" value="<?= htmlspecialchars($_POST['isbn'] ?? $buku_item->isbn) ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="jumlah_stok" class="form-label">Jumlah Stok</label>
                            <input type="number" class="form-control" id="jumlah_stok" name="jumlah_stok" value="<?= htmlspecialchars($_POST['jumlah_stok'] ?? $buku_item->jumlah_stok) ?>" min="0">
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Update</button>
                        <a href="<?= App::BASE_URL ?>/index.php?page=buku" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
