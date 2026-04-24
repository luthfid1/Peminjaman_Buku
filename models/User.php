<?php

require_once __DIR__ . '/../config/Database.php';

class User
{
    private $db;
    private $table = 'users';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function getAllSiswa()
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE role = 'siswa' ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (username, password, nama_lengkap, role) VALUES (:username, :password, :nama_lengkap, :role)");
        return $stmt->execute([
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'nama_lengkap' => $data['nama_lengkap'],
            'role' => $data['role']
        ]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} SET username = :username, nama_lengkap = :nama_lengkap, role = :role";
        $params = [
            'id' => $id,
            'username' => $data['username'],
            'nama_lengkap' => $data['nama_lengkap'],
            'role' => $data['role']
        ];

        if (!empty($data['password'])) {
            $sql .= ", password = :password";
            $params['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $sql .= " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
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

    public function countSiswa()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE role = 'siswa'");
        return $stmt->fetch()->total;
    }

    public function verifyPassword($inputPassword, $dbPassword)
    {
        // Jika password di database sudah di-hash (format bcrypt mulai dengan $2)
        if (strpos($dbPassword, '$2') === 0) {
            return password_verify($inputPassword, $dbPassword);
        }
        // Jika password plain text (fallback untuk data lama)
        return $inputPassword === $dbPassword;
    }
}
