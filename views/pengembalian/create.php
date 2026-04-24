<?php
$pageTitle = 'Catat Pengembalian';
$pageIcon = 'plus-circle';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card form-card">
            <div class="card-header">
                <h5><i class="bi bi-plus-circle me-2"></i>Catat Pengembalian Buku</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><i class="bi bi-exclamation-triangle me-2"></i><?= $error ?></div>
                <?php endif; ?>

                <?php if (empty($peminjamanAktif)): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>Tidak ada peminjaman aktif yang perlu dikembalikan.
                    </div>
                    <a href="<?= App::BASE_URL ?>/index.php?page=pengembalian" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                <?php else: ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="peminjaman_id" class="form-label">Peminjaman <span class="text-danger">*</span></label>
                            <select class="form-select" id="peminjaman_id" name="peminjaman_id" required onchange="updateDendaInfo()">
                                <option value="">-- Pilih Peminjaman --</option>
                                <?php foreach ($peminjamanAktif as $p): ?>
                                    <option value="<?= $p->id ?>" data-tanggal-kembali="<?= $p->tanggal_kembali ?>" data-nama="<?= htmlspecialchars($p->nama_lengkap) ?>" data-buku="<?= htmlspecialchars($p->judul) ?>" data-tgl-pinjam="<?= $p->tanggal_pinjam ?>" <?= (isset($_POST['peminjaman_id']) && $_POST['peminjaman_id'] == $p->id) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($p->nama_lengkap) ?> - <?= htmlspecialchars($p->judul) ?> (<?= date('d/m/Y', strtotime($p->tanggal_pinjam)) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Info Peminjaman -->
                        <div id="info_peminjaman" class="alert alert-light border mb-3" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="d-block text-muted">Tanggal Pinjam</small>
                                    <strong id="display_tgl_pinjam">-</strong>
                                </div>
                                <div class="col-md-6">
                                    <small class="d-block text-muted">Tanggal Kembali (Target)</small>
                                    <strong id="display_tgl_kembali">-</strong>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" value="<?= htmlspecialchars($_POST['tanggal_pengembalian'] ?? date('Y-m-d')) ?>" required onchange="updateDendaInfo()">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="denda" class="form-label">Denda (Rp) <small class="text-muted">- Otomatis</small></label>
                                <input type="number" class="form-control" id="denda" name="denda" value="<?= htmlspecialchars($_POST['denda'] ?? '0') ?>" min="0" readonly style="background-color: #f8f9fa;">
                            </div>
                        </div>

                        <!-- Info Keterlambatan -->
                        <div id="info_keterlambatan" class="alert alert-warning" style="display: none;">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            <strong id="text_keterlambatan"></strong>
                            <div id="detail_keterlambatan" class="mt-2"></div>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Catatan tambahan (opsional)"><?= htmlspecialchars($_POST['keterangan'] ?? '') ?></textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan Pengembalian</button>
                            <a href="<?= App::BASE_URL ?>/index.php?page=pengembalian" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    const DENDA_PER_HARI = 5000; // Rp 5000 per hari

    function formatCurrency(value) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(value);
    }

    function formatDate(dateStr) {
        const date = new Date(dateStr + 'T00:00:00');
        return date.toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    function calculateDays(date1Str, date2Str) {
        const date1 = new Date(date1Str + 'T00:00:00');
        const date2 = new Date(date2Str + 'T00:00:00');
        const diffTime = Math.abs(date2 - date1);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        return diffDays;
    }

    function updateDendaInfo() {
        const peminjamanSelect = document.getElementById('peminjaman_id');
        const tanggalPengembalian = document.getElementById('tanggal_pengembalian').value;
        const dendaInput = document.getElementById('denda');
        const infoKeterlambatan = document.getElementById('info_keterlambatan');
        const textKeterlambatan = document.getElementById('text_keterlambatan');
        const detailKeterlambatan = document.getElementById('detail_keterlambatan');
        const infoPeminjaman = document.getElementById('info_peminjaman');

        const selectedOption = peminjamanSelect.options[peminjamanSelect.selectedIndex];
        
        if (selectedOption.value === '') {
            infoKeterlambatan.style.display = 'none';
            infoPeminjaman.style.display = 'none';
            dendaInput.value = '0';
            return;
        }

        const tanggalKembaliTarget = selectedOption.dataset.tanggalKembali;
        const tglPinjam = selectedOption.dataset.tglPinjam;
        
        // Tampilkan info peminjaman
        document.getElementById('display_tgl_pinjam').textContent = formatDate(tglPinjam);
        document.getElementById('display_tgl_kembali').textContent = formatDate(tanggalKembaliTarget);
        infoPeminjaman.style.display = 'block';

        if (tanggalPengembalian === '') {
            infoKeterlambatan.style.display = 'none';
            dendaInput.value = '0';
            return;
        }

        // Hitung selisih hari
        const hariTerlambat = calculateDays(tanggalKembaliTarget, tanggalPengembalian);
        
        if (hariTerlambat > 0) {
            const denda = hariTerlambat * DENDA_PER_HARI;
            dendaInput.value = denda;
            
            // Tampilkan peringatan keterlambatan
            textKeterlambatan.textContent = `Keterlambatan: ${hariTerlambat} hari`;
            detailKeterlambatan.innerHTML = `
                <small>
                    <div>Target kembali: ${formatDate(tanggalKembaliTarget)}</div>
                    <div>Dikembalikan: ${formatDate(tanggalPengembalian)}</div>
                    <div class="mt-2"><strong>Denda otomatis: ${formatCurrency(denda)} @ Rp ${DENDA_PER_HARI.toLocaleString('id-ID')}/hari</strong></div>
                </small>
            `;
            infoKeterlambatan.style.display = 'block';
        } else {
            dendaInput.value = '0';
            infoKeterlambatan.style.display = 'none';
        }
    }

    // Inisialisasi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        updateDendaInfo();
    });
</script>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
