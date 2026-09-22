<?php
class AdminController {
    public function __construct(private Administrador $admins, private Chamado $chamados) {}
    public function login(): void {
        if (!Security::checkCsrf($_POST['csrf'] ?? null)) die('Requisição inválida.');
        $admin = $this->admins->porUsuario(input('usuario'));
        if (!$admin || !password_verify(input('senha'), $admin['senha'])) redirect('index.php?rota=login&erro=1');
        Security::login($admin); redirect('index.php?rota=admin');
    }
    public function logout(): void { Security::logout(); redirect('index.php?rota=login'); }
    public function atualizarChamado(): void {
        if (!Security::admin()) redirect('index.php?rota=login');
        if (!Security::checkCsrf($_POST['csrf'] ?? null)) die('Requisição inválida.');
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT); $status = input('status'); $prioridade = input('prioridade');
        if (!$id || !in_array($status, ['ABERTO','EM_ATENDIMENTO','AGUARDANDO_SOLICITANTE','RESOLVIDO','FECHADO','CANCELADO'], true) || !in_array($prioridade, ['BAIXA','MEDIA','ALTA','CRITICA'], true)) die('Dados inválidos.');
        $this->chamados->atualizar($id,$status,$prioridade); redirect('index.php?rota=admin&ok=1');
    }
    public function criarAdmin(): void {
        if (!Security::admin()) redirect('index.php?rota=login');
        if (!Security::checkCsrf($_POST['csrf'] ?? null)) die('Requisição inválida.');
        $usuario=input('usuario'); $senha=input('senha'); $nome=input('nome');
        if ($usuario === '' || strlen($senha) < 10 || $nome === '') die('Dados inválidos.');
        $this->admins->criar($usuario,$senha,$nome); redirect('index.php?rota=admin');
    }
    public function statusAdmin(): void {
        if (!Security::admin()) redirect('index.php?rota=login');
        if (!Security::checkCsrf($_POST['csrf'] ?? null)) die('Requisição inválida.');
        $id=filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT); $ativo=(int)($_POST['ativo'] ?? 0); if($id===false||$id===null||!in_array($ativo,[0,1],true)) die('Dados inválidos.');
        $this->admins->status($id,$ativo); redirect('index.php?rota=admin');
    }
}
