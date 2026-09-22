<?php
class Database {
    private mysqli $db;

    public function __construct() {
        $c = require __DIR__ . '../../../config/config.php';
        $this->db = new mysqli($c['db']['host'], $c['db']['user'], $c['db']['pass'], $c['db']['name']);
        if ($this->db->connect_error) throw new RuntimeException('Falha na conexão com o banco.');
        $this->db->set_charset($c['db']['charset']);
    }

    public function query(string $sql, string $types = '', array $params = []): mysqli_result|bool {
        $stmt = $this->db->prepare($sql);
        if (!$stmt) throw new RuntimeException('Erro no banco.');
        if ($types !== '') $stmt->bind_param($types, ...$params);
        if (!$stmt->execute()) throw new RuntimeException('Erro no banco.');
        return $stmt->get_result() ?? true;
    }

    public function insertId(): int { return $this->db->insert_id; }
    public function begin(): void { $this->db->begin_transaction(); }
    public function commit(): void { $this->db->commit(); }
    public function rollback(): void { $this->db->rollback(); }
}
