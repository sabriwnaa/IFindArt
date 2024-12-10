<?php
session_start();
require_once "vendor/autoload.php"; 
if (!isset($_SESSION['idUsuario'])) {
    header("Location: restrita.php");
    exit();
}

if (isset($_POST['voto'])) {
    $voto = $_POST['voto'];
    if ($voto == 2) {
        header("Location: restrita.php?mode=votacao");
        exit();
    }

    $novoVoto = new Voto($_SESSION['idUsuario'], $_POST['item_id'], $voto == 1);
    $novoVoto->save();
    $_SESSION['voted_items'][] = $_POST['item_id'];
    header("Location: restrita.php?mode=votacao");
}
