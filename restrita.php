<?php
session_start();
require_once "vendor/autoload.php";

// Verifica login
if (!isset($_SESSION['idUsuario'])) {
    header("Location: index.php");
    exit();
}

// Modo atual
$modo = isset($_GET['mode']) ? $_GET['mode'] : 'votacao';
$votados = Voto::findAllByUsuario($_SESSION['idUsuario']); // Obtém os votos do usuário

$itemAleatorio = null;
$ranking = [];



// Ações baseadas no modo
if ($modo === 'votacao') {
    $itemAleatorio = Item::getItemAleatorio($votados);

    if (!$itemAleatorio) {
        $_SESSION['error'] = "Todos os itens já foram votados.";
        header("Location: restrita.php?mode=ranking");
        exit();
    }
} elseif ($modo === 'ranking') {
    $ranking = Item::getRankingCompleto();
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IFindArt</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <?php include 'HeaderFooter/header.php'; ?>




        <div class='LC'>
            <div class='itemLC' style='background-color:#f8ddb0; color:#B02E0C;'>
                <a href="?mode=votacao">Votação</a>
            </div>
            <div class='itemLC' style='background-color:#EB4511'>
                <a href="?mode=ranking">Ranking</a>
            </div>
        </div>

            <?php if ($modo === 'votacao'): ?>
                <div class="containerVotacao">
                    <?php if ($itemAleatorio): ?>
                        <div class="votacaoFoto" style="background-image: url('images/<?= htmlspecialchars($itemAleatorio['imagem']); ?>');">
                            <div class="barraArtista">
                                <h2><?= htmlspecialchars($itemAleatorio['titulo']); ?></h2>
                            </div>
                            <form class="botoesVotacao" method="POST" action="votar.php">
                                <input type="hidden" name="item_id" value="<?= $itemAleatorio['idItem']; ?>">
                                <button type="submit" name="voto" value="1" class="botao">Like</button>
                                <button type="submit" name="voto" value="0" class="botao">Dislike</button>
                                <button type="submit" name="voto" value="2" class="botao">Pular</button>
                            </form>
                        </div>
                    <?php else: ?>
                        <p>Nenhum item disponível para votação.</p>
                    <?php endif; ?>
                </div>
            <?php elseif ($modo === 'ranking'): ?>
                <div class="containerRanking">
                    <h1>Artistas favoritos dos estudantes</h1>

                    <?php if (!empty($ranking)) {
                        $posicao = 0;
                        foreach ($ranking as $item) {
                            $posicao++;
                            echo "
                                <div class='item' " . ($posicao === 1 ? "style='border-top: 1px solid rgb(255, 255, 255);'" : "") . ">
                                    <div class='posicao'>
                                        <h1>{$posicao}°</h1>
                                    </div>
                                    <div class='informacoes'>
                                        <div class='boxFoto'>
                                            <img class='fotoItem' src='images/" . htmlspecialchars($item['imagem']) . "' alt='Imagem do Item'>
                                        </div>
                                        <div class='nomeVotos'>
                                            <h3>" . htmlspecialchars($item['titulo']) . "</h3>
                                            <p>" . (int)$item['totalVotos'] . " votos</p>
                                        </div>
                                    </div>
                                </div>";
                        }
                    } else {
                        echo "<p>Nenhum item foi votado ainda.</p>";
                    }
                    ?>
                </div>
        </div>
    <?php endif; ?>
    </div>
    </div>
</body>

</html>