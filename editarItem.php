<?php
session_start();
require_once "vendor/autoload.php";

if (!isset($_SESSION['adminLogado']) || $_SESSION['adminLogado'] !== true) {
    header("Location: index.php");
    exit();
}

$idItem = $_GET['id'];
$item = Item::findById($idItem);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item->titulo = $_POST['titulo'];
    $item->imagem = $_POST['imagem'];
    if ($item->save()) {
        header("Location: restritaAdmin.php");
        exit();
    } else {
        $error = "Erro ao salvar o item.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Item</title>
</head>

<body>
    <h1>Editar Item</h1>
    <?php if (isset($error)): ?>
        <p style="color:red;"><?= $error; ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($item->titulo); ?>" required>
        <label for="imagem">Imagem:</label>
        <input type="text" name="imagem" id="imagem" value="<?= htmlspecialchars($item->imagem); ?>" required>
        <button type="submit">Salvar</button>
    </form>
</body>

</html>