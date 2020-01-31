<?php
require "./modelo.php";

$base = new Bd();
$product = new Producto($_POST['id'], '', '', '', '', '', '', '', '');
if ($product->eliminar($base->link)) {
    $arrayDatos["eliminado"] = true;
    $arrayDatos["mensaje"] = "Producto eliminado con éxito";
} else {
    $arrayDatos["eliminado"] = false;
    $arrayDatos["mensaje"] = "Fallo al eliminar producto";
}
$json = json_encode($arrayDatos);
echo $json;
$base->link->close();
