<?php
require "modelo.php";
$base = new Bd();
$producto = new Producto('', 'PRUEBA', '', '', '', '', '', '', '');
$producto->insertar($base->link);
