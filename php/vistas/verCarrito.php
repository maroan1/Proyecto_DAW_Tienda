<?php
$precioTotal = 0;
echo "<div class='carrito_cuerpo'><form method='POST' ><input class='carrito_boton_actualizar' type='submit' name='actualizar' value='Actualizar'>";
echo "<div class='tabla_carrito'><div class='carrito_cabecera_productos'><div>ID</div><div>Producto</div><div>Precio</div><div>Cantidad</div></div>";
for ($i = 0; $i < $_SESSION['total']; $i++) {
    if ($_SESSION['cantidad'][$i] > 0) {
        echo "<div class='producto_carrito'><div>" . $_SESSION['id'][$i] . "</div><div>" . $_SESSION['nombre_producto'][$i] . "</div><div>" . $_SESSION['precio'][$i] . "€</div><div><input name='cantidad[]' type='number' value='" . $_SESSION['cantidad'][$i] . "' min=0></div></div>";
        $precioTotal += $_SESSION['precio'][$i] * $_SESSION['cantidad'][$i];
    } else {
        echo "<div class='producto_carrito_vacio'><div>" . $_SESSION['id'][$i] . "</div><br><div>" . $_SESSION['nombre_producto'][$i] . "</div><br><div>" . $_SESSION['precio'][$i] . "</div><br><div><input name='cantidad[]' type='number' value='" . $_SESSION['cantidad'][$i] . "' min=0></div></div>";
    }
}
echo "<div class='carrito_precioTotal'>TOTAL $precioTotal €</div>";
echo "</div></form></div>";
echo "<a class='boton_carrito' href='principal.php'> Seguir comprando </a>";
echo "<a class='boton_carrito' href='confirmar.php'> Realizar compra </a>";
