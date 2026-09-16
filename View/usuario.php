<?php

require_once('../Model/Manager.class.php');
require_once('../Model/Ferramentas.class.php');

$manager = new Manager();
$ferramentas = new Ferramentas();

$key = "Converter";

$protocoloCriptografado = $_POST['ptc'] ?? null;

if (!$protocoloCriptografado) {
    exit('Protocolo não informado.');
}

$chamado = $manager->buscarChamadoPorProtocolo($protocoloCriptografado);

if ($chamado['result'] != 1) {
    exit('Chamado não encontrado.');
}

$chamado = $chamado['dados'];

$id = $chamado['usuario_id'];

if (!$id) {
    exit('Usuário não vinculado ao chamado.');
}

$usuario = $manager->buscarUserPorId((int) $id);

if ($usuario['result'] != 1) {
    exit('Usuário não encontrado.');
}

$usuario = $usuario['dados'];

$usuario['nome_guerra'] = $ferramentas->descriptografar($usuario['nome_guerra'], $key);
$usuario['posto_graduacao'] = $ferramentas->descriptografar($usuario['posto_graduacao'], $key);
$usuario['secao'] = $ferramentas->descriptografar($usuario['secao'], $key);

$chamados = $manager->chamadosPorUsuario((int) $id);

foreach ($chamados as &$item) {
    $item['protocolo'] = $ferramentas->descriptografar($item['protocolo'], $key);
    $item['nome_guerra'] = $ferramentas->descriptografar($item['nome_guerra'], $key);
    $item['posto_graduacao'] = $ferramentas->descriptografar($item['posto_graduacao'], $key);
    $item['secao'] = $ferramentas->descriptografar($item['secao'], $key);
    $item['descricao'] = $ferramentas->descriptografar($item['descricao'], $key);
    $item['prioridade'] = $ferramentas->descriptografar($item['prioridade'], $key);
}

unset($item);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Usuário</title>
</head>

<body>

    <h1>
        <?php echo htmlspecialchars($usuario['posto_graduacao']); ?>
        <?php echo htmlspecialchars($usuario['nome_guerra']); ?>
    </h1>

    <p>
        <strong>Seção:</strong>
        <?php echo htmlspecialchars($usuario['secao']); ?>
    </p>

    <hr>

    <h2>Meus Chamados</h2>

    <?php if (count($chamados) > 0): ?>

        <?php foreach ($chamados as $chamado): ?>

            <div>
                <p>
                    <strong>Protocolo:</strong>
                    <?php echo htmlspecialchars($chamado['protocolo']); ?>
                </p>

                <p>
                    <strong>Descrição:</strong>
                    <?php echo htmlspecialchars($chamado['descricao']); ?>
                </p>

                <p>
                    <strong>Status:</strong>
                    <?php echo htmlspecialchars($chamado['status']); ?>
                </p>

                <p>
                    <strong>Prioridade:</strong>
                    <?php echo htmlspecialchars($chamado['prioridade']); ?>
                </p>

                <p>
                    <strong>Data de abertura:</strong>
                    <?php echo htmlspecialchars($chamado['data_abertura']); ?>
                </p>
            </div>

            <hr>

        <?php endforeach; ?>

    <?php else: ?>

        <p>Nenhum chamado encontrado.</p>

    <?php endif; ?>

</body>

</html>