<?php
if ($infoApiAutor!=null) {
    if (strlen($infoApiAutor['artists'][0]['strArtistThumb'])>0) {
        echo "<div class='imagenAutor'>";
        echo "<img src='".$infoApiAutor['artists'][0]['strArtistThumb']."'>";
        echo "</div>";
    }

    if (strlen($infoApiAutor['artists'][0]['strArtistLogo'])>0) {
        echo "<div class='logoAutor'>";
        echo "<img src='".$infoApiAutor['artists'][0]['strArtistLogo']."'>";
        echo "</div>";
    }
}
echo "<div class='detalle_base'>";

echo "<div class='detalle_foto'><img src='/Proyecto_DAW_Tienda/img/" . $detalle['foto'] . "'></div>";

echo "<div class='detalle_datos'>";
echo "<header><h1>" . $detalle['nombre'] . "</h1></header>";

echo "<p><b>idProducto: </b> " . $detalle['idProducto'] . " </p>";
echo "<p><b>Idioma: </b> " . $detalle['idioma'] . " </p>";
echo "<p><b>Autor: </b> " . $detalle['autor'] . " </p>";
echo "<p><b>Categoria: </b> " . $detalle['categoria'] . " </p>";
echo "<p><b>Año: </b> " . $detalle['anyo'] . " </p>";
echo "<p><b>Stock: </b> " . $detalle['unidades'] . " unidades </p>";
echo "<p><b>Precio: </b> " . $detalle['precio'] . "€ </p>";
echo "<form action='http://localhost/Proyecto_DAW_Tienda/php/carrito' method='post'>
    <input type='number' name='cantidad' value=1 min=1 max=" . $detalle['unidades'] . " >";
echo "<input type='hidden' name='id' value='" . $detalle['idProducto'] . "'>";
echo "<input type='hidden' name='precio' value='" . $detalle['precio'] . "'>";
echo "<input type='submit' name='comprar' value='Enviar a carrito' ></form></div>";
if ($infoApiAlbum!=null && strlen($infoApiAlbum['album'][0]['strDescriptionES'])>0) {
    echo "<div class='detalle_datos'>";
    echo $infoApiAlbum['album'][0]['strDescriptionES'];
    echo "</div>";
}
echo "</div>";
