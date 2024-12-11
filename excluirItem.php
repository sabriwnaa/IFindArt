<?php
session_start();
require_once "vendor/autoload.php";

if (!isset($_SESSION['adminLogado']) || $_SESSION['adminLogado'] !== true) {
    header("Location: index.php");
    exit();
}

$idItem = $_GET['id'];
$item = Item::findById($idItem);

if ($item && $item->delete()) {
    header("Location: restritaAdmin.php");
    exit();
} else {
    echo "Erro ao excluir o item.";
}
?>