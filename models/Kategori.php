<?php

require_once __DIR__ . '/../config/Database.php';

class Kategori
{
    private $db;
    private $table = 'kategori';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (nama_kategori) VALUES (:nama_kategori)");
        return $stmt->execute(['nama_kategori' => $data['nama_kategori']]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET nama_kategori = :nama_kategori WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'nama_kategori' => $data['nama_kategori']
        ]);
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
}
