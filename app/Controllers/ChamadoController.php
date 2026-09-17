<?php

class ChamadoController
{
    public function __construct(
        private Chamado $chamados,
        private Usuario $usuario,
        private Database $db
    ) {}

    public function criar(): void
    {
        if (!Security::checkCsrf($_POST['csrf'] ?? null)) {
            die('Requisição inválida.');
        }

        $posto = input('posto_graduacao');
        $nome = input('nome_guerra');
        $secao = input('secao');
        $descricao = input('descricao');
        $prioridade = input('prioridade', 'BAIXA');

        if ($posto === '' || $nome === '' || $secao === '' || $descricao === '') {
            die('Preencha todos os campos.');
        }

        $permitidas = ['BAIXA', 'MEDIA', 'ALTA', 'CRITICA'];

        if (!in_array($prioridade, $permitidas, true)) {
            $prioridade = 'BAIXA';
        }

        $token = Security::userToken();
        $hash = Security::tokenHash($token);

        $protocolo = 'SGI-' . strtoupper(bin2hex(random_bytes(6)));

        $dados = [
            'protocolo' => $protocolo,
            'nome_guerra' => $nome,
            'posto_graduacao' => $posto,
            'secao' => $secao,
            'ip_solicitante' => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0',
            'identificador_cookie' => $hash,
            'descricao' => $descricao,
            'prioridade' => $prioridade
        ];

        $anterior = $this->chamados->semelhante($dados);

        if ($anterior) {
            $dados['nome_guerra'] = $anterior['nome_guerra'];
            $dados['posto_graduacao'] = $anterior['posto_graduacao'];
            $dados['secao'] = $anterior['secao'];
        }

        $this->db->begin();

        try {
            $usuario = $this->usuario->buscar([
                'nome_guerra' => $dados['nome_guerra'],
                'posto_graduacao' => $dados['posto_graduacao'],
                'secao' => $dados['secao']
            ]);

            if (!$usuario) {
                $usuarioId = $this->usuario->criar([
                    'identificador_cookie' => $hash,
                    'nome_guerra' => $dados['nome_guerra'],
                    'posto_graduacao' => $dados['posto_graduacao'],
                    'secao' => $dados['secao'],
                    'ip_ultimo_acesso' => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'
                ]);
            } else {
                $usuarioId = (int) $usuario['id'];
            }

            $dados['usuario_id'] = $usuarioId;

            $this->chamados->criar($dados);

            $this->db->commit();
        } catch (Throwable $e) {
            $this->db->rollback();
            throw $e;
        }

        redirect(
            'index.php?rota=usuario&protocolo=' . urlencode($protocolo)
        );
    }
}
