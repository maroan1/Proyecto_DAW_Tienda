<?php
session_start();
include "vistas/inicio.html";
$pActual = "/Proyecto_DAW_Tienda/php/detalle/" . $_GET['id'];
include "vistas/spanCarrito.php";
require "validar.php";

if (isset($_GET['id'])) {
    $url = "http://localhost/Proyecto_DAW_Tienda/php/producto/" . $_GET['id'];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $detalle = json_decode(curl_exec($ch), true);
    // $data = curl_exec($ch);
    // print_r($data);
    curl_close($ch);
    $url = "https://theaudiodb.com/api/v1/json/1/searchalbum.php?s=" . urlencode($detalle['autor']) . "&a=" . urlencode($detalle['nombre']);
    // $url = "https://theaudiodb.com/api/v1/json/1/searchalbum.php?s=AC/DC&a=Black%20Ice&s=AC/DC&a=Black%20Ice";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $infoApiAlbum = json_decode(curl_exec($ch), true);
    curl_close($ch);
    $url = "https://theaudiodb.com/api/v1/json/1/search.php?s=" . urlencode($detalle['autor']);
    // $url = "https://theaudiodb.com/api/v1/json/1/searchalbum.php?s=AC/DC&a=Black%20Ice&s=AC/DC&a=Black%20Ice";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $infoApiAutor = json_decode(curl_exec($ch), true);
    curl_close($ch);

    require "vistas/verDetalle.php";
} else {
    $dato = "Has llegado a esta página por accidente T.T";
    require "vistas/mensaje.php";
}
include "vistas/fin.html";
