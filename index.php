<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGIEx</title>
</head>
<body>
    <h1>SGIEx</h1>
    <form action="Controller/Controller.class.php" method="POST">
        <input type="hidden" name="acao" value="inserirChamado">
        
        <br>
        <div style="display: flex;">
            <select id="posto_graduacao" name="posto_graduacao" required>
                <option value="" selected disabled>Posto / Graduação</option>
                <option value="Cel">Cel</option>
                <option value="Ten Cel">Ten Cel</option>
                <option value="Maj">Maj</option>
                <option value="Cap">Cap</option>
                <option value="1º Ten">1º Ten</option>
                <option value="2º Ten">2º Ten</option>
                <option value="S Ten">S Ten</option>
                <option value="1º Sgt">1º Sgt</option>
                <option value="2º Sgt">2º Sgt</option>
                <option value="3º Sgt">3º Sgt</option>
                <option value="Cb">Cb</option>
                <option value="Sd EP">Sd EP</option>
                <option value="Sd EV">Sd EV</option>
            </select>
            <div>
                <input type="text" id="nome_guerra" name="nome_guerra" placeholder="Nome de Guerra" required>
            </div>
        </div>
        <br>
        <div>
            <label for="secao">Seção:</label>
            <input type="text" id="secao" name="secao" required>
        </div>
        <br>
        <div>
            <label for="ip">IP do dispositivo:</label>
            <input type="text" id="ip" name="ip" value="<?= htmlspecialchars($_SERVER['REMOTE_ADDR'] ?? 'Não identificado') ?>" readonly>
        </div>
        <br>
        <div>
            <label for="descricao">Descrição do problema:</label>
            <br>
            <textarea id="descricao" name="descricao" rows="8" cols="60" placeholder="Descreva detalhadamente o problema..." required></textarea>
        </div>
        <br>
        <button type="submit">Abrir Chamado</button>
    </form>
</body>
</html>