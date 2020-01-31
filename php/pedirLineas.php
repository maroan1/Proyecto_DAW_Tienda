<?php
require "./modelo.php";

$base = new Bd();
$linea = new Linea_pedido($_POST['id'], '', '', '');
$datos = $linea->buscarPedido($base->link);
$arrayDatos;
$arrayDatos['funciona'] = true;
if ($datos) {
    $arrayDatos['funciona'] = true;
    while ($valor = $datos->fetch_assoc()) {
        $arrayDatos['lineas'][] = $valor;
    }
} else {
    $arrayDatos['lineas'] = "Sin líneas";
}
$json = json_encode($arrayDatos);
echo $json;
