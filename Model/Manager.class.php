<?php

require_once('Conexao.class.php');

class Manager extends Conexao
{
    public function inserirChamado($dados)
{
    $conn = $this->connect();

    $sql = "INSERT INTO chamados (
                protocolo,
                nome_guerra,
                posto_graduacao,
                secao,
                ip_solicitante,
                identificador_cookie,
                descricao,
                prioridade
            ) VALUES (
                '{$dados["protocolo"]}',
                '{$dados["nome_guerra"]}',
                '{$dados["posto_graduacao"]}',
                '{$dados["secao"]}',
                '{$dados["ip_solicitante"]}',
                '{$dados["identificador_cookie"]}',
                '{$dados["descricao"]}',
                '{$dados["prioridade"]}'
            )";

    $res = $conn->query($sql);

    if ($res) {

        $idChamado = $conn->insert_id;

        $conn->close();

        return [
            'result' => 1,
            'id' => $idChamado
        ];
    }

    $conn->close();

    return [
        'result' => 0,
        'id' => null
    ];
}

public function vincularUsuarioChamado($idChamado, $idUsuario)
{
    $conn = $this->connect();

    $sql = "UPDATE chamados
            SET usuario_id = {$idUsuario}
            WHERE id = {$idChamado}";

    $res = $conn->query($sql);

    if ($res) {
        $conn->close();
        return ['result' => 1];
    }

    $conn->close();

    return ['result' => 0];
}

public function inserirOuAtualizarUser($dados)
{
    $conn = $this->connect();

    $sql = "SELECT id FROM Usuario 
            WHERE identificador_cookie = '{$dados["identificador_cookie"]}'";

    $res = $conn->query($sql);

    if ($res && $res->num_rows > 0) {

        // Usuário já existe
        $usuario = $res->fetch_assoc();
        $id = $usuario['id'];

        $sql = "UPDATE Usuario SET 
                    nome_guerra = '{$dados["nome_guerra"]}',
                    posto_graduacao = '{$dados["posto_graduacao"]}',
                    secao = '{$dados["secao"]}',
                    ip_ultimo_acesso = '{$dados["ip_solicitante"]}',
                    data_atualizacao = NOW()
                WHERE id = '{$id}'";

    } else {

        // Usuário novo
        $sql = "INSERT INTO Usuario 
                (identificador_cookie, nome_guerra, posto_graduacao, secao, ip_ultimo_acesso, data_atualizacao)
                VALUES (
                    '{$dados["identificador_cookie"]}',
                    '{$dados["nome_guerra"]}',
                    '{$dados["posto_graduacao"]}',
                    '{$dados["secao"]}',
                    '{$dados["ip_solicitante"]}',
                    NOW()
                )";
    }

    $res = $conn->query($sql);

    if ($res) {

        // Se foi INSERT, pega o ID recém-criado
        if (!isset($id)) {
            $id = $conn->insert_id;
        }

        $conn->close();

        return [
            'result' => 1,
            'id' => $id,
            'dados' => $dados
        ];
    }

    $conn->close();

    return [
        'result' => 0,
        'id' => null,
        'dados' => null
    ];
}

