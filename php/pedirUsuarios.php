<?php

require "./modelo.php";

$base = new Bd();
$dato = Cliente::getAll($base->link);
$arrayDatos;
while ($valor = $dato->fetch_assoc()) {
    $valor['pwd'] = '';
    $arrayDatos['usuarios'][] = $valor;
}
$json = json_encode($arrayDatos);
echo $json;
$base->link->close();
