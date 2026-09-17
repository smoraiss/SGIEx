<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meus chamados</title>
    <style>
        body {
            font-family: Arial;
            margin: 40px;
            max-width: 760px
        }

        input,
        select,
        textarea,
        button {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 14px;
            box-sizing: border-box
        }

        button {
            cursor: pointer
        }
    </style>
</head>

<body>

    <h1>
        <?= e($chamado['posto_graduacao']) ?>
        <?= e($chamado['nome_guerra']) ?>
        — <?= e($chamado['secao']) ?>
    </h1>

    <h2>Meus chamados</h2>

    <?php foreach ($meus as $item): ?>

        <a href="#<?= e($item['protocolo']) ?>" style="cursor: pointer;text-decoration:none;">
            <article>
                <strong><?= e($item['protocolo']) ?></strong>

                — <?= e($item['status']) ?>
                — <?= e($item['prioridade']) ?><br>
                <p>
                    <?= e($item['descricao']) ?>
                </p>
                <br>

                <?= e($item['data_abertura']) ?>
            </article>
        </a>

        <hr>

    <?php endforeach; ?>

    <a href="index.php">Novo chamado</a>
<script>
history.replaceState(null, '', 'index.php');
</script>
</body>

</html>