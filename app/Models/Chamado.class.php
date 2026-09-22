<?php

class Chamado
{
    public function __construct(private Database $db) {}

    public function criar(array $d): int
    {
        $sql = 'INSERT INTO chamados (
                    usuario_id,
                    protocolo,
                    nome_guerra,
                    posto_graduacao,
                    secao,
                    ip_solicitante,
                    descricao,
                    prioridade
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

        $this->db->query(
            $sql,
            'isssssss',
            [
                $d['usuario_id'],
                $d['protocolo'],
                $d['nome_guerra'],
                $d['posto_graduacao'],
                $d['secao'],
                $d['ip_solicitante'],
                $d['descricao'],
                $d['prioridade']
            ]
        );

        return $this->db->insertId();
    }

    public function alterar(array $d): bool 
    {
        $sql = 'UPDATE chamados SET 
                    nome_guerra = ?,
                    posto_graduacao = ?,
                    secao = ?,
                    descricao = ?,
                    prioridade = ?,
                    data_atualizacao = ?
                WHERE protocolo = ?';

        $r = $this->db->query(
            $sql,
            'sssssss',
            [
                $d['nome_guerra'],
                $d['posto_graduacao'],
                $d['secao'],
                $d['descricao'],
                $d['prioridade'],
                $d['data_atualizacao'],
                $d['protocolo']
            ]
        );

        return (bool) $r;
    }

    public function excluir(string $protocolo): bool 
    {
        $sql = 'DELETE FROM chamados WHERE protocolo = ?';
        $r = $this->db->query($sql, 's', [$protocolo]);
        return (bool) $r;
    }

    public function semelhante(array $d): ?array
    {
        $sql = 'SELECT *
                FROM chamados
                WHERE posto_graduacao = ?
                AND secao = ?
                LIMIT 1';

        $r = $this->db->query(
            $sql,
            'ss',
            [
                $d['posto_graduacao'],
                $d['secao']
            ]
        );

        return $r->fetch_assoc() ?: null;
    }

    public function porId(int $id): ?array
    {
        $r = $this->db->query('SELECT * FROM chamados WHERE id = ?', 'i', [$id]);
        return $r->fetch_assoc() ?: null;
    }

    public function porProtocolo(string $protocolo): ?array
    {
        $r = $this->db->query('SELECT * FROM chamados WHERE protocolo = ? LIMIT 1', 's', [$protocolo]);
        return $r->fetch_assoc() ?: null;
    }

    public function doUsuario(int $usuarioId): array
    {
        $sql = 'SELECT *
            FROM chamados
            WHERE usuario_id = ?
            ORDER BY data_abertura DESC';

        $r = $this->db->query(
            $sql,
            'i',
            [$usuarioId]
        );

        return $r->fetch_all(MYSQLI_ASSOC);
    }

    public function todos(): array
    {
        $r = $this->db->query('SELECT * FROM chamados ORDER BY data_abertura DESC');
        return $r->fetch_all(MYSQLI_ASSOC);
    }

    public function atualizar(int $id, string $status, string $prioridade): void
    {
        $sql = 'UPDATE chamados 
                SET status = ?, 
                    prioridade = ?, 
                    data_fechamento = CASE WHEN ? = \'FECHADO\' THEN NOW() ELSE NULL END 
                WHERE id = ?';
                
        $this->db->query($sql, 'sssi', [$status, $prioridade, $status, $id]);
    }

    public function vincularUsuario(int $chamadoId, int $usuarioId): void
    {
        $sql = 'UPDATE chamados
            SET usuario_id = ?
            WHERE id = ?';

        $this->db->query(
            $sql,
            'ii',
            [$usuarioId, $chamadoId]
        );
    }
}