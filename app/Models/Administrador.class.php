<?php
class Administrador {
    public function __construct(private Database $db) {}
    public function porUsuario(string $usuario): ?array {
        $r = $this->db->query('SELECT * FROM administrador WHERE usuario = ? AND ativo = 1 LIMIT 1', 's', [$usuario]);
        return $r->fetch_assoc() ?: null;
    }
    public function todos(): array {
        $r = $this->db->query('SELECT id, usuario, nome, ativo, data_criacao FROM administrador ORDER BY nome');
        return $r->fetch_all(MYSQLI_ASSOC);
    }
    public function criar(string $usuario, string $senha, string $nome): void {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $this->db->query('INSERT INTO administrador (usuario, senha, nome) VALUES (?, ?, ?)', 'sss', [$usuario,$hash,$nome]);
    }
    public function status(int $id, int $ativo): void { $this->db->query('UPDATE administrador SET ativo = ? WHERE id = ?', 'ii', [$ativo,$id]); }
}
