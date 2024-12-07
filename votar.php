<?php
session_start();
require_once "src/Item.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "ifindart");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['voto'])) {
    $item_id = $_POST['item_id'];
    $voto = $_POST['voto'];

    // Ação de "pular"
    if ($voto == 2) {
        // Não registra nada, apenas redireciona para a próxima votação
        header("Location: restrita.php?mode=votacao");
        exit();
    }

    // Registrar o voto no banco de dados
    $sql = "INSERT INTO voto (idItem, idUsuario, isLike) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $item_id, $_SESSION['id'], $voto);
    $stmt->execute();

    // Marcar item como votado na sessão
    $_SESSION['voted_items'][$item_id] = $voto;

    header("Location: restrita.php?mode=votacao");
    exit();
}

$conn->close();
?>
