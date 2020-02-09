<?php
if (isset($_COOKIE['nombre'])) {
    echo "<div class='tienda_menu'>Bienvenid@ " . $_COOKIE['nombre'] . "<a href='validar.php?logout=1'>Desconectar</a>" . "</div>";
} else {
    echo "<div class='tienda_menu'>Bienvenid@ Invitad@" . " " . "<form action='' method='post'>Dni: <input name='dni' type='text'> Contraseña: <input type='password' name='contr'> <input type='submit' name='login'></form>" . "</div>";
}
