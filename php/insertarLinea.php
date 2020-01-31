<?php
require "modelo.php";

$base = new Bd();
$linea = new Linea_pedido($_POST['id'], NULL, $_POST['idProducto'], $_POST['cantidad']);
$arrayDatos;

if ($linea->insertar($base->link)) {
    $arrayDatos["funciona"] = true;
    $arrayDatos["mensaje"] = "Linea insertada satisfactoriamente.";
    $arrayDatos["nlinea"] = $linea->__get('nlinea');
} else {
    $arrayDatos["funciona"] = false;
    $arrayDatos["mensaje"] = "Fallo al insertar linea.";
}

$json = json_encode($arrayDatos);
echo $json;
$base->link->close();
