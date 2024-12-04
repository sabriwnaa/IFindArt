<?php
session_start();
require_once "vendor/autoload.php";

$votos[] = Voto::findall();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class='container'>
    <?php include 'HeaderFooter/header.php'; ?>

    <div class='main'>
        <table>
            
            <?php if(isset($votos[0]["titulo"])):?>
            <tr>
            <th>Item</th>
            <th>Quantidade</th>
            </tr>
            <<?php endif ?>
            <tr>
                <?php
                if(isset($votos[0]["titulo"])){
                    foreach($votos as $voto){
                    echo"<td>".$votos[0]["titulo"] ."</td>";
                    echo"<td>".$votos[0]["quantidade"]."</td>";
                    }
                }else{
                    echo"<p>não possui votos cadastrados</p>";
                    
                }
                
                ?>
                
            </tr>
        </table>
    </div>

    <?php include 'HeaderFooter/footer.php'; ?>

    </div>
</body>
</html>