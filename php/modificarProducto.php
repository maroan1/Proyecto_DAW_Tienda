<?php

require "./modelo.php";

$base = new Bd();
$product = new Producto($_POST['id'], $_POST['nombre'], 'idioma', $_POST['foto'], $_POST['autor'], '', '', 100, $_POST['precio']);
$arrayDatos;
if ($product->modificar($base->link)) {
    $arrayDatos["modificado"] = true;
    $arrayDatos["mensaje"] = "Producto " . $product->__get('nombre') . " se ha modificado satisfactoriamente.";
} else {
    $arrayDatos["modificado"] = false;
    $arrayDatos["mensaje"] = "Fallo al modificar producto.";
}
$json = json_encode($arrayDatos);
echo $json;
$base->link->close();
