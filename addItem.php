<?php

session_start();
require_once "vendor/autoload.php";

// Verifica login
if (!isset($_SESSION['adminLogado']) || $_SESSION['adminLogado'] !== true) {
    header("Location: index.php");
    exit();



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


<div class='boxCadastroItem'>
    <h1 class='tituloAdmin'>Cadastrar novo artista</h1>
    <div class='camposAddItem'>
        
    </div>
    <div class='opcoes'>
        <a href="restritaAdmin.php" class='botaoClaro' style='flex:2;'>Cadastrar</a>
        <a href="restritaAdmin.php" class='botaoClaro' style='flex:1;'>Cancelar</a>
    </div>
</div>




</div>
</div>
    
</body>
</html>