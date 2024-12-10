<?php

session_start();
require_once "vendor/autoload.php";

// Verifica login
if (!isset($_SESSION['adminLogado']) || $_SESSION['adminLogado'] !== true) {
    header("Location: index.php");
    exit();



}

$itens = Item::findAllSorted();
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
<div class='main' style='color: #B02E0C; justify-content:start;'>


<h1 class='tituloAdmin'>Artistas cadastrados</h1>

<a href="addItem.php">+ Adicionar artista</a>

        <div class="itens">
            <?php if (!empty($itens)): 
                $posicao = 0;?>
                
                <?php foreach ($itens as $item): 
                    $posicao++;?>
                    <div class="item" style='border-bottom: 1px solid #B02E0C;'>
                        <div class="informacoes">
                            <div class='boxFoto'>
                                <img src="images/<?= htmlspecialchars($item['imagem']); ?>" alt="Imagem do Item" class="item-img">
                        
                            </div>
                            <div class='nomeVotos'>
                            <h3><?= htmlspecialchars($item['titulo']); ?></h3>
                            <p><?= (int)$item['totalVotos']; ?> votos</p>
                            </div>
                            
                        </div>
                        <div class="item-actions">
                            <a href="editarItem.php?id=<?= $item['idItem']; ?>" class="btn">Editar</a>
                            <a href="excluirItem.php?id=<?= $item['idItem']; ?>" class="btn" onclick="return confirm('Tem certeza que deseja excluir este item?');">Excluir</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhum item cadastrado.</p>
            <?php endif; ?>
        </div>



</div>
</div>
    
</body>
</html>