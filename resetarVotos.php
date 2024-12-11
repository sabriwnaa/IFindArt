<?php 
session_start();
require_once "vendor/autoload.php";
session_start();
if(isset ($_SESSION['idUsuario'])) {
    Voto::resetarVotos($_SESSION['idUsuario']);
    header("Location: restrita.php");
    exit();
}

?>