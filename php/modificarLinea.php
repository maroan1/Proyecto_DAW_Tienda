<?php
require "modelo.php";

$base = new Bd();
$linea = new Linea_pedido($_POST['id'], $_POST['nlinea'], $_POST['idProducto'], $_POST['cantidad']);
$arrayDatos;

if ($linea->modificar($base->link)) {
    $arrayDatos["funciona"] = true;
    $arrayDatos["Mensaje"] = "Linea modificada satisfactoriamente.";
    $arrayDatos["nlinea"] = $linea->__get('nlinea');
} else {
    $arrayDatos["funciona"] = false;
    $arrayDatos["Mensaje"] = "Fallo al modificar linea.";
}

$json = json_encode($arrayDatos);
echo $json;
$base->link->close();
