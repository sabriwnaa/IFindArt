<?php 
session_start();
if(!isset($_SESSION['id'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ifindart</title>
</head>
<body>
<div class='container'>
    <?php include 'header.php'; ?>

    <div class='main'>
        
    </div>

    <?php include 'footer.php'; ?>

    </div>
</body>
</html>