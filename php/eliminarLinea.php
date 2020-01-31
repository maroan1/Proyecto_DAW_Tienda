<?php
require "./modelo.php";

$base = new Bd();
$linea = new Linea_pedido($_POST['id'], $_POST['nlinea'], '', '');
$arrayDatos;
if ($linea->eliminar($base->link)) {
    $arrayDatos['funciona'] = true;
    $arrayDatos['mensaje'] = "Linea eliminada correctamente.";
} else {
    $arrayDatos['funciona'] = false;
    $arrayDatos['mensaje'] = "Fallo al eliminar lineaPedido.";
}
$json = json_encode($arrayDatos);
echo $json;
