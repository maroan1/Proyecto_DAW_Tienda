<?php
require "./modelo.php";

$base = new Bd();
$user = new Cliente($_POST['dni'], '', '', '', 'password', '0');
if ($user->eliminar($base->link)) {
    $arrayDatos["eliminado"] = true;
    $arrayDatos["mensaje"] = "Usuario eliminado con éxito";
} else {
    $arrayDatos["eliminado"] = false;
    $arrayDatos["mensaje"] = "Fallo al eliminar usuario";
}
$json = json_encode($arrayDatos);
echo $json;
$base->link->close();
