<?php

include "modelo.php";

$base = new Bd();

/*
  listar todos los productos o solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idProducto'])) {
        //Mostrar un post
        $prod = new Producto($_GET['idProducto'], '', '', '', '', '', '', '', '');
        $dato = $prod->buscar($base->link);
        header("HTTP/1.1 200 OK");
        echo json_encode($dato);
        exit();
    } else {
        //Mostrar lista de post
        $dato = Producto::getAll($base->link);
        $dato->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($dato->fetchAll());
        exit();
    }
}

// Crear un nuevo producto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prod = new Producto('', $_POST['nombre'], $_POST['idioma'], $_POST['foto'], $_POST['autor'], $_POST['categoria'], $_POST['anyo'], $_POST['unidades'], $_POST['precio']);
    if (!$prod->buscar($base->link)) {
        $prod->insertar($base->link);
        header("HTTP/1.1 200 OK");
        echo json_encode($_POST['idProducto']);
        exit();
    }
}

//Borrar
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $prod = new Producto($_GET['idProducto'], '', '', '', '', '', '', '', '');
    if ($dato = $prod->eliminar($base->link)) {
        header("HTTP/1.1 200 OK");
        echo json_encode($dniProducto);
        exit();
    }
}

//Actualizar
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $prod = new Producto($_GET['idProducto'], $_GET['nombre'], '', $_GET['foto'], $_GET['autor'], '', '', '', $_GET['precio']);
    $text = $prod->modificar($base->link);
    header("HTTP/1.1 200 OK");
    echo json_encode($text);
    exit();
}


//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");
