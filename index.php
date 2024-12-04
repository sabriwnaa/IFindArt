<?php 
require_once "vendor/autoload.php";
session_start();

$mode = isset($_GET['mode']) ? $_GET['mode'] : 'login';

if (isset($_SESSION['id'])) {
    header("Location: restrita.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IFindArt</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class='container'>
        <?php include 'HeaderFooter/header.php'; ?>

        <div class='main'>
            <div class='metade'>
                <div class='preView'>
                    <h2>Ranking dos artistas favoritos dos estudantes</h2>
                    
                    <div class='itens'>
                        <div class='item'></div>
                        <div class='item'></div>
                        <div class='item'></div>
                    </div>
                    <h2>...</h2>
                    <h2>Deseja ver mais do ranking e participar dele? Faça login ou cadastre-se!</h2>
                </div>
            </div>

            <div class='metade'>
                <div class='LC'>
                    <div class ='itemLC'>
                    <a href="?mode=login" class="button <?= $mode === 'login' ? 'active' : '' ?>">Login</a>
                    
                    </div>
                    <div class ='itemLC'>
                    <a href="?mode=cadastro" class="button <?= $mode === 'cadastro' ? 'active' : '' ?>">Cadastro</a>
                
                    </div>
                    </div>
                
                <div class='box'>
                    <?php if ($mode === 'login'): ?>
                        <h2>Login</h2>
                        <?php if (isset($_SESSION['error'])): ?>
                            <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                        <?php endif; ?>
                        <form method="POST" action="process_login.php">
                            <label for="login">Email ou Nome:</label>
                            <input type="text" id="login" name="login" required>
                            
                            <label for="password">Senha:</label>
                            <input type="password" id="password" name="password" required>
                            
                            <button type="submit">Entrar</button>
                        </form>
                        <p>Não tem uma conta? <a href="?mode=cadastro">Cadastre-se</a>.</p>
                    <?php else: ?>
                        <h2>Cadastro</h2>
                        <?php if (isset($_SESSION['error'])): ?>
                            <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                        <?php endif; ?>
                        <form method="POST" action="process_cadastro.php">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                            
                            <label for="name">Nome:</label>
                            <input type="text" id="name" name="name" required>
                            
                            <label for="password">Senha:</label>
                            <input type="password" id="password" name="password" required>
                            
                            <button type="submit">Cadastrar</button>
                        </form>
                        <p>Já tem uma conta? <a href="?mode=login">Faça login</a>.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php include 'HeaderFooter/footer.php'; ?>
    </div>
</body>
</html>
