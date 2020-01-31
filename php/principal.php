<?php
session_start();
if (isset($_SESSION['nombre'])) {
    include "vistas/inicio.html";
    include "vistas/spanCarrito.php";
    require "modelo.php";
    $base = new Bd();
    $datos = Producto::getAll($base->link);
    require "vistas/verProductos.php";
    // include "vistas/fin.html";
    $base->link->close();
} else {
    $dato = "No tienes permiso para entrar a esta página, por favor logueate como cliente.<br>Ir al <a href='validar.php'>login</a>.";
    require "vistas/mensaje.php";
}
