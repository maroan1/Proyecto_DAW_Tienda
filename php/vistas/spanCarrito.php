<?php
if (isset($_COOKIE['nombre'])) {
    echo "<div class='tienda_menu'>Bienvenid@ " . $_COOKIE['nombre'] . "<a href='validar.php?logout=1'>Desconectar</a>" . "<a href='carrito.php'><span class='carrito_icono'><img src='/Proyecto-DAW/img/cart.png'><span class='carrito_total'>" . $_SESSION['total'] . "</span></span></a></div>";
} else {
    echo "<div class='tienda_menu'>Bienvenid@ Invitad@" . " " . "<form action='' method='post'>Dni: <input name='dni' type='text'> Contraseña: <input type='password' name='contr'> <input type='submit' name='login'></form>" . "<a href='carrito.php'><span class='carrito_icono'><img src='/Proyecto-DAW/img/cart.png'><span class='carrito_total'>" . 0 . "</span></span></a></div>";
}
