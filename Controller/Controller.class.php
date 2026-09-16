<?php
require_once('../Model/Manager.class.php');
$manager = new Manager();
$acao = $_REQUEST['acao'] ?? '';
switch ($acao) {
    case 'inserirChamado':
        require_once('../Model/Ferramentas.class.php');
        $Ferramentas = new Ferramentas();

        $nomeGuerra = $_REQUEST['nome_guerra'] ?? '';
        $postoGraduacao = $_REQUEST['posto_graduacao'] ?? '';
        $secao = $_REQUEST['secao'] ?? '';
        $descricao = $_REQUEST['descricao'] ?? '';
        $prioridade = $_REQUEST['prioridade'] ?? 'BAIXA';
        $ipSolicitante = $manager->getClientIP();

        if (!isset($_COOKIE['pals_usuario'])) {
            $identificadorCookie = bin2hex(random_bytes(32));

            setcookie('pals_usuario', $identificadorCookie, [
                'expires' => time() + (86400 * 365),
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
        } else {
            $identificadorCookie = $_COOKIE['pals_usuario'];
        }

        $protocolo = date('YmdHis') . rand(100, 999);
        $key = "Converter";
        $dados = [
            'protocolo' => $Ferramentas->criptografar($protocolo, $key),
            'nome_guerra' => $Ferramentas->criptografar($nomeGuerra, $key),
            'posto_graduacao' => $Ferramentas->criptografar($postoGraduacao, $key),
            'secao' => $Ferramentas->criptografar($secao, $key),
            'ip_solicitante' => $Ferramentas->criptografar($ipSolicitante, $key),
            'identificador_cookie' => $Ferramentas->criptografar($identificadorCookie, $key),
            'descricao' => $Ferramentas->criptografar($descricao, $key),
            'prioridade' => $Ferramentas->criptografar($prioridade, $key)
        ];
        $retChamado = $manager->inserirChamado($dados);

        if ($retChamado['result'] == 1) {
            $idChamado = $retChamado['id'];
            $dadosUsuario = [
                'identificador_cookie' => $dados['identificador_cookie'],
                'nome_guerra' => $dados['nome_guerra'],
                'posto_graduacao' => $dados['posto_graduacao'],
                'secao' => $dados['secao'],
                'ip_solicitante' => $dados['ip_solicitante']
            ];
            $retUsuario = $manager->inserirOuAtualizarUser($dadosUsuario);
            if ($retUsuario['result'] == 1) {
                $idUsuario = $retUsuario['id'];
                $retVinculo = $manager->vincularUsuarioChamado(
                    $idChamado,
                    $idUsuario
                );
                if ($retVinculo['result'] == 1) {
                    ?>
                    
                    <form action="../View/usuario.php" method="POST" id="index">
                        <input type="hidden" name="ptc" value="<?php echo $Ferramentas->criptografar($protocolo, $key) ?>">
                    </form>
                    <script>
                        document.getElementById("index").submit()
                    </script>
                    <?php
                }
            }
        } else {
            header("Location: ../index.php?erro=1");
        }
        exit;
    case 'admNew':

        $dados = [
            'usuario' => $_REQUEST['usuario'] ?? '',
            'senha' => $_REQUEST['senha'] ?? '',
            'nome' => $_REQUEST['nome'] ?? '',
            'ativo' => $_REQUEST['ativo'] ?? 1,
            'pfp' => $_REQUEST['pfp'] ?? ''
        ];

        $resultado = $manager->admNew($dados);

        if ($resultado['result'] == 1) {
            header("Location: ../admin/index.php?sucesso=1");
        } else {
            header("Location: ../admin/index.php?erro=1");
        }

        exit;


    case 'admExcluir':

        $id = $_REQUEST['id'] ?? 0;

        if (!is_numeric($id) || $id <= 0) {
            header("Location: ../admin/index.php?erro=1");
            exit;
        }

        $resultado = $manager->admExcluir((int) $id);

        if ($resultado['result'] == 1) {
            header("Location: ../admin/index.php?sucesso=1");
        } else {
            header("Location: ../admin/index.php?erro=1");
        }

        exit;


    case 'admUpdate':

        $dados = [
            'id' => $_REQUEST['id'] ?? 0,
            'usuario' => $_REQUEST['usuario'] ?? '',
            'nome' => $_REQUEST['nome'] ?? '',
            'ativo' => $_REQUEST['ativo'] ?? 1,
            'pfp' => $_REQUEST['pfp'] ?? ''
        ];

        $resultado = $manager->admUpdate($dados);

        if ($resultado['result'] == 1) {
            header("Location: ../admin/index.php?sucesso=1");
        } else {
            header("Location: ../admin/index.php?erro=1");
        }

        exit;


    case 'admLogin':

        $dados = [
            'usuario' => $_REQUEST['usuario'] ?? '',
            'senha' => $_REQUEST['senha'] ?? ''
        ];

        $resultado = $manager->admLogin($dados);

        if ($resultado['result'] == 1) {
            session_start();

            $_SESSION['admin_id'] = $resultado['id'];
            $_SESSION['admin_usuario'] = $resultado['usuario'];
            $_SESSION['admin_nome'] = $resultado['nome'];
            $_SESSION['admin_pfp'] = $resultado['pfp'];

            header("Location: ../admin/index.php");
        } else {
            header("Location: ../admin/login.php?erro=1");
        }

        exit;


    default:

        http_response_code(400);
        echo "Ação inválida.";

        exit;
}
