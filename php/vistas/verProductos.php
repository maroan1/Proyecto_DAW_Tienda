<?php
echo "<div class='estanteria'>";
foreach ($datos as $dato => $fila) {
    echo "<a class='producto_estanteria' href='/Proyecto_DAW_Tienda/php/detalle.php?id=" . $fila['idProducto'] . "'>";
    echo "<img src='/Proyecto_DAW_Tienda/img/" . $fila['foto'] . "'>";
    echo "<span class='detalle_producto_estanteria'><span class='nombre_estanteria'>" . $fila['nombre'] . "</span><span class='precio_estanteria'>" . $fila['precio'] . " €</span></span></a>";
}
echo "</div>";
