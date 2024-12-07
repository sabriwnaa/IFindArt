<?php
session_start();
require_once "src/Item.php";

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    // Redireciona para o login caso o usuário não esteja logado
    header("Location: login.php");
    exit();
}

$modo = isset($_GET['mode']) ? $_GET['mode'] : 'votacao';

$conn = new mysqli("localhost", "root", "", "ifindart");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$itemAleatorio = null;
$ranking = [];
$itensNaoVotados = [];

if ($modo === 'votacao') {
    $votados = isset($_SESSION['voted_items']) ? $_SESSION['voted_items'] : [];

    if (count($votados) > 0) {
        // Excluir os itens que já foram votados (positivos ou negativos) da consulta
        $sql = "SELECT * FROM item WHERE idItem NOT IN (" . implode(",", array_keys($votados)) . ") ORDER BY RAND() LIMIT 1";
    } else {
        $sql = "SELECT * FROM item ORDER BY RAND() LIMIT 1";
    }

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $itemAleatorio = $result->fetch_assoc();
    } else {
        $_SESSION['error'] = "Todos os itens já foram votados.";
    }
} elseif ($modo === 'ranking') {
    $ranking = Item::getRankingCompleto();
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ifindart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class='container'>
    <?php include 'HeaderFooter/header.php'; ?>
    
    <div class='LC'>
        <div class ='itemLC'>
            <a href="?mode=votacao">Votação</a>
        </div>
        <div class ='itemLC'>
            <a href="?mode=ranking">Ranking</a>
        </div>
    </div>

    <div class='main'>
        <?php if ($modo === 'votacao'): ?>
            <?php if ($itemAleatorio): ?>
                <h2>Item Aleatório:</h2>
                <p>ID: <?php echo htmlspecialchars($itemAleatorio['idItem']); ?></p>
                <p>Nome: <?php echo htmlspecialchars($itemAleatorio['titulo']); ?></p>
                <img src="<?php echo htmlspecialchars($itemAleatorio['imagem']); ?>" alt="Imagem do Item">
                <form method="POST" action="votar.php">
                    <input type="hidden" name="item_id" value="<?php echo $itemAleatorio['idItem']; ?>"> <!-- Id do item sendo votado -->
                    
                    <!-- Botão de voto positivo -->
                    <button type="submit" name="voto" value="1">Votar Positivo</button>
                    
                    <!-- Botão de voto negativo -->
                    <button type="submit" name="voto" value="0">Votar Negativo</button>
                    
                    <!-- Botão de pular -->
                    <button type="submit" name="voto" value="2">Pular</button>
                </form>
            <?php else: ?>
                <p><?php echo $_SESSION['error'] ?? 'Nenhum item disponível para votação.'; ?></p>
            <?php endif; ?>
        
        <?php elseif ($modo === 'ranking'): ?>
            <h2>Ranking dos Itens:</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Total de Votos</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($ranking as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['idItem']); ?></td>
                        <td><?php echo htmlspecialchars($item['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($item['totalVotos']); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <?php if (empty($ranking)): ?>
                <p>Nenhum voto registrado ainda.</p>
            <?php endif; ?>
        
        <?php else: ?>
            <p>Selecione um modo para continuar.</p>
        <?php endif; ?>
    
    </div>

</div>
</body>
</html>
