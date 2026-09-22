<?php
class Usuario
{
    public function __construct(private Database $db) {}

    public function buscar(array $d): ?array
    {
        $sql = 'SELECT * FROM usuario
                /* WHERE nome_guerra = ? */
                WHERE ip_ultimo_acesso = ?';

        $r = $this->db->query(
            $sql,
            's',
            [
                /* $d['nome_guerra'], */
                $d['ip_ultimo_acesso']
            ]
        );

        return $r->fetch_assoc() ?: null;
    }

    public function criar(array $d): int
    {
        $sql = 'INSERT INTO usuario (
                    /*identificador_cookie,*/
                    /* nome_guerra, */
                    posto_graduacao,
                    secao,
                    ip_ultimo_acesso
                ) VALUES (?, ?, ?)';

        $this->db->query(
            $sql,
            'sss',
            [
                /*$d['identificador_cookie'],*/
                /*$d['nome_guerra'],*/
                $d['posto_graduacao'],
                $d['secao'],
                $d['ip_ultimo_acesso']
            ]
        );

        return $this->db->insertId();
    }
   
}
