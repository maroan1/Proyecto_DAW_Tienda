<?php

include "utils.php";
include "modelo.php";

$base= new Bd();

/*
  listar todos los posts o solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['dniCliente'])) {
        //Mostrar un post
        $cli= new Cliente($_GET['dniCliente'], '', '', '', '', '');
        $dato=$cli->buscar($base->link);
        header("HTTP/1.1 200 OK");
        echo json_encode($dato);
        exit();
    } else {
        //Mostrar lista de post
        $dato=Cliente::getAll($base->link);
        $dato->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($dato->fetchAll());
        exit();
    }
}

// Crear un nuevo post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cli= new Cliente($_POST['dniCliente'], $_POST['nombre'], $_POST['direccion'], $_POST['email'], $_POST['pwd'], $_POST['administrador']);
    if (!$cli->buscar($base->link)) {
        $cli->insertar($base->link);
        header("HTTP/1.1 200 OK");
        echo json_encode($_POST['dniCliente']);
        exit();
    }
}

//Borrar
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $dniCliente = $_GET['dniCliente'];
    $cli= new Cliente($dniCliente, '', '', '', '', '');
    if ($dato=$cli->eliminar($base->link)) {
        header("HTTP/1.1 200 OK");
        echo json_encode($dniCliente);
        exit();
    }
}

//Actualizar
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $cli= new Cliente($_GET['dniCliente'], $_GET['nombre'], $_GET['direccion'], $_GET['email'], '', $_GET['administrador']);
    $text = $cli->modificar($base->link);
    header("HTTP/1.1 200 OK");
    echo json_encode($text);
    exit();
}


//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");
