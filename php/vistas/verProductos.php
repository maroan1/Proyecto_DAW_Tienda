<?php
echo "<div class='row m-0'>";
echo "<div class='estanteria col-12 col-md-10'>";
foreach ($datos as $dato => $fila) {
    echo "<a class='producto_estanteria' href='/Proyecto_DAW_Tienda/php/detalle/" . $fila['idProducto'] . "'>";
    echo "<img src='/Proyecto_DAW_Tienda/img/" . $fila['foto'] . "'>";
    echo "<span class='detalle_producto_estanteria'><span class='nombre_estanteria'>" . $fila['nombre'] . "</span><span class='precio_estanteria'>" . $fila['precio'] . " €</span></span></a>";
}
echo "</div><div class='col-2 banner bannerG2 d-none d-md-block'>
            <div class='vertical-center text-center'>Precios especiales por apertura</div>
        </div>
        <div class='col-12 banner bannerP2 d-md-none'>
            <div class='banner-titulo vertical-center'>Precios especiales por apertura</div>
        </div></div>";
