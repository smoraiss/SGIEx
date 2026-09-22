<?php

require __DIR__ . '../../app/Core/helpers.php';
require __DIR__ . '../../app/Core/Database.php';
require __DIR__ . '../../app/Core/Security.php';

require __DIR__ . '../../app/Models/Chamado.class.php';
require __DIR__ . '../../app/Models/Usuario.class.php';
require __DIR__ . '../../app/Models/Administrador.class.php';

require __DIR__ . '../../app/Controllers/ChamadoController.php';
require __DIR__ . '../../app/Controllers/AdminController.php';

require __DIR__ . '../../config/Ferramentas.class.php';

Security::start();
$db = new Database();
$chamados = new Chamado($db);
$usuario = new Usuario($db);
$admins = new Administrador($db);
$ferramentas = new Ferramentas($db);
$rota = $_GET['rota'] ?? 'home';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $acao = $_POST['acao'] ?? '';

    $controller = new ChamadoController($chamados, $usuario,$db, $ferramentas);
    
    $admin = new AdminController($admins, $chamados);

    match ($acao) {
        'criar_chamado'     => $controller->criar(),
        'login'             => $admin->login(),
        'logout'            => $admin->logout(),
        'atualizar_chamado' => $admin->atualizarChamado(),
        'criar_admin'       => $admin->criarAdmin(),
        'status_admin'      => $admin->statusAdmin(),
        default             => die('Ação inválida.')
    };
}

if ($rota === 'usuario') {
    $protocolo = trim((string) ($_GET['protocolo'] ?? ''));

    $chamado = $protocolo !== ''
        ? $chamados->porProtocolo($protocolo) : null;

    if (!$chamado) {
        die('Chamado não encontrado.');
    }

    $token = Security::tokenHash(Security::userToken());

    /*if (!hash_equals($chamado['identificador_cookie'], $token)) {
        die('Acesso negado.');
    }*/

    $usuarioAtual = $usuario->buscar([
        'ip_ultimo_acesso' => $chamado['ip_solicitante']
    ]);

    if (!$usuarioAtual) {
        die('Usuário não encontrado.');
    }

    $meus = $chamados->doUsuario((int) $usuarioAtual['id']);
    

    require __DIR__ . '/../views/usuario.php';
    exit;
}
if ($rota === 'login') {
    require __DIR__ . '../../views/admin/login.php';
    exit;
}
if ($rota === 'login_usuario') {

    $usuarioAtual = $usuario->buscar([
        'ip_ultimo_acesso' => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'
    ]);

    if (!$usuarioAtual) {
        die('Usuário não encontrado.');
    }

    $meus = $chamados->doUsuario((int) $usuarioAtual['id']);

       
    require __DIR__ . '../../views/usuario.php';
    exit;
}
if ($rota === 'admin') {
    if (!Security::admin()) {
        redirect('index.php?rota=login');
    }
    $lista = $chamados->todos();
    $adminsLista = $admins->todos();
    require __DIR__ . '../../views/admin/dashboard.php';
    exit;
}
require __DIR__ . '../../views/home.php';

?>