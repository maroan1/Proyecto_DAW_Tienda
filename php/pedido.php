<?php

include "modelo.php";

$base = new Bd();

/*
  listar todos los posts o solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idPedido'])) {
        //!ESTA ES LA MANERA DE MOSTRAR MÁS DE UN RESULTADO
        $pedido = new Pedido($_GET['dniCliente'], '', '', '');
        $dato = $pedido->cargarPedido($base->link);
        $dato->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($dato->fetchAll());
        exit();
    } else {
        //Mostrar lista de post
        $dato = Pedido::getAll($base->link);
        $dato->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($dato->fetchAll());
        exit();
    }
}

// Crear un nuevo post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pedido = new Pedido($_POST['dniCliente'], $_POST['idProducto'], $_POST['cantidad'], $_POST['precio']);
    $pedido->insertar($base->link);
    header("HTTP/1.1 200 OK");
    // echo json_encode($_POST['dniCliente']);
    echo $pedido->__get('dniCliente') . " " . $pedido->__get('idProducto') . " " . $pedido->__get('cantidad') . " " . $pedido->__get('precio');
    exit();
}

//Borrar
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if ($_GET['dniCliente'] && $_GET['idProducto']) {
        $pedido = new Pedido($_GET['dniCliente'], $_GET['idProducto'], '', '');
        if ($dato = $pedido->eliminar($base->link)) {
            header("HTTP/1.1 200 OK");
            echo "Eliminado";
            exit();
        }
    } else {
        $dniCliente = $_GET['dniCliente'];
        $pedido = new Pedido($dniCliente, '', '', '');
        if ($dato = $pedido->eliminarPedido($base->link)) {
            header("HTTP/1.1 200 OK");
            echo json_encode($dniCliente);
            exit();
        }
    }
}

//Actualizar
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $pedido = new Pedido($_GET['dniCliente'], $_GET['idProducto'], $_GET['cantidad'], $_GET['precio']);
    $text = $pedido->modificar($base->link);
    header("HTTP/1.1 200 OK");
    echo json_encode($text);
    exit();
}


//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");
