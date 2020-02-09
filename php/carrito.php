<?php
include "vistas/inicio.html";
include "vistas/saludo.php";
$pActual = "carrito.php";
require "validar.php";
if (isset($_POST['comprar'])) {
    if (isset($_COOKIE['nombre'])) {
        $postData = array('dniCliente' => $_COOKIE['dni'], 'idProducto' => $_POST['id'], 'cantidad' => $_POST['cantidad'], 'precio' => $_POST['precio']);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/Proyecto_DAW_Tienda/php/carritos");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        //http_build_query => Generar una cadena de consulta codificada estilo URL a partir de array  
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        print_r($data);
        curl_close($ch);
    } else {
        $arryCarrito = array('idProducto' => $_POST['id'], 'cantidad' => $_POST['cantidad'], 'precio' => $_POST['precio']);
        setcookie("carrito[" . $_POST['id'] . "]", json_encode($arryCarrito), time() + 604800);
    }
    header("Location:carrito");
} elseif (isset($_POST['actualizar'])) {
}

if (countCarrito() > 0) {
    require "vistas/verCarrito.php";
} else {
    $dato = "El carrito esta vacío.<br><a href='index'>Volver a la tienda</a>";
    require "vistas/mensaje.php";
}


include "vistas/fin.html";
