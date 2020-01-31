<?php
require "./modelo.php";

$base = new Bd();
$pedido = new Pedido();
$pedido->__set('idPedido', $_POST['id']);
if ($pedido->eliminar($base->link)) {
    $arrayDatos["funciona"] = true;
    $arrayDatos["mensaje"] = "Pedido eliminado con éxito";
} else {
    $arrayDatos["funciona"] = false;
    $arrayDatos["mensaje"] = "Fallo al eliminar pedido";
}
$json = json_encode($arrayDatos);
echo $json;
$base->link->close();
