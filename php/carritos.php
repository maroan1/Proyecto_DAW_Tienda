<?php

include "modelo.php";

$base = new Bd();

/*
  listar todos los posts o solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idProducto']) && isset($_GET['dniCliente'])) {
        $cart = new Carrito($_GET['dniCliente'], $_GET['idProducto'], '', '');
        $dato = $cart->buscar($base->link);
        header("HTTP/1.1 200 OK");
        echo json_encode($dato);
        exit();
    } elseif (isset($_GET['dniCliente'])) {
        //!ESTA ES LA MANERA DE MOSTRAR MÁS DE UN RESULTADO
        $cart = new Carrito($_GET['dniCliente'], '', '', '');
        $dato = $cart->cargarCarrito($base->link);
        $dato->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($dato->fetchAll());
        exit();
    } else {
        //Mostrar lista de post
        $dato = Carrito::getAll($base->link);
        $dato->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($dato->fetchAll());
        exit();
    }
}

// Crear un nuevo post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart = new Carrito($_POST['dniCliente'], $_POST['idProducto'], $_POST['cantidad'], $_POST['precio']);
    if (!$cart->buscar($base->link)) {
        $cart->insertar($base->link);
        header("HTTP/1.1 200 OK");
        // echo json_encode($_POST['dniCliente']);
        echo $cart->__get('dniCliente') . " " . $cart->__get('idProducto') . " " . $cart->__get('cantidad') . " " . $cart->__get('precio');
        exit();
    }
}

//Borrar
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if ($_GET['dniCliente'] && $_GET['idProducto']) {
        $cart = new Carrito($_GET['dniCliente'], $_GET['idProducto'], '', '');
        if ($dato = $cart->eliminar($base->link)) {
            header("HTTP/1.1 200 OK");
            echo "Eliminado";
            exit();
        }
    } else {
        $dniCliente = $_GET['dniCliente'];
        $cart = new Carrito($dniCliente, '', '', '');
        if ($dato = $cart->eliminarCarrito($base->link)) {
            header("HTTP/1.1 200 OK");
            echo json_encode($dniCliente);
            exit();
        }
    }
}

//Actualizar
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $cart = new Carrito($_GET['dniCliente'], $_GET['idProducto'], $_GET['cantidad'], $_GET['precio']);
    $text = $cart->modificar($base->link);
    header("HTTP/1.1 200 OK");
    echo json_encode($text);
    exit();
}


//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");
