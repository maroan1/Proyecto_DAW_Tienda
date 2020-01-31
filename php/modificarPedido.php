<?php
require "./modelo.php";

$base = new Bd();
$pedido = new Pedido();
$pedido->__set('idPedido', $_POST['id']);
$pedido->__set('fecha', $_POST['fecha']);
$pedido->__set('dniCliente', $_POST['dni']);
$arrayDatos;
if ($pedido->modificar($base->link)) {
    $arrayDatos["funciona"] = true;
    $arrayDatos["mensaje"] = "Pedido modificado satisfactoriamente.";
} else {
    $arrayDatos["funciona"] = false;
    $arrayDatos["mensaje"] = "Fallo al modificar pedido.";
}
$json = json_encode($arrayDatos);
echo $json;
$base->link->close();
