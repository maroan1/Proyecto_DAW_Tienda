<?php
require "./modelo.php";

$base = new Bd();
$pedido = new Pedido();
$pedido->__set('fecha', $_POST['fecha']);
$pedido->__set('dniCliente', $_POST['dni']);
$arrayDatos;
if ($pedido->insertar($base->link)) {
    $arrayDatos["funciona"] = true;
    $arrayDatos["mensaje"] = "Pedido insertado satisfactoriamente.";
    $arrayDatos["id"] = $pedido->__get("idPedido");
} else {
    $arrayDatos["funciona"] = false;
    $arrayDatos["mensaje"] = "Fallo al insertar pedido.";
}

$json = json_encode($arrayDatos);
echo $json;
$base->link->close();
