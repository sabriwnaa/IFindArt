<?php
session_start();
if (isset($_SESSION['adminLogado'])) {
    unset($_SESSION['adminLogado']); 
}

if (isset($_SESSION['idUsuario']) || isset($_SESSION['admin_logged_in'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}else{
    header("Location: index.php");
}

?>