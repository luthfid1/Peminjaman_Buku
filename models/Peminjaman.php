<?php

require_once __DIR__ . '/../config/Database.php';

class Peminjaman
{
    private $db;
    private $table = 'peminjaman';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT p.*, u.nama_lengkap, u.username, b.judul FROM {$this->table} p JOIN users u ON p.user_id = u.id JOIN buku b ON p.buku_id = b.id ORDER BY p.id DESC");
        return $stmt->fetchAll();
    }

    public function getByUserId($userId)
    {
        $stmt = $this->db->prepare("SELECT p.*, b.judul, b.pengarang FROM {$this->table} p JOIN buku b ON p.buku_id = b.id WHERE p.user_id = :user_id ORDER BY p.id DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT p.*, u.nama_lengkap, u.username, b.judul FROM {$this->table} p JOIN users u ON p.user_id = u.id JOIN buku b ON p.buku_id = b.id WHERE p.id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (user_id, buku_id, tanggal_pinjam, tanggal_kembali, status) VALUES (:user_id, :buku_id, :tanggal_pinjam, :tanggal_kembali, 'pengajuan')");
        $result = $stmt->execute([
            'user_id' => $data['user_id'],
            'buku_id' => $data['buku_id'],
            'tanggal_pinjam' => $data['tanggal_pinjam'],
            'tanggal_kembali' => $data['tanggal_kembali']
        ]);

        // Kurangi stok buku saat peminjaman dibuat
        if ($result) {
            $stmtStok = $this->db->prepare("UPDATE buku SET jumlah_stok = jumlah_stok - 1 WHERE id = :id AND jumlah_stok > 0");
            $stmtStok->execute(['id' => $data['buku_id']]);
        }

        return $result;
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET user_id = :user_id, buku_id = :buku_id, tanggal_pinjam = :tanggal_pinjam, tanggal_kembali = :tanggal_kembali, status = :status WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'user_id' => $data['user_id'],
            'buku_id' => $data['buku_id'],
            'tanggal_pinjam' => $data['tanggal_pinjam'],
            'tanggal_kembali' => $data['tanggal_kembali'],
            'status' => $data['status']
        ]);
    }

    public function updateStatus($id, $status)
    {
        // Stok sudah dikurangi saat create(), jadi tidak perlu kurangi lagi di sini
        // Langsung update status saja
        $stmt = $this->db->prepare("UPDATE {$this->table} SET status = :status WHERE id = :id");
        return $stmt->execute(['id' => $id, 'status' => $status]);
    }

    public function rejectPeminjaman($id)
    {
        // Get data peminjaman
        $peminjaman = $this->getById($id);
        if (!$peminjaman || $peminjaman->status !== 'pengajuan') {
            return false;
        }

        // Kembalikan stok buku karena sudah dikurangi saat create()
        $stmtStok = $this->db->prepare("UPDATE buku SET jumlah_stok = jumlah_stok + 1 WHERE id = :id");
        $stmtStok->execute(['id' => $peminjaman->buku_id]);

        // Update status jadi ditolak
        $stmt = $this->db->prepare("UPDATE {$this->table} SET status = 'ditolak' WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function delete($id)
    {
        // Kembalikan stok buku jika peminjaman belum dikembalikan
        $peminjaman = $this->getById($id);
        if ($peminjaman && in_array($peminjaman->status, ['pengajuan', 'disetujui', 'dipinjam'])) {
            $stmtStok = $this->db->prepare("UPDATE buku SET jumlah_stok = jumlah_stok + 1 WHERE id = :id");
            $stmtStok->execute(['id' => $peminjaman->buku_id]);
        }

        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function count()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        return $stmt->fetch()->total;
    }

    public function countActive()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE status = 'dipinjam'");
        return $stmt->fetch()->total;
    }

    public function getActivePinjaman()
    {
        $stmt = $this->db->query("SELECT p.*, u.nama_lengkap, b.judul FROM {$this->table} p JOIN users u ON p.user_id = u.id JOIN buku b ON p.buku_id = b.id WHERE p.status = 'dipinjam' ORDER BY p.id DESC");
        return $stmt->fetchAll();
    }

    /**
     * Cek apakah peminjaman terlambat
     * @param int $id ID peminjaman
     * @return array ['terlambat' => bool, 'hari_terlambat' => int, 'status_text' => string]
     */
    public function checkIfLate($id)
    {
        $peminjaman = $this->getById($id);
        if (!$peminjaman) {
            return ['terlambat' => false, 'hari_terlambat' => 0, 'status_text' => 'Tidak ditemukan'];
        }

        $today = strtotime(date('Y-m-d'));
        $tanggalKembali = strtotime($peminjaman->tanggal_kembali);
        
        $hariTerlambat = max(0, ceil(($today - $tanggalKembali) / (60 * 60 * 24)));
        $terlambat = $hariTerlambat > 0 && $peminjaman->status === 'dipinjam';

        if ($terlambat) {
            $statusText = $hariTerlambat === 1 ? '1 hari terlambat' : $hariTerlambat . ' hari terlambat';
        } elseif ($peminjaman->status === 'dikembalikan') {
            $statusText = 'Sudah dikembalikan';
        } else {
            $statusText = 'Tepat waktu';
        }

        return [
            'terlambat' => $terlambat,
            'hari_terlambat' => $hariTerlambat,
            'status_text' => $statusText
        ];
    }

    /**
     * Mendapatkan semua peminjaman dengan info keterlambatan
     * @return array
     */
    public function getAllWithLateInfo()
    {
        $stmt = $this->db->query("SELECT p.*, u.nama_lengkap, u.username, b.judul,
            CASE 
                WHEN p.status = 'dipinjam' AND CURDATE() > p.tanggal_kembali THEN DATEDIFF(CURDATE(), p.tanggal_kembali)
                ELSE 0
            END as hari_terlambat,
            CASE 
                WHEN p.status = 'dipinjam' AND CURDATE() > p.tanggal_kembali THEN DATEDIFF(CURDATE(), p.tanggal_kembali) * 5000
                ELSE 0
            END as estimasi_denda
            FROM {$this->table} p 
            JOIN users u ON p.user_id = u.id 
            JOIN buku b ON p.buku_id = b.id 
            ORDER BY p.id DESC");
        return $stmt->fetchAll();
    }
}