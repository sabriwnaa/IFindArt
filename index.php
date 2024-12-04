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
        <div class='box'>
            
        </div>

    </div>

    <?php include 'HeaderFooter/footer.php'; ?>

    </div>
    
</body>
</html>