<?php
require "modelo.php";

$accion = $_POST["accion"];

if ($accion == "AllProducts") {
    $base = new Bd();
    $dato = Producto::getAll($base->link);
    $arrayDatos;
    while ($valor = $dato->fetch_assoc()) {
        $arrayDatos['productos'][] = $valor;
    }
    $json = json_encode($arrayDatos);
    echo $json;
    $base->link->close();
} elseif ($accion == "insertProduct") {
    $base = new Bd();
    $product = new Producto('', $_POST['nombre'], 'idioma', $_POST['foto'], $_POST['autor'], '', '', 100, $_POST['precio']);
    $arrayDatos;
    if ($product->insertar($base->link)) {
        $arrayDatos["Insertado"] = true;
        $arrayDatos["Mensaje"] = "Producto " . $product->__get('nombre') . " se ha insertado satisfactoriamente.";
    } else {
        $arrayDatos["Insertado"] = false;
        $arrayDatos["Mensaje"] = "Fallo al insertar producto.";
    }

    $json = json_encode($arrayDatos);
    echo $json;
    $base->link->close();
} elseif ($accion == "modProduct") {
    $base = new Bd();
    $product = new Producto($_POST['id'], $_POST['nombre'], 'idioma', $_POST['foto'], $_POST['autor'], '', '', 100, $_POST['precio']);
    $arrayDatos;
    if ($product->modificar($base->link)) {
        $arrayDatos["modificado"] = true;
        $arrayDatos["mensaje"] = "Producto " . $product->__get('nombre') . " se ha modificado satisfactoriamente.";
    } else {
        $arrayDatos["modificado"] = false;
        $arrayDatos["mensaje"] = "Fallo al modificar producto.";
    }
    $json = json_encode($arrayDatos);
    echo $json;
    $base->link->close();
} elseif ($accion == "loadProduct") {
    $base = new Bd();
    $product = new Producto($_POST['id'], '', '', '', '', '', '', '', '');
    if ($result = $product->buscar($base->link)) {
        $arrayDatos["cargado"] = true;
        $arrayDatos["producto"] = $result;
    } else {
        $arrayDatos["cargado"] = false;
        $arrayDatos["mensaje"] = "Producto no encontrado";
    }
    $json = json_encode($arrayDatos);
    echo $json;
    $base->link->close();
} elseif ($accion == "deleteProduct") {
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
} else {
    $result["mensaje"] = "no ha cargado ninguna función php";
    $json = json_encode($result);
    echo $json;
}
