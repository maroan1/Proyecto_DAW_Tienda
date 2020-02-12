<?php
include "vistas/inicio.html";
include "vistas/saludo.php";
$pActual = "carrito.php";
require "validar.php";
if (isset($_POST['comprar'])) {
    if (isset($_COOKIE['nombre'])) {
        $postData = array('dniCliente' => $_COOKIE['dni'], 'idProducto' => $_POST['id'], 'cantidad' => $_POST['cantidad'], 'precio' => $_POST['precio']);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/Proyecto_DAW_Tienda/php/carritos");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        //http_build_query => Generar una cadena de consulta codificada estilo URL a partir de array
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        print_r($data);
        curl_close($ch);
    } else {
        $existe = false;
        $cantidad = 0;
        foreach ($_COOKIE['carrito'] as $key => $value) {
            if ($key == $_POST['id']) {
                echo $key;
                $existe = true;
                $valor = json_decode($value, true);
                $cantidad = $valor['cantidad'] + $_POST['cantidad'];
            }
        }
        if ($existe) {
            echo "existe";
            $arryCarrito = array('idProducto' => $_POST['id'], 'cantidad' => $cantidad, 'precio' => $_POST['precio']);
            setcookie("carrito[" . $_POST['id'] . "]", json_encode($arryCarrito), time() + 604800);
        } else {
            echo "no existe";
            $arryCarrito = array('idProducto' => $_POST['id'], 'cantidad' => $_POST['cantidad'], 'precio' => $_POST['precio']);
            setcookie("carrito[" . $_POST['id'] . "]", json_encode($arryCarrito), time() + 604800);
        }
    }
    header("Location:carrito");
} elseif (isset($_POST['actualizar'])) {
    if (isset($_COOKIE['nombre'])) {
        $url = "http://localhost/Proyecto_DAW_Tienda/php/carritos/" . $_COOKIE['dni'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $datos = json_decode(curl_exec($ch), true);
        curl_close($ch);
        foreach ($datos as $key => $value) {
            $data = array("nombre" => 'usuario');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://localhost/Proyecto_DAW_Tienda/php/carritos/" . $_COOKIE['dni'] . "/" . $value['idProducto'] . "/" . $_POST[$value['idProducto']] . "/" . $value['precio']);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            $data = curl_exec($ch);
            print_r($data);
            curl_close($ch);
        }
        header("Location:carrito");
    } else {
        foreach ($_COOKIE['carrito'] as $key => $value) {
            $valores = json_decode($value, true);
            if ($_POST[$valores['idProducto']] > 0) {
                $valores['cantidad'] = $_POST[$valores['idProducto']];
                setcookie("carrito[" . $valores['idProducto'] . "]", json_encode($valores), time() + 604800);
                echo "modificado";
            } else {
                setcookie("carrito[" . $valores['idProducto'] . "]", '', -604800);
                echo "borrado";
            }
            header("Location:carrito");
        }
    }
}

if (countCarrito() > 0) {
    require "vistas/verCarrito.php";
} else {
    $dato = "El carrito esta vacío.<br><a href='index'>Volver a la tienda</a>";
    require "vistas/mensaje.php";
}


include "vistas/fin.html";
