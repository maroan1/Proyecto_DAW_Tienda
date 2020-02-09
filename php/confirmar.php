<?php
include "vistas/inicio.html";
if (isset($_COOKIE['nombre'])) {
    if ($_GET['total'] > 0) {
        $precioTotal = 0;

        $fecha = DateTime::createFromFormat('Y-m-d', $pedido->__get('fecha'));
        $dato = "<div class='detalle_pedido_cuerpo'><div class='detalle_pedido_datos'>";
        $dato .= "<div>ID: " . $pedido->__get('idPedido') . "</div>";
        $dato .= "<div>Fecha: " . $fecha->format('d-m-Y') . "</div>";
        $dato .= "<div>DNI Cliente: " . $pedido->__get('dniCliente') . "</div></div><div class='detalle_pedido_tabla'>";
        $dato .= "<div class='detalle_pedido_cabecera'><div>ID</div><div>Producto</div><div>Precio</div><div>Cantidad</div></div>";
        for ($i = 0; $i < $_SESSION['total']; $i++) {
            if ($_SESSION['cantidad'][$i] > 0) {
                $dato .= "<div class='detalle_pedido_linea'><div>" . $_SESSION['id'][$i] . "</div><div>" . $_SESSION['nombre_producto'][$i] . "</div><div>" . $_SESSION['precio'][$i] . "€</div><div>" . $_SESSION['cantidad'][$i] . "</div></div>";
                $precioTotal += $_SESSION['precio'][$i] * $_SESSION['cantidad'][$i];
            }
        }
        $dato .= "</div>";
        $dato .= "<div class='detalle_pedido_precioTotal'>TOTAL: $precioTotal €</div></div>";
        require "vistas/mensaje.php";
    } else {
        $dato = "El carrito esta vacío.<br><a href='index'>Volver a la tienda</a>";
        require "vistas/mensaje.php";
    }
} else {
    $dato = "Debes de loguearte antes de realizar la compra.<br><a href='carrito'>Volver al carrito</a>.";
    require "vistas/mensaje.php";
}


include "vistas/fin.html";