public function buscarUserPorId($id)
{
    $sql = "SELECT * FROM Usuario WHERE id = $id";

    $res = $this->connect()->query($sql);

    if ($res && $res->num_rows > 0) {
        $dados = $res->fetch_assoc();
        $this->connect()->close();
        return ['result' => 1, 'dados' => $dados];
    } else {
        $this->connect()->close();
        return ['result' => 0];
    }
}
public function chamadosPorUsuario($usuarioId)
{
    $sql = "SELECT * FROM chamados WHERE usuario_id = $usuarioId ORDER BY data_abertura DESC";

    $res = $this->connect()->query($sql);
    $dados = [];

    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $dados[] = $row;
        }
    }

    $this->connect()->close();
    return $dados;
}
    public function buscarChamadoPorId($id)
    {
        $sql = "SELECT * FROM chamados WHERE id = {$id};";

        $res = $this->connect()->query($sql);

        if (!$res) {
            $this->connect()->close();
            return ['result' => -1];
        }

        if ($res->num_rows > 0) {
            $dados = $res->fetch_assoc();
            $dados['result'] = 1;

            $this->connect()->close();
            return $dados;
        } else {
            $this->connect()->close();
            return ['result' => 0];
        }
    }

    public function buscarChamadoPorProtocolo($protocolo)
{
    $conn = $this->connect();

    $sql = "SELECT *
            FROM chamados
            WHERE protocolo = '{$protocolo}'
            LIMIT 1";

    $res = $conn->query($sql);

    if ($res && $res->num_rows > 0) {

        $dados = $res->fetch_assoc();

        $conn->close();

        return [
            'result' => 1,
            'dados' => $dados
        ];
    }

    $conn->close();

    return [
        'result' => 0,
        'dados' => null
    ];
}

    public function chamadosTable()
    {
        $sql = "SELECT * FROM chamados ORDER BY data_abertura DESC;";

        $res = $this->connect()->query($sql);

        if (!$res) {
            $this->connect()->close();
            return ['result' => -1];
        }

        if ($res->num_rows > 0) {
            $dados = [];
            $i = 0;

            while ($row = $res->fetch_assoc()) {
                $dados[$i] = [
                    'id' => $row['id'],
                    'protocolo' => $row['protocolo'],
                    'nome_guerra' => $row['nome_guerra'],
                    'posto_graduacao' => $row['posto_graduacao'],
                    'secao' => $row['secao'],
                    'ip_solicitante' => $row['ip_solicitante'],
                    'descricao' => $row['descricao'],
                    'status' => $row['status'],
                    'prioridade' => $row['prioridade'],
                    'data_abertura' => $row['data_abertura'],
                    'data_atualizacao' => $row['data_atualizacao'],
                    'data_fechamento' => $row['data_fechamento']
                ];

                $i++;
            }

            $dados['result'] = $i;

            $this->connect()->close();
            return $dados;
        } else {
            $this->connect()->close();
            return ['result' => 0];
        }
    }

    public function chamadosPorCookie($identificadorCookie)
    {
        $sql = "SELECT * FROM chamados WHERE identificador_cookie = '{$identificadorCookie}' ORDER BY data_abertura DESC;";

        $res = $this->connect()->query($sql);

        if (!$res) {
            $this->connect()->close();
            return ['result' => -1];
        }

        if ($res->num_rows > 0) {
            $dados = [];
            $i = 0;

            while ($row = $res->fetch_assoc()) {
                $dados[$i] = [
                    'id' => $row['id'],
                    'protocolo' => $row['protocolo'],
                    'nome_guerra' => $row['nome_guerra'],
                    'posto_graduacao' => $row['posto_graduacao'],
                    'secao' => $row['secao'],
                    'descricao' => $row['descricao'],
                    'status' => $row['status'],
                    'prioridade' => $row['prioridade'],
                    'data_abertura' => $row['data_abertura'],
                    'data_atualizacao' => $row['data_atualizacao'],
                    'data_fechamento' => $row['data_fechamento']
                ];

                $i++;
            }

            $dados['result'] = $i;

            $this->connect()->close();
            return $dados;
        } else {
            $this->connect()->close();
            return ['result' => 0];
        }
    }

    public function atualizarStatusChamado($id, $status)
    {
        $sql = "UPDATE chamados SET status = '{$status}' WHERE id = {$id};";

        $res = $this->connect()->query($sql);

        if ($res) {
            $this->connect()->close();
            return ['result' => 1];
        } else {
            $this->connect()->close();
            return ['result' => 0];
        }
    }

    public function atualizarPrioridadeChamado($id, $prioridade)
    {
        $sql = "UPDATE chamados SET prioridade = '{$prioridade}' WHERE id = {$id};";

        $res = $this->connect()->query($sql);

        if ($res) {
            $this->connect()->close();
            return ['result' => 1];
        } else {
            $this->connect()->close();
            return ['result' => 0];
        }
    }

    public function fecharChamado($id)
    {
        $sql = "UPDATE chamados SET status = 'FECHADO', data_fechamento = NOW() WHERE id = {$id};";

        $res = $this->connect()->query($sql);

        if ($res) {
            $this->connect()->close();
            return ['result' => 1];
        } else {
            $this->connect()->close();
            return ['result' => 0];
        }
    }

    public function inserirHistorico($dados)
    {
        $sql = "INSERT INTO historico_chamados (chamado_id, acao, descricao) VALUES ('{$dados["chamado_id"]}', '{$dados["acao"]}', '{$dados["descricao"]}')";

        $res = $this->connect()->query($sql);

        if ($res) {
            $this->connect()->close();
            return ['result' => 1];
        } else {
            $this->connect()->close();
            return ['result' => 0];
        }
    }

    public function historicoChamado($chamadoId)
    {
        $sql = "SELECT * FROM historico_chamados WHERE chamado_id = {$chamadoId} ORDER BY data_registro ASC;";

        $res = $this->connect()->query($sql);

        if (!$res) {
            $this->connect()->close();
            return ['result' => -1];
        }

        if ($res->num_rows > 0) {
            $dados = [];
            $i = 0;

            while ($row = $res->fetch_assoc()) {
                $dados[$i] = [
                    'id' => $row['id'],
                    'chamado_id' => $row['chamado_id'],
                    'acao' => $row['acao'],
                    'descricao' => $row['descricao'],
                    'data_registro' => $row['data_registro']
                ];

                $i++;
            }

            $dados['result'] = $i;

            $this->connect()->close();
            return $dados;
        } else {
            $this->connect()->close();
            return ['result' => 0];
        }
    }

    public function inserirComentario($dados)
    {
        $sql = "INSERT INTO comentarios_chamados (chamado_id, autor_tipo, autor_nome, comentario) VALUES ('{$dados["chamado_id"]}', '{$dados["autor_tipo"]}', '{$dados["autor_nome"]}', '{$dados["comentario"]}')";

        $res = $this->connect()->query($sql);

        if ($res) {
            $this->connect()->close();
            return ['result' => 1];
        } else {
            $this->connect()->close();
            return ['result' => 0];
        }
    }

    public function comentariosChamado($chamadoId)
    {
        $sql = "SELECT * FROM comentarios_chamados WHERE chamado_id = {$chamadoId} ORDER BY data_registro ASC;";

        $res = $this->connect()->query($sql);

        if (!$res) {
            $this->connect()->close();
            return ['result' => -1];
        }

        if ($res->num_rows > 0) {
            $dados = [];
            $i = 0;

            while ($row = $res->fetch_assoc()) {
                $dados[$i] = [
                    'id' => $row['id'],
                    'chamado_id' => $row['chamado_id'],
                    'autor_tipo' => $row['autor_tipo'],
                    'autor_nome' => $row['autor_nome'],
                    'comentario' => $row['comentario'],
                    'data_registro' => $row['data_registro']
                ];

                $i++;
            }

            $dados['result'] = $i;

            $this->connect()->close();
            return $dados;
        } else {
            $this->connect()->close();
            return ['result' => 0];
        }
    }

    public function admNew($dados)
    {
        $sql = "INSERT INTO administrador (usuario, senha, nome, ativo, pfp, data_criacao) VALUES ('{$dados["usuario"]}', '{$dados["senha"]}', '{$dados["nome"]}', '{$dados["ativo"]}', '{$dados["pfp"]}', NOW());";

        $res = $this->connect()->query($sql);

        if ($res) {
            $this->connect()->close();
            return ['result' => 1];
        } else {
            $this->connect()->close();
            return ['result' => 0];
        }
    }

    public function admLogin($dados)
    {
        $sql = "SELECT * FROM administrador WHERE usuario = '{$dados["usuario"]}' AND senha = '{$dados["senha"]}' AND ativo = 1;";

        $res = $this->connect()->query($sql);

        if (!$res) {
            $this->connect()->close();
            return ['result' => -1];
        }

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();

            $dados = [
                'result' => 1,
                'id' => $row['id'],
                'usuario' => $row['usuario'],
                'nome' => $row['nome'],
                'pfp' => $row['pfp'],
                'ativo' => $row['ativo']
            ];

            $this->connect()->close();
            return $dados;
        } else {
            $this->connect()->close();
            return ['result' => 0];
        }
    }

    public function admUpdate($dados)
    {
        $sql = "UPDATE administrador SET usuario = '{$dados["usuario"]}', nome = '{$dados["nome"]}', ativo = '{$dados["ativo"]}', pfp = '{$dados["pfp"]}' WHERE id = '{$dados["id"]}';";

        $res = $this->connect()->query($sql);

        if ($res) {
            $this->connect()->close();
            return ['result' => 1];
        } else {
            $this->connect()->close();
            return ['result' => 0];
        }
    }

    public function admExcluir($id)
    {
        $sql = "DELETE FROM administrador WHERE id = {$id};";

        $res = $this->connect()->query($sql);

        if ($res) {
            $this->connect()->close();
            return ['result' => 1];
        } else {
            $this->connect()->close();
            return ['result' => 0];
        }
    }

    public function admStatus($id, $ativo)
    {
        $sql = "UPDATE administrador SET ativo = {$ativo} WHERE id = {$id};";

        $res = $this->connect()->query($sql);

        if ($res) {
            $this->connect()->close();
            return ['result' => 1];
        } else {
            $this->connect()->close();
            return ['result' => 0];
        }
    }

    public function getClientIP()
    {
        $ipaddress = '';

        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        if ($ipaddress == '::1') {
            $ipaddress = '127.0.0.1';
        }

        return $ipaddress;
    }
}

?>