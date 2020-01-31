<?php
echo "<div class='tienda_menu'>Bienvenid@ " . $_SESSION['nombre'] . "<a href='carrito.php'><span class='carrito_icono'><img src='/Proyecto-DAW/img/cart.png'><span class='carrito_total'>" . $_SESSION['total'] . "</span></span></a></div>";
