<?php
$precioTotal = 0;
echo "<div class='carrito_cuerpo'><form method='POST'><input class='carrito_boton_actualizar' type='submit' name='actualizar' value='Actualizar'>";
echo "<div class='tabla_carrito'><div class='carrito_cabecera_productos'><div>ID</div><div>Producto</div><div>Precio</div><div>Cantidad</div></div>";
// for ($i = 0; $i < $_SESSION['total']; $i++) {
//     if ($_SESSION['cantidad'][$i] > 0) {
//         echo "<div class='producto_carrito'><div>" . $_SESSION['id'][$i] . "</div><div>" . $_SESSION['nombre_producto'][$i] . "</div><div>" . $_SESSION['precio'][$i] . "€</div><div><input name='cantidad[]' type='number' value='" . $_SESSION['cantidad'][$i] . "' min=0></div></div>";
//         $precioTotal += $_SESSION['precio'][$i] * $_SESSION['cantidad'][$i];
//     } else {
//         echo "<div class='producto_carrito_vacio'><div>" . $_SESSION['id'][$i] . "</div><br><div>" . $_SESSION['nombre_producto'][$i] . "</div><br><div>" . $_SESSION['precio'][$i] . "</div><br><div><input name='cantidad[]' type='number' value='" . $_SESSION['cantidad'][$i] . "' min=0></div></div>";
//     }
// }
if (isset($_COOKIE['nombre'])) {
    $url = "http://localhost/Proyecto_DAW_Tienda/php/carritos/" . $_COOKIE['dni'];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $datos = json_decode(curl_exec($ch), true);
    curl_close($ch);
    foreach ($datos as $key => $value) {
        $url = "http://localhost/Proyecto_DAW_Tienda/php/producto/" . $value['idProducto'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $detalle = json_decode(curl_exec($ch), true);
        curl_close($ch);
        echo "<div class='producto_carrito'><div>" . $value['idProducto'] . "</div><div>" . $detalle['nombre'] . "</div><div>" . $value['precio'] . "€</div><div><input name='" . $value['idProducto'] . "' type='number' value='" . $value['cantidad'] . "' min=0></div></div>";
        $precioTotal += $value['precio'] * $value['cantidad'];
    }
} else {
    foreach ($_COOKIE['carrito'] as $key => $value) {
        $valores = json_decode($value, true);
        $url = "http://localhost/Proyecto_DAW_Tienda/php/producto/" . $valores['idProducto'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $detalle = json_decode(curl_exec($ch), true);
        curl_close($ch);
        echo "<div class='producto_carrito'><div>" . $valores['idProducto'] . "</div><div>" . $detalle['nombre'] . "</div><div>" . $valores['precio'] . "€</div><div><input name='" . $valores['idProducto'] . "' type='number' value='" . $valores['cantidad'] . "' min=0></div></div>";
        $precioTotal += $valores['precio'] * $valores['cantidad'];
    }
}

echo "<div class='carrito_precioTotal'>TOTAL $precioTotal €</div>";
echo "</div></form></div>";
echo "<a class='boton_carrito' href='index'> Seguir comprando </a>";
echo "<a class='boton_carrito' href='confirmar/" . countCarrito() . "'> Realizar compra </a>";
