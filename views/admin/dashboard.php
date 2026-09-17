<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SGIEx — Administração</title>
    <style>
        body {
            font-family: Arial;
            margin: 24px
        }

        .box {
            border: 1px solid #ddd;
            padding: 16px;
            margin: 12px 0
        }

        input,
        select,
        button {
            padding: 8px;
            margin: 4px 0
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 12px
        }
    </style>
</head>

<body>
    <p>Olá, <?= e($_SESSION['admin_nome']) ?> |
    <form style="display:inline" method="post" action="index.php"><input type="hidden" name="acao" value="logout"><button>Sair</button></form>
    </p>
    <h1>Chamados</h1>
    <div class="grid"><?php foreach ($lista as $c): ?><div class="box"><strong><?= e($c['protocolo']) ?></strong>
                <p><?= e($c['posto_graduacao']) ?> <?= e($c['nome_guerra']) ?> — <?= e($c['secao']) ?></p>
                <p><?= nl2br(e($c['descricao'])) ?></p>
                <form method="post" action="index.php"><input type="hidden" name="acao" value="atualizar_chamado"><input type="hidden" name="csrf" value="<?= e(Security::csrf()) ?>"><input type="hidden" name="id" value="<?= e($c['id']) ?>"><select name="status"><?php foreach (['ABERTO', 'EM_ATENDIMENTO', 'AGUARDANDO_SOLICITANTE', 'RESOLVIDO', 'FECHADO', 'CANCELADO'] as $v): ?><option <?= $c['status'] === $v ? 'selected' : '' ?>><?= e($v) ?></option><?php endforeach; ?></select><select name="prioridade"><?php foreach (['BAIXA', 'MEDIA', 'ALTA', 'CRITICA'] as $v): ?><option <?= $c['prioridade'] === $v ? 'selected' : '' ?>><?= e($v) ?></option><?php endforeach; ?></select><button>Salvar</button></form>
            </div><?php endforeach; ?></div>
    <h2>Novo administrador</h2>
    <form method="post" action="index.php"><input type="hidden" name="acao" value="criar_admin"><input type="hidden" name="csrf" value="<?= e(Security::csrf()) ?>"><input name="usuario" placeholder="Usuário" required><input name="nome" placeholder="Nome" required><input name="senha" type="password" placeholder="Senha (mín. 10 caracteres)" required><button>Criar</button></form>
    <h2>Administradores</h2><?php foreach ($adminsLista as $a): ?><div><?= e($a['usuario']) ?> — <?= e($a['nome']) ?> — <?= $a['ativo'] ? 'Ativo' : 'Inativo' ?><form style="display:inline" method="post" action="index.php"><input type="hidden" name="acao" value="status_admin"><input type="hidden" name="csrf" value="<?= e(Security::csrf()) ?>"><input type="hidden" name="id" value="<?= e($a['id']) ?>"><input type="hidden" name="ativo" value="<?= $a['ativo'] ? 0 : 1 ?>"><button><?= $a['ativo'] ? 'Desativar' : 'Ativar' ?></button></form>
        </div><?php endforeach; ?>
</body>

</html>