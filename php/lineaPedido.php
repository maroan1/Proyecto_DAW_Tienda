<?php

include "modelo.php";

$base = new Bd();

/*
    listar todos los posts o solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idPedido'])) {
        $pedido = new Linea_pedido($_GET['idPedido'], '', '', '', '');
        $dato = $pedido->buscarPedido($base->link);
        $dato->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($dato->fetchAll());
        exit();
    }
    // } else {
    //     //Mostrar lista de post
    //     $dato = Linea_pedido::getAll($base->link);
    //     $dato->setFetchMode(PDO::FETCH_ASSOC);
    //     header("HTTP/1.1 200 OK");
    //     echo json_encode($dato->fetchAll());
    //     exit();
    // }
}

// Crear un nuevo post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pedido = new Linea_pedido($_POST['idPedido'], null, $_POST['idProducto'], $_POST['cantidad'], $_POST['precio']);
    $text = $pedido->insertar($base->link);
    echo json_encode($text);
    header("HTTP/1.1 200 OK");
    exit();
}

//Borrar
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    $pedido = new Pedido('');
    $pedido->__set('idPedido', $_GET['idPedido']);
    if ($dato = $pedido->eliminar($base->link)) {
        header("HTTP/1.1 200 OK");
        echo json_encode($dniCliente);
        exit();
    }
}

//Actualizar
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $pedido = new Pedido($_GET['dniCliente']);
    $pedido->__set('idPedido', $_GET['idPedido']);
    $pedido->__set('fecha', $_GET['fecha']);
    $text = $pedido->modificar($base->link);
    header("HTTP/1.1 200 OK");
    echo json_encode($text);
    exit();
}


//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");
