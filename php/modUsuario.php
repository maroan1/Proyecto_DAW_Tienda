<?php
require "./modelo.php";

$base = new Bd();
$user = new Cliente($_POST['dni'], $_POST['nombre'], $_POST['direccion'], $_POST['email'], 'password', '0');
$arrayDatos;
if ($user->modificar($base->link)) {
    $arrayDatos["modificado"] = true;
    $arrayDatos["mensaje"] = "Usuario " . $user->__get('nombre') . " se ha modificado satisfactoriamente.";
} else {
    $arrayDatos["modificado"] = false;
    $arrayDatos["mensaje"] = "Fallo al modificar usuario.";
}
$json = json_encode($arrayDatos);
echo $json;
$base->link->close();
