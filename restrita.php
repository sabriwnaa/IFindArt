<?php 
session_start();
//require_once "vendor/autoload.php";

// Verifica se o usuário está logado
// if(!isset($_SESSION['id'])) {
//     header("Location: login.php");
//     exit();
// }

$modo = isset($_GET['mode']) ? $_GET['mode'] : 'votacao';

$conn = new mysqli("localhost", "root", "", "ifindart");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$itemAleatorio = null;
$ranking = [];

if ($modo === 'votacao') {
    // Selecionar um item aleatório
    $sql = "SELECT * FROM item ORDER BY RAND() LIMIT 1";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $itemAleatorio = $result->fetch_assoc();
    } else {
        $_SESSION['error'] = "Nenhum item encontrado.";
    }
} elseif ($modo === 'ranking') {
    // Obter ranking dos itens
    $sql = "
        SELECT i.idItem, i.titulo, COUNT(v.idItem) AS total_votos
        FROM item i
        LEFT JOIN voto v ON i.idItem = v.idItem
        GROUP BY i.idItem, i.titulo
        ORDER BY total_votos DESC
    ";
    $rankingResult = $conn->query($sql);
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
                <p>Nome: <?php echo htmlspecialchars($itemAleatorio['nome']); ?></p>
            <?php else: ?>
                <p>Nenhum item encontrado.</p>
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
                            <td><?php echo htmlspecialchars($item['nome']); ?></td>
                            <td><?php echo htmlspecialchars($item['total_votos']); ?></td>
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