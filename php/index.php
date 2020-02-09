<?php
session_start();

include "vistas/inicio.html";
include "vistas/spanCarrito.php";
$pActual = "index.php";
require "validar.php";
$url = "http://localhost/Proyecto_DAW_Tienda/php/producto";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$datos = json_decode(curl_exec($ch), true);
curl_close($ch);
require "vistas/verProductos.php";
    // include "vistas/fin.html";
