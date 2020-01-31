<?php
session_start();
require "modelo.php";
include "vistas/inicio.html";
if (isset($_SESSION['nombre'])) {
    if ($_SESSION['total'] > 0) {
        $precioTotal = 0;
        $base = new Bd();
        $pedido = new Pedido();
        $pedido->obtener_Nid($base->link);
        $pedido->create_session_pedido();
        $pedido->insertar($base->link);
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
        $base->link->close();
        session_destroy();
    } else {
        $dato = "El carrito esta vacío.<br><a href='principal.php'>Volver a la tienda</a>";
        require "vistas/mensaje.php";
    }
} else {
    $dato = "No tienes permiso para entrar a esta página, por favor logueate como cliente.<br>Ir al <a href='validar.php'>login</a>.";
    require "vistas/mensaje.php";
}


include "vistas/fin.html";
