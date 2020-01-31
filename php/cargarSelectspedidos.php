<?php
require "modelo.php";

$base = new Bd();
$dato = Producto::getAll($base->link);
$arrayDatos;
while ($valor = $dato->fetch_assoc()) {
    $arrayDatos['productos'][] = ['idProducto' => $valor['idProducto'], 'nombre' => $valor['nombre']];
}
$dnis = Cliente::getAll($base->link);
while ($valor = $dnis->fetch_assoc()) {
    $arrayDatos['dnis'][] = $valor['dniCliente'];
}

$json = json_encode($arrayDatos);
echo $json;
$base->link->close();
