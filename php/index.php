<?php
session_start();

include "vistas/inicio.html";
include "vistas/spanCarrito.php";
require "modelo.php";
$base = new Bd();
$datos = Producto::getAll($base->link);
require "vistas/verProductos.php";
    // include "vistas/fin.html";
