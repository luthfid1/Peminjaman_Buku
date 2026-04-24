<?php

class ApiController
{
    public function getNotifications()
    {
        header('Content-Type: application/json');

        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['notifications' => [], 'count' => 0]);
            exit;
        }

        $notifications = [];
        $count = 0;

        // Get notifications based on user role
        if ($_SESSION['role'] === 'admin') {
            $notifications = $this->getAdminNotifications();
        } else {
            $notifications = $this->getStudentNotifications();
        }

        $count = count($notifications);

        echo json_encode([
            'notifications' => $notifications,
            'count' => $count
        ]);
        exit;
    }

    private function getAdminNotifications()
    {
        $db = new Database();
        $notifications = [];

        // Get new loan requests (status = 'pengajuan')
        $result = $db->query("
            SELECT p.id, p.user_id, b.judul, u.nama_lengkap, p.tanggal_pinjam, p.created_at
            FROM peminjaman p
            JOIN buku b ON p.buku_id = b.id
            JOIN users u ON p.user_id = u.id
            WHERE p.status = 'pengajuan'
            ORDER BY p.created_at DESC
            LIMIT 10
        ");

        while ($row = $result->fetch_assoc()) {
            $notifications[] = [
                'id' => 'loan_request_' . $row['id'],
                'title' => 'Ajuan Peminjaman Baru',
                'message' => $row['nama_lengkap'] . ' mengajukan peminjaman "' . $row['judul'] . '"',
                'type' => 'primary',
                'icon' => 'bi bi-file-earmark-text',
                'time' => 'Tanggal pinjam: ' . date('d M Y', strtotime($row['tanggal_pinjam'])),
                'read' => false,
                'action_url' => 'index.php?page=peminjaman'
            ];
        }

        // Get due date loans (loans that will be due in 3 days)
        $today = date('Y-m-d');
        $threeDaysFromNow = date('Y-m-d', strtotime('+3 days'));

        $result = $db->query("
            SELECT p.id, p.user_id, b.judul, p.tanggal_kembali, u.nama_lengkap
            FROM peminjaman p
            JOIN buku b ON p.buku_id = b.id
            JOIN users u ON p.user_id = u.id
            WHERE p.status = 'dipinjam'
            AND p.tanggal_kembali BETWEEN ? AND ?
            ORDER BY p.tanggal_kembali ASC
            LIMIT 5
        ", [$today, $threeDaysFromNow]);

        while ($row = $result->fetch_assoc()) {
            $daysLeft = intval((strtotime($row['tanggal_kembali']) - time()) / 86400);
            if ($daysLeft <= 0) {
                $daysLeft = 0;
            }
            
            $notifications[] = [
                'id' => 'overdue_' . $row['id'],
                'title' => 'Buku akan jatuh tempo',
                'message' => $row['nama_lengkap'] . ' meminjam "' . $row['judul'] . '" akan jatuh tempo dalam ' . ($daysLeft == 0 ? 'hari ini' : $daysLeft . ' hari'),
                'type' => $daysLeft == 0 ? 'danger' : 'warning',
                'icon' => 'bi bi-exclamation-circle',
                'time' => 'Jatuh tempo: ' . date('d M Y', strtotime($row['tanggal_kembali'])),
                'read' => false
            ];
        }

        // Get new registrations (last 24 hours)
        $result = $db->query("
            SELECT COUNT(*) as count
            FROM users
            WHERE role = 'siswa'
            AND created_at >= DATE_SUB(NOW(), INTERVAL 1 DAY)
        ");

        $row = $result->fetch_assoc();
        if ($row['count'] > 0) {
            $notifications[] = [
                'id' => 'new_users_' . time(),
                'title' => 'Anggota Baru',
                'message' => 'Ada ' . $row['count'] . ' anggota baru bergabung dalam 24 jam terakhir',
                'type' => 'info',
                'icon' => 'bi bi-person-plus',
                'time' => 'Baru saja',
                'read' => false
            ];
        }

        // Get overdue loans
        $result = $db->query("
            SELECT COUNT(*) as count
            FROM peminjaman
            WHERE status = 'dipinjam'
            AND tanggal_kembali < DATE(NOW())
        ");

        $row = $result->fetch_assoc();
        if ($row['count'] > 0) {
            $notifications[] = [
                'id' => 'overdue_loans_' . time(),
                'title' => 'Peminjaman Sudah Jatuh Tempo',
                'message' => 'Ada ' . $row['count'] . ' peminjaman yang sudah melewati tanggal kembali',
                'type' => 'danger',
                'icon' => 'bi bi-exclamation-triangle',
                'time' => 'Perlu perhatian segera',
                'read' => false
            ];
        }

        return $notifications;
    }

    private function getStudentNotifications()
    {
        $db = new Database();
        $notifications = [];
        $userId = $_SESSION['user_id'];

        // Get user's active loans with due dates
        $today = date('Y-m-d');
        $threeDaysFromNow = date('Y-m-d', strtotime('+3 days'));

        $result = $db->query("
            SELECT p.id, b.judul, p.tanggal_kembali
            FROM peminjaman p
            JOIN buku b ON p.buku_id = b.id
            WHERE p.user_id = ?
            AND p.status = 'dipinjam'
            AND p.tanggal_kembali BETWEEN ? AND ?
            ORDER BY p.tanggal_kembali ASC
            LIMIT 5
        ", [$userId, $today, $threeDaysFromNow]);

        while ($row = $result->fetch_assoc()) {
            $daysLeft = intval((strtotime($row['tanggal_kembali']) - time()) / 86400);
            if ($daysLeft <= 0) {
                $daysLeft = 0;
            }

            $notifications[] = [
                'id' => 'student_loan_' . $row['id'],
                'title' => 'Buku akan jatuh tempo',
                'message' => '"' . $row['judul'] . '" akan jatuh tempo dalam ' . ($daysLeft == 0 ? 'hari ini' : $daysLeft . ' hari'),
                'type' => $daysLeft == 0 ? 'danger' : 'warning',
                'icon' => 'bi bi-exclamation-circle',
                'time' => 'Jatuh tempo: ' . date('d M Y', strtotime($row['tanggal_kembali'])),
                'read' => false
            ];
        }

        // Check for overdue loans
        $result = $db->query("
            SELECT COUNT(*) as count
            FROM peminjaman
            WHERE user_id = ?
            AND status = 'dipinjam'
            AND tanggal_kembali < DATE(NOW())
        ", [$userId]);

        $row = $result->fetch_assoc();
        if ($row['count'] > 0) {
            $notifications[] = [
                'id' => 'student_overdue_' . time(),
                'title' => 'Buku Sudah Jatuh Tempo',
                'message' => 'Anda memiliki ' . $row['count'] . ' buku yang sudah melewati tanggal kembali',
                'type' => 'danger',
                'icon' => 'bi bi-exclamation-triangle',
                'time' => 'Perlu dikembalikan segera',
                'read' => false
            ];
        }

        // Check for approved loans waiting for pickup
        $result = $db->query("
            SELECT COUNT(*) as count
            FROM peminjaman
            WHERE user_id = ?
            AND status = 'disetujui'
        ", [$userId]);

        $row = $result->fetch_assoc();
        if ($row['count'] > 0) {
            $notifications[] = [
                'id' => 'approved_loans_' . time(),
                'title' => 'Buku Siap Diambil',
                'message' => 'Ada ' . $row['count'] . ' buku yang siap diambil di perpustakaan',
                'type' => 'success',
                'icon' => 'bi bi-check-circle',
                'time' => 'Menunggu pengambilan',
                'read' => false
            ];
        }

        return $notifications;
    }
}
