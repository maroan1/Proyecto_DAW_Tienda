<?php
if (isset($_COOKIE['nombre'])) {
    echo "<div class='tienda_menu text-center'><a href='/Proyecto_DAW_Tienda/php/index' class='btn btn-outline-light float-left'> INICIO </a> Bienvenid@ " . $_COOKIE['nombre'] . " <a class='btn btn-outline-danger' href='" . $pActual . "?logout=1'> Desconectar </a>" . "<a href='/Proyecto_DAW_Tienda/php/carrito'><span class='carrito_icono'><img src='/Proyecto_DAW_Tienda/img/cart.png'><span class='carrito_total'>" . countCarrito() . "</span></span></a></div>";
} else {
    echo "<div class='tienda_menu text-center'><a href='/Proyecto_DAW_Tienda/php/index' class='btn btn-outline-light float-left'> INICIO </a> Bienvenid@ Invitad@" . " " . " <form class='form-inline' action='' method='post'>Dni:<input class='input_login' name='dni' type='text'> Contraseña:<input class='input_login' type='password' name='contr'> <input class='btn btn-outline-success' type='submit' name='login'></form>" . "<a href='/Proyecto_DAW_Tienda/php/carrito'><span class='carrito_icono'><img src='/Proyecto_DAW_Tienda/img/cart.png'><span class='carrito_total'>" . countCarrito() . "</span></span></a></div>";
}

function countCarrito()
{
    $count = 0;
    if (isset($_COOKIE['nombre'])) {
        $url = "http://localhost/Proyecto_DAW_Tienda/php/carritos/" . $_COOKIE['dni'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $datos = json_decode(curl_exec($ch), true);
        curl_close($ch);
        $count = count($datos);
    } elseif (isset($_COOKIE['carrito'])) {
        $count = count($_COOKIE['carrito']);
    }
    return $count;
}
