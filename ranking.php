<?php
session_start();
require_once "vendor/autoload.php";

$ranking[] = Voto::ranking();
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
            
            <?php if(isset($ranking[0]["titulo"])):?>
            <tr>
            <th>Item</th>
            <th>Quantidade</th>
            </tr>
            <<?php endif ?>
            <tr>
                <?php
                if(isset($ranking[0]["titulo"])){
                    foreach($ranking as $item){
                    echo"<td>".$item["titulo"] ."</td>";
                    echo"<td>".$item["quantidade"]."</td>";
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