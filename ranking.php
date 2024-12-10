<?php
session_start();
require_once "vendor/autoload.php";

if (!isset($_SESSION['idUsuario'])) {
    header("Location: index.php");
    exit();
}

$modo = isset($_GET['mode']) ? $_GET['mode'] : 'votacao';
$votados = $_SESSION['voted_items'] ?? [];
$itemAleatorio = null;
$ranking = [];

// Ações baseadas no modo
if ($modo === 'votacao') {
    $itemAleatorio = Item::getItemAleatorio($votados);

    if (!$itemAleatorio) {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION['error'] = "Todos os itens já foram votados.";
        }

        if (!headers_sent()) {
            header("Location: restrita.php?mode=ranking");
            exit();
        } else {
            echo "Erro: não foi possível redirecionar para o ranking.";
        }
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

    <div class="menu">
        <a href="?mode=votacao">Votação</a>
        <a href="?mode=ranking">Ranking</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main">
        <?php if ($modo === 'votacao'): ?>
            <?php if ($itemAleatorio): ?>
                <h2>Vote neste item:</h2>
                <p>ID: <?= htmlspecialchars($itemAleatorio['idItem']); ?></p>
                <p>Nome: <?= htmlspecialchars($itemAleatorio['titulo']); ?></p>
                <img src="<?= htmlspecialchars($itemAleatorio['imagem']); ?>" alt="Imagem">
                <form method="POST" action="votar.php">
                    <input type="hidden" name="item_id" value="<?= $itemAleatorio['idItem']; ?>">
                    <button type="submit" name="voto" value="1">Like</button>
                    <button type="submit" name="voto" value="0">Dislike</button>
                    <button type="submit" name="voto" value="2">Pular</button>
                </form>
            <?php else: ?>
                <p>Nenhum item disponível para votação.</p>
            <?php endif; ?>
        <?php elseif ($modo === 'ranking'): ?>
            <h1>Ranking</h1>
            <div class="ranking">
                <?php if (!empty($ranking)): ?>
                    <?php foreach ($ranking as $item): ?>
                        <div class="rank-item">
                            <span><?= htmlspecialchars($item['titulo']); ?></span>
                            <span><?= htmlspecialchars($item['totalVotos']); ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhum voto registrado.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
