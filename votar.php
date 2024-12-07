<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    // Redireciona para o login caso o usuário não esteja logado
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['item_id'])) {
    $item_id = $_POST['item_id'];
    $idUsuario = $_SESSION['id'];  // Obtendo o idUsuario da sessão

    // Conectar ao banco de dados
    $conn = new mysqli("localhost", "root", "", "ifindart");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insere o voto na tabela voto
    $sql = "INSERT INTO voto (idItem, idUsuario) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $item_id, $idUsuario);  // Bind para os dois parâmetros: idItem e idUsuario
    $stmt->execute();

    // Marca o item como votado para esse usuário na sessão
    $_SESSION['voted_items'][$item_id] = true;

    $_SESSION['success'] = "Seu voto foi registrado com sucesso!";
    header("Location: restrita.php?mode=votacao");
    exit();
} else {
    $_SESSION['error'] = "Erro ao registrar voto.";
    header("Location: restrita.php?mode=votacao");
    exit();
}
?>
