<?php 
require_once "vendor/autoload.php";
session_start();
if(isset($_SESSION['id'])) {
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
        
                <div class='box'>
                <h2>Login</h2>
                <?php if (isset($_SESSION['error'])): ?>
                    <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                <?php endif; ?>
                <form method="POST">
                    <label for="login">Email ou Nome:</label>
                    <input type="text" id="login" name="login" required>
                    
                    <label for="password">Senha:</label>
                    <input type="password" id="password" name="password" required>
                    
                    <button type="submit">Entrar</button>
                </form>
                <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se</a>.</p>
            
            </div>
        
        
            </div>
            </div>


            

        <?php include 'HeaderFooter/footer.php'; ?>

    </div>
    
</body>
</html>