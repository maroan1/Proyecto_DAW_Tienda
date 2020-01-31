<?php
require "modelo.php";

$accion = $_POST["accion"];

if ($accion == "AllUsers") {
    $base = new Bd();
    $dato = Cliente::getAll($base->link);
    $arrayDatos;
    while ($valor = $dato->fetch_assoc()) {
        $valor['pwd'] = '';
        $arrayDatos['usuarios'][] = $valor;
    }
    $json = json_encode($arrayDatos);
    echo $json;
    $base->link->close();
} elseif ($accion == "insertUser") {
    $base = new Bd();
    $user = new Cliente($_POST['dni'], $_POST['nombre'], $_POST['direccion'], $_POST['email'], 'password', '0');
    $arrayDatos;
    if ($result = $user->insertar($base->link)) {
        if ($result == "DNI duplicado") {
            $arrayDatos["Insertado"] = false;
            $arrayDatos["Mensaje"] = "El dni introducido esta ya en la base de datos";
        } else {
            $arrayDatos["Insertado"] = true;
            $arrayDatos["Mensaje"] = "Usuario " . $user->__get('nombre') . " se ha insertado satisfactoriamente.";
        }
    } else {
        $arrayDatos["Insertado"] = false;
        $arrayDatos["Mensaje"] = "Fallo al insertar usuario.";
    }

    $json = json_encode($arrayDatos);
    echo $json;
    $base->link->close();
} elseif ($accion == "modUser") {
    $base = new Bd();
    $user = new Cliente($_POST['dni'], $_POST['nombre'], $_POST['direccion'], $_POST['email'], 'password', '0');
    $arrayDatos;
    if ($user->modificar($base->link)) {
        $arrayDatos["modificado"] = true;
        $arrayDatos["mensaje"] = "Usuario " . $user->__get('nombre') . " se ha modificado satisfactoriamente.";
    } else {
        $arrayDatos["modificado"] = false;
        $arrayDatos["mensaje"] = "Fallo al modificar usuario.";
    }
    $json = json_encode($arrayDatos);
    echo $json;
    $base->link->close();
} elseif ($accion == "loadUser") {
    $base = new Bd();
    $user = new Cliente($_POST['dni'], '', '', '', 'password', '0');
    if ($result = $user->buscar($base->link)) {
        $arrayDatos["cargado"] = true;
        $arrayDatos["usuario"] = $result;
    } else {
        $arrayDatos["cargado"] = false;
        $arrayDatos["mensaje"] = "Usuario no encontrado";
    }
    $json = json_encode($arrayDatos);
    echo $json;
    $base->link->close();
} elseif ($accion == "deleteUser") {
    $base = new Bd();
    $user = new Cliente($_POST['dni'], '', '', '', 'password', '0');
    if ($user->eliminar($base->link)) {
        $arrayDatos["eliminado"] = true;
        $arrayDatos["mensaje"] = "Usuario eliminado con éxito";
    } else {
        $arrayDatos["eliminado"] = false;
        $arrayDatos["mensaje"] = "Fallo al eliminar usuario";
    }
    $json = json_encode($arrayDatos);
    echo $json;
    $base->link->close();
} else {
    $result["mensaje"] = "no ha cargado ninguna función php";
    $json = json_encode($result);
    echo $json;
}
