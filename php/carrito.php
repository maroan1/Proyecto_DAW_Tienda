<?php
session_start();
require "modelo.php";
include "vistas/inicio.html";
include "vistas/saludo.php";
if (isset($_SESSION['nombre'])) {
    if (isset($_POST['comprar'])) {
        Carrito::Linea_producto_carrito($_POST['id'], $_POST['nombre'], $_POST['precio'], $_POST['cantidad']);
        $_SESSION['total']++;
    } elseif (isset($_POST['actualizar'])) {
        // print_r($_POST['cantidad']);
        Carrito::actualizar_cantidades_carrito($_POST['cantidad']);
    }


    if ($_SESSION['total'] > 0) {
        require "vistas/verCarrito.php";
        // print_r($_SESSION);
    } else {
        $dato = "El carrito esta vacío.<br><a href='principal.php'>Volver a la tienda</a>";
        require "vistas/mensaje.php";
    }
} else {
    $dato = "No tienes permiso para entrar a esta página, por favor logueate como cliente.<br>Ir al <a href='validar.php'>login</a>.";
    require "vistas/mensaje.php";
}


include "vistas/fin.html";
