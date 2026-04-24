<?php

require_once __DIR__ . '/../config/Database.php';

class Pengembalian
{
    private $db;
    private $table = 'pengembalian';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT pg.*, p.tanggal_pinjam, p.tanggal_kembali, u.nama_lengkap, b.judul 
            FROM {$this->table} pg 
            JOIN peminjaman p ON pg.peminjaman_id = p.id 
            JOIN users u ON p.user_id = u.id 
            JOIN buku b ON p.buku_id = b.id 
            ORDER BY pg.id DESC");
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT pg.*, p.tanggal_pinjam, p.tanggal_kembali, p.buku_id, u.nama_lengkap, b.judul 
            FROM {$this->table} pg 
            JOIN peminjaman p ON pg.peminjaman_id = p.id 
            JOIN users u ON p.user_id = u.id 
            JOIN buku b ON p.buku_id = b.id 
            WHERE pg.id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (peminjaman_id, tanggal_pengembalian, denda, keterangan) VALUES (:peminjaman_id, :tanggal_pengembalian, :denda, :keterangan)");
        $result = $stmt->execute([
            'peminjaman_id' => $data['peminjaman_id'],
            'tanggal_pengembalian' => $data['tanggal_pengembalian'],
            'denda' => $data['denda'],
            'keterangan' => $data['keterangan']
        ]);

        // Update status peminjaman jadi dikembalikan & kembalikan stok
        if ($result) {
            $stmtUpdate = $this->db->prepare("UPDATE peminjaman SET status = 'dikembalikan' WHERE id = :id");
            $stmtUpdate->execute(['id' => $data['peminjaman_id']]);

            // Kembalikan stok buku
            $stmtPinjam = $this->db->prepare("SELECT buku_id FROM peminjaman WHERE id = :id");
            $stmtPinjam->execute(['id' => $data['peminjaman_id']]);
            $pinjam = $stmtPinjam->fetch();
            if ($pinjam) {
                $stmtStok = $this->db->prepare("UPDATE buku SET jumlah_stok = jumlah_stok + 1 WHERE id = :id");
                $stmtStok->execute(['id' => $pinjam->buku_id]);
            }
        }

        return $result;
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function count()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        return $stmt->fetch()->total;
    }

    /**
     * Menghitung denda berdasarkan keterlambatan
     * @param int $peminjamanId ID peminjaman
     * @param string $tanggalPengembalian Tanggal pengembalian aktual (format: YYYY-MM-DD)
     * @param int $dendaPerHari Denda per hari dalam Rupiah (default: 5000)
     * @return array ['hari_terlambat' => int, 'denda' => int]
     */
    public function calculateDenda($peminjamanId, $tanggalPengembalian, $dendaPerHari = 5000)
    {
        // Ambil data peminjaman
        $stmt = $this->db->prepare("SELECT tanggal_kembali FROM peminjaman WHERE id = :id");
        $stmt->execute(['id' => $peminjamanId]);
        $peminjaman = $stmt->fetch();

        if (!$peminjaman) {
            return ['hari_terlambat' => 0, 'denda' => 0];
        }

        $tanggalKembaliTarget = strtotime($peminjaman->tanggal_kembali);
        $tanggalKembaliAktual = strtotime($tanggalPengembalian);

        // Hitung selisih hari
        $hariTerlambat = max(0, ceil(($tanggalKembaliAktual - $tanggalKembaliTarget) / (60 * 60 * 24)));

        // Hitung denda
        $denda = $hariTerlambat > 0 ? $hariTerlambat * $dendaPerHari : 0;

        return [
            'hari_terlambat' => $hariTerlambat,
            'denda' => $denda
        ];
    }

    /**
     * Mendapatkan semua data pengembalian dengan informasi keterlambatan
     * @return array
     */
    public function getAllWithLateInfo()
    {
        $stmt = $this->db->query("SELECT pg.*, p.tanggal_pinjam, p.tanggal_kembali, u.nama_lengkap, b.judul,
            CASE 
                WHEN pg.tanggal_pengembalian > p.tanggal_kembali THEN DATEDIFF(pg.tanggal_pengembalian, p.tanggal_kembali)
                ELSE 0
            END as hari_terlambat
            FROM {$this->table} pg 
            JOIN peminjaman p ON pg.peminjaman_id = p.id 
            JOIN users u ON p.user_id = u.id 
            JOIN buku b ON p.buku_id = b.id 
            ORDER BY pg.id DESC");
        return $stmt->fetchAll();
    }

    /**
     * Mendapatkan peminjaman yang belum dikembalikan dengan estimasi denda keterlambatan
     * @return array
     */
    public function getPeminjamanBelumDikembalikan()
    {
        $stmt = $this->db->query("SELECT p.*, u.nama_lengkap, b.judul,
            CASE 
                WHEN p.status = 'dipinjam' AND CURDATE() > p.tanggal_kembali THEN DATEDIFF(CURDATE(), p.tanggal_kembali)
                ELSE 0
            END as hari_terlambat,
            CASE 
                WHEN p.status = 'dipinjam' AND CURDATE() > p.tanggal_kembali THEN DATEDIFF(CURDATE(), p.tanggal_kembali) * 5000
                ELSE 0
            END as estimasi_denda
            FROM peminjaman p 
            JOIN users u ON p.user_id = u.id 
            JOIN buku b ON p.buku_id = b.id 
            WHERE p.status = 'dipinjam'
            ORDER BY p.tanggal_kembali ASC");
        return $stmt->fetchAll();
    }
}
