<?php
if (isset($_GET['logout'])) {
    setcookie('nombre', '', -604800);
    setcookie('dni', '', -604800);
    header("Location:" . $pActual);
} else {
    if (isset($_POST['login'])) {
        $url = "http://localhost/Proyecto_DAW_Tienda/php/cliente/" . $_POST['dni'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = json_decode(curl_exec($ch), true);
        // $data = curl_exec($ch);
        // print_r($data);
        curl_close($ch);
        if (password_verify($_POST['contr'], $data['pwd'])) {
            setcookie('dni', $data['dniCliente'], time() + 604800);
            setcookie('nombre', $data['nombre'], time() + 604800);
            if (isset($_COOKIE['carrito'])) {
                foreach ($_COOKIE['carrito'] as $key => $value) {
                    $valores = json_decode($value, true);
                    $postData = array('dniCliente' => $_POST['dni'], 'idProducto' => $valores['idProducto'], 'cantidad' => $valores['cantidad'], 'precio' => $valores['precio']);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "http://localhost/Proyecto_DAW_Tienda/php/carritos");
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_setopt($ch, CURLOPT_POST, true);
                    //http_build_query => Generar una cadena de consulta codificada estilo URL a partir de array  
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $data = curl_exec($ch);
                    // print_r($data);
                    curl_close($ch);
                }
                // BORRAMOS LAS COOKIES DEL CARRITO
                foreach ($_COOKIE['carrito'] as $key => $value) {
                    setcookie('carrito[' . $key . ']', '', -604800);
                }
            }
            header("Location:" . $pActual);
        } else {
            $dato = "<div class='text-danger '>Contraseña o DNI incorrectos.</div>";
            require "vistas/mensaje.php";
        }
    }
}
