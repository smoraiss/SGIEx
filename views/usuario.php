<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meus chamados</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../public/assets/css/global.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<style>
    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 0px !important;
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
    .hamb,
    .head-right {
        display: flex;
        flex-direction: row;
    }

    .head-left,
    .head-right {
        width: 50%;
        height: 100%;
        align-items: center;
    }

    .head {
        position: absolute;
        height: 4vh;
        border-bottom: 1px solid #ccc;
        width: 100%;
        justify-content: space-between;
        align-items: center;

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

            a {
                height: 100%;
                cursor: pointer;
                border-left: 1px solid #ccc !important;
                align-items: center;
                stroke: #ccc;
                display: flex;
                width: 5%;
                justify-content: center;
                transition: all 0.156s ease-in-out;
            }

            a>div>svg:hover {
                transition: all 0.156s ease-in-out;
                stroke: rgb(13, 110, 253);
            }
        }
    }

    .logo {
        display: flex;
        flex-direction: row;
        width: 100%;
        justify-content: left;
    }

    .logotipo {
        width: 20%;
    }

    .pagina {
        width: 80%;
    }

    .pagina>span {
        background: rgba(13 110 253 / 20%);
        font-size: 1rem;
        padding: 1% 3%;
        border-radius: 4px;
        font-size: 13px;
        font-style: bold;
        font-weight: 600;
    }
</style>
<style>
    .container>.row {display: grid;grid-template-columns: auto auto auto;padding: 10px;}.card-link#ch-ed {border: 1px solid rgba(13, 110, 253);padding: 2% 7%;text-decoration: none !important;border-radius: 0.375rem;}.card-link#ch-ed:hover {background-color: rgb(13 110 253 / 10%);}
    .card-link#ch-de {
        border: 1px solid rgb(253 13 13);
        color: rgb(253 13 13) !important;
        padding: 2% 7%;
        text-decoration: none !important;
        border-radius: 0.375rem;
    }

    .card-link#ch-de:hover {
        background-color: rgb(253 13 13 /10%);
    }

    nav {
        margin-top: 4vh;
        background-color: #cccccc4a;
    }

    .card {
        box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
        cursor: pointer;
            padding: 0;
    }
    .card-header{
            padding-bottom: 0;
    width: 100%;
    }
    .card:hover {
        box-shadow: rgba(0, 0, 0, 0.16) 0px 5px 13px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;
        transition: all .157s ease-in-out;
    }

    #progressBar {
        margin-top: 8vh;
        background-color: transparent !important;
        width: 100%;
        border-radius: none !important;
        max-height: 3px !important;
    }
    #progress{
        background-color: rgb(13 110 253 / 50%) !important;
    }
</style>

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
                    <img src="../public/Images/logo.png" alt="SGIEx" width="100%">
                </div>
                <div class="pagina">
                    <span>Registrar Chamado</span>
                </div>
            </div>
        </div>
        <div class="head-right">
            <a href="index.php?rota=login_usuario" data-toggle="tooltip" data-placement="left" title="Página do usuário">
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
            </a>
            <a href="" data-toggle="tooltip" data-placement="left" title="Documentação">
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
            </a>
        </div>
    </header>
    <nav class="head">

    </nav>
    <div id="progressBar" style="position: fixed; top: 0; left: 0; width: 100vw; height: 3px;">
    <div id="progress" style="width: 0%; height: 100%;"></div>
</div>
    <div class="container" style="margin-top: 9vh;">
        <div class="row">
            <?php foreach ($meus as $item): ?>
                <div href="#<?= e($item['protocolo']) ?>" class="card" style="width: 18rem;" style="cursor: pointer;text-decoration:none;">
                <div class="card-header">
<h5 class="card-title"><?= e($item['protocolo']) ?></h5>
                </div>    
                <div class="card-body">
                        
                        <h6 class="card-subtitle mb-2 text-muted"><?= e($item['posto_graduacao']) ?> <?= e($item['nome_guerra']) ?> | <?= e($item['secao']) ?></h6>
                        <p class="card-text"><?= e($item['descricao']) ?></p>
                        <a href="" class="card-link" id="ch-ed" name="edt_<?= e($item['protocolo']) ?>">Editar</a>
                        <a href="" class="card-link" id="ch-de" name="del_<?= e($item['protocolo']) ?>">Deletar</a>
                    </div>
                    <span><?php /*  e($item['data_abertura']) */ ?></span>
                </div>


            <?php endforeach; ?>
        </div>
    </div>
    <a href="index.php">Novo chamado</a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <script>
        history.replaceState(null, '', 'index.php');
    </script>
    <script>
       let progresso = 0;

const progressBar = document.getElementById('progressBar');
const progress = document.getElementById('progress');

const intervalo = setInterval(() => {
    progresso++;

    progress.style.width = progresso + '%';
    progress.setAttribute('aria-valuenow', progresso);

    if (progresso >= 100) {
        clearInterval(intervalo);

        progressBar.style.background = 'transparent';
        progressBar.style.border = 'none';
        progressBar.style.boxShadow = 'none';

        progress.style.background = 'transparent';
        progress.style.border = 'none';
        progress.style.boxShadow = 'none';
    }
}, 20);
    </script>
</body>
<?php /* e($item['status']) */ ?>
<?php /* e($item['prioridade']) */ ?><br>

</html>