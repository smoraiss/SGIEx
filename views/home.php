<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGIEx</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0px !important;
            font-family: Arial;
            max-width: 100%
        }

        .mv-container {
            width: 50%;
            height: 100%;
            display: flex;
            flex-direction: column;
            margin-top: 4vh;

        }

        input,
        select,
        textarea,
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 14px;
            box-sizing: border-box
        }

        button {
            cursor: pointer
        }

        .head,
        .head-left,
        .hamb,.head-right {
            display: flex;
            flex-direction: row;
        }

        .head-left,
        .head-right {
            width: 50%;
        }

        .head {
            position: absolute;
            height: 4vh;
            border-bottom: 1px solid #ccc;
            width: 100%;
            justify-content: space-between;

            .head-left {
                justify-content: flex-start;

                .hamb {
                    cursor: pointer;
                    border-right: 1px solid #ccc;
                    align-items: center;
                    width: 5%;
                    justify-content: center;
                }
            }

            .head-right {
                justify-content: flex-end;

                .user,
                .ask {
                    cursor: pointer;
                    border-left: 1px solid #ccc;
                    align-items: center;
                    display: flex;
                    width: 5%;
                    justify-content: center;
                }
            }
        }
    </style>
</head>

<body>
    <header class="head">
        <div class="head-left">
            <div class="hamb">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="25"
                    height="25"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="#ccc"
                    stroke-width="0.8"
                    stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M4 6l16 0" />
                    <path d="M4 12l16 0" />
                    <path d="M4 18l16 0" />
                </svg>
            </div>
            <div class="logo">
                <div class="logotipo">
                    <img src="logo.png" alt="SGIEx" width="100%">
                </div>
                <div class="pagina">
                    <span>Registrar Chamado</span>
                </div>
            </div>
        </div>
        <div class="head-right">
            <div class="user">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="25"
                    height="25"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="#ccc"
                    stroke-width="0.9"
                    stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z" />
                    <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" />
                    <path d="M6 20.05v-.05a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v.05" />
                </svg>
            </div>
            <div class="ask">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="25"
                    height="25"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="#ccc"
                    stroke-width="0.9"
                    stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M12 9h.01" />
                    <path d="M11 12h1v4h1" />
                    <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" />
                </svg>
            </div>
        </div>
    </header>
    <main class="mv-container">

        <form action="index.php" method="POST">
            <input type="hidden" name="acao" value="criar_chamado">
            <input type="hidden" name="csrf" value="<?= e(Security::csrf()) ?>">
            <input type="hidden" id="ip" name="ip" value="<?= htmlspecialchars($_SERVER['REMOTE_ADDR'] ?? 'Não identificado') ?>" readonly>

            <br>
            <div style="display: flex;">
                <select id="posto_graduacao" name="posto_graduacao" required>
                    <option value="">Selecione</option><?php foreach (['Cel', 'Ten Cel', 'Maj', 'Cap', '1º Ten', '2º Ten', 'S Ten', '1º Sgt', '2º Sgt', '3º Sgt', 'Cb', 'Sd EP', 'Sd EV'] as $v): ?><option><?= e($v) ?></option><?php endforeach; ?>
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
                <label for="ip">Prioridade:</label>
                <select name="prioridade" id="prioridade">
                    <?php foreach (['BAIXA', 'MEDIA', 'ALTA', 'CRITICA'] as $v): ?><option><?= e($v) ?></option><?php endforeach; ?>
                </select>
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
    </main>
    <script>
        history.replaceState(null, '', ' ');
    </script>
</body>

</html>