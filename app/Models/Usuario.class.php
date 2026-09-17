<?php
class Usuario
{
    public function __construct(private Database $db) {}

    public function buscar(array $d): ?array
    {
        $sql = 'SELECT * FROM usuario
                WHERE nome_guerra = ?
                AND posto_graduacao = ?
                AND secao = ?
                LIMIT 1';

        $r = $this->db->query(
            $sql,
            'sss',
            [
                $d['nome_guerra'],
                $d['posto_graduacao'],
                $d['secao']
            ]
        );

        return $r->fetch_assoc() ?: null;
    }

    public function criar(array $d): int
    {
        $sql = 'INSERT INTO usuario (
                    identificador_cookie,
                    nome_guerra,
                    posto_graduacao,
                    secao,
                    ip_ultimo_acesso
                ) VALUES (?, ?, ?, ?, ?)';

        $this->db->query(
            $sql,
            'sssss',
            [
                $d['identificador_cookie'],
                $d['nome_guerra'],
                $d['posto_graduacao'],
                $d['secao'],
                $d['ip_ultimo_acesso']
            ]
        );

        return $this->db->insertId();
    }
   
}
