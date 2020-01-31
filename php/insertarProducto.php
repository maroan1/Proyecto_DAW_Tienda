<?php
require "./modelo.php";

$base = new Bd();
$product = new Producto('', $_POST['nombre'], 'idioma', $_POST['foto'], $_POST['autor'], '', '', 100, $_POST['precio']);
$arrayDatos;
if ($product->insertar($base->link)) {
    $arrayDatos["Insertado"] = true;
    $arrayDatos["Mensaje"] = "Producto " . $product->__get('nombre') . " se ha insertado satisfactoriamente.";
    $pedirID = $product->lastId($base->link);
    $id = $pedirID['MAX(idProducto)'];
    $arrayDatos["id"] = $id;
    $json = json_encode($arrayDatos);
} else {
    $arrayDatos["Insertado"] = false;
    $arrayDatos["Mensaje"] = "Fallo al insertar producto.";
}


echo $json;
$base->link->close();
