<?php

require "./modelo.php";

$base = new Bd();
$user = new Cliente($_POST['dni'], $_POST['nombre'], $_POST['direccion'], $_POST['email'], 'password', '0');
$arrayDatos;
if ($result = $user->insertar($base->link)) {
    $arrayDatos["Insertado"] = true;
    $arrayDatos["mensaje"] = "Usuario " . $user->__get('nombre') . " se ha insertado satisfactoriamente.";
} else {
    $arrayDatos["Insertado"] = false;
    $arrayDatos["mensaje"] = "Fallo al insertar usuario.";
}

$json = json_encode($arrayDatos);
echo $json;
$base->link->close();
