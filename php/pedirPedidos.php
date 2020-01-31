<?php
require "modelo.php";

$base = new Bd();
$dato = Pedido::getAll($base->link);
$arrayDatos;
while ($valor = $dato->fetch_assoc()) {
    $arrayDatos['pedidos'][] = $valor;
}
$json = json_encode($arrayDatos);
echo $json;
$base->link->close();
