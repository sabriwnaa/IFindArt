<?php
require_once "vendor/autoload.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $pdo = new PDO('mysql:host=localhost;dbname=ifindart', 'root', '');
    $stmt = $pdo->prepare("INSERT INTO users (email, name, password) VALUES (?, ?, ?)");

    try {
        $stmt->execute([$email, $name, $password]);
        $_SESSION['success'] = "Cadastro realizado com sucesso! Faça login.";
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erro: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - IFindArt</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <?php include 'HeaderFooter/header.php'; ?>
        <div class='main'>
        <div class='box'>
        <h2>Cadastro</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Cadastrar</button>
        </form>
        <p>Já tem uma conta? <a href="index.php">Faça login</a>.</p>
        
        </div>
        </div>
        <?php include 'HeaderFooter/footer.php'; ?>
    </div>
</body>
</html>
