<?php
session_start();
include "vistas/inicio.html";
include "vistas/spanCarrito.php";
if (isset($_SESSION['nombre'])) {

    if (isset($_GET['id'])) {
        require "modelo.php";
        $base = new Bd();
        $producto = new Producto($_GET['id'], '', '', '', '', '', '', '', '');
        $detalle = $producto->buscar($base->link);
        require "vistas/verDetalle.php";
        $base->link->close();
    } else {
        $dato = "Has llegado a esta página por accidente T.T";
        require "vistas/mensaje.php";
    }
} else {
    $dato = "No tienes permiso para entrar a esta página, por favor logueate como cliente.<br>Ir al <a href='validar.php'>login</a>.";
    require "vistas/mensaje.php";
}
include "vistas/fin.html";
