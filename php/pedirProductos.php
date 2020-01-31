<?php

require "./modelo.php";

$base = new Bd();
$dato = Producto::getAll($base->link);
$arrayDatos;
while ($valor = $dato->fetch_assoc()) {
    $arrayDatos['productos'][] = $valor;
}
$json = json_encode($arrayDatos);
echo $json;
$base->link->close();
