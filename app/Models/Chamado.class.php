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
                    identificador_cookie,
                    descricao,
                    prioridade
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $this->db->query(
            $sql,
            'issssssss',
            [
                $d['usuario_id'],
                $d['protocolo'],
                $d['nome_guerra'],
                $d['posto_graduacao'],
                $d['secao'],
                $d['ip_solicitante'],
                $d['identificador_cookie'],
                $d['descricao'],
                $d['prioridade']
            ]
        );

        return $this->db->insertId();
    }

    public function semelhante(array $d): ?array
    {
        $sql = 'SELECT *
                FROM chamados
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

    public function porId(int $id): ?array
    { //busca chamado por id
        $r = $this->db->query('SELECT * FROM chamados WHERE id = ?', 'i', [$id]);
        return $r->fetch_assoc() ?: null;
    }

    public function porProtocolo(string $protocolo): ?array
    { //busca chamado por protocolo
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
    { //buscar todos os chamados: admin
        $r = $this->db->query('SELECT * FROM chamados ORDER BY data_abertura DESC');
        return $r->fetch_all(MYSQLI_ASSOC);
    }

    public function atualizar(int $id, string $status, string $prioridade): void
    { //atualizar chamados
        $this->db->query('UPDATE chamados SET status = ?, prioridade = ?, data_fechamento = CASE WHEN ? = \'FECHADO\' THEN NOW() ELSE NULL END WHERE id = ?', 'sssi', [$status, $prioridade, $status, $id]);
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
