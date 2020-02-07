<?php
echo "<div class='estanteria'>";
while ($fila = $datos->fetch(PDO::FETCH_ASSOC)) {
    echo "<a class='producto_estanteria' href='/Proyecto-DAW/php/detalle.php?id=" . $fila['idProducto'] . "'>";
    echo "<img src='/Proyecto-DAW/img/" . $fila['foto'] . "'>";
    echo "<span class='detalle_producto_estanteria'><span class='nombre_estanteria'>" . $fila['nombre'] . "</span><span class='precio_estanteria'>" . $fila['precio'] . " €</span></span></a>";
}
echo "</div>";
