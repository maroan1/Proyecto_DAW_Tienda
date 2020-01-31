<?php
require "modelo.php";

$accion = $_POST["accion"];

// if ($accion == "AllPedidos") {
//     $base = new Bd();
//     $dato = Pedido::getAll($base->link);
//     $arrayDatos;
//     while ($valor = $dato->fetch_assoc()) {
//         $arrayDatos['pedidos'][] = $valor;
//     }
//     // $dnis = Cliente::getAll($base->link);
//     // while ($valor = $dnis->fetch_assoc()) {
//     //     $arrayDatos['dnis'][] = $valor['dniCliente'];
//     // }

//     $json = json_encode($arrayDatos);
//     echo $json;
//     $base->link->close();
// } elseif ($accion == "loadSelects") {
//     $base = new Bd();
//     $dato = Producto::getAll($base->link);
//     $arrayDatos;
//     while ($valor = $dato->fetch_assoc()) {
//         $arrayDatos['productos'][] = ['idProducto' => $valor['idProducto'], 'nombre' => $valor['nombre']];
//     }
//     $dnis = Cliente::getAll($base->link);
//     while ($valor = $dnis->fetch_assoc()) {
//         $arrayDatos['dnis'][] = $valor['dniCliente'];
//     }

//     $json = json_encode($arrayDatos);
//     echo $json;
//     $base->link->close();
// } elseif ($accion == "insertPedido") {
//     $base = new Bd();
//     $pedido = new Pedido();
//     $pedido->__set('fecha', $_POST['fecha']);
//     $pedido->__set('dniCliente', $_POST['dni']);
//     $arrayDatos;
//     if ($pedido->insertar($base->link)) {
//         $arrayDatos["Insertado"] = true;
//         $arrayDatos["Mensaje"] = "Pedido insertado satisfactoriamente.";
//     } else {
//         $arrayDatos["Insertado"] = false;
//         $arrayDatos["Mensaje"] = "Fallo al insertar pedido.";
//     }

//     $json = json_encode($arrayDatos);
//     echo $json;
//     $base->link->close();
// } elseif ($accion == "modPedido") {
//     $base = new Bd();
//     $pedido = new Pedido();
//     $pedido->__set('fecha', $_POST['fecha']);
//     $pedido->__set('dniCliente', $_POST['dni']);
//     $arrayDatos;
//     if ($pedido->modificar($base->link)) {
//         $arrayDatos["modificado"] = true;
//         $arrayDatos["mensaje"] = "Pedido " . $pedido->__get('nombre') . " se ha modificado satisfactoriamente.";
//     } else {
//         $arrayDatos["modificado"] = false;
//         $arrayDatos["mensaje"] = "Fallo al modificar pedido.";
//     }
//     $json = json_encode($arrayDatos);
//     echo $json;
//     $base->link->close();
// } elseif ($accion == "loadPedido") {
//     $base = new Bd();
//     $pedido = new Pedido();
//     $pedido->__set('idPedido', $_POST['id']);
//     if ($result = $pedido->buscar($base->link)) {
//         $arrayDatos["cargado"] = true;
//         $arrayDatos["pedido"] = $result;
//     } else {
//         $arrayDatos["cargado"] = false;
//         $arrayDatos["mensaje"] = "Pedido no encontrado";
//     }
//     $json = json_encode($arrayDatos);
//     echo $json;
//     $base->link->close();
// } elseif ($accion == "deletePedido") {
//     $base = new Bd();
//     $pedido = new Pedido();
//     $pedido->__set('idPedido', $_POST['id']);
//     if ($pedido->eliminar($base->link)) {
//         $arrayDatos["eliminado"] = true;
//         $arrayDatos["mensaje"] = "Pedido eliminado con éxito";
//     } else {
//         $arrayDatos["eliminado"] = false;
//         $arrayDatos["mensaje"] = "Fallo al eliminar pedido";
//     }
//     $json = json_encode($arrayDatos);
//     echo $json;
//     $base->link->close();
// } elseif ($accion == "misLineasPedido") {
//     $base = new Bd();
//     $linea = new Linea_pedido($_POST['id'], '', '', '');
//     $datos = $linea->buscarPedido($base->link);
//     $arrayDatos;
//     $arrayDatos['funciona'] = true;
//     if ($datos) {
//         $arrayDatos['funciona'] = true;
//         while ($valor = $datos->fetch_assoc()) {
//             $arrayDatos['lineas'][] = $valor;
//         }
//     } else {
//         $arrayDatos['lineas'] = "Sin líneas";
//     }
//     $json = json_encode($arrayDatos);
//     echo $json;
// } elseif ($accion == "deleteLinea") {
//     $base = new Bd();
//     $linea = new Linea_pedido($_POST['id'], $_POST['nlinea'], '', '');
//     $arrayDatos;
//     if ($linea->eliminar($base->link)) {
//         $arrayDatos['funciona'] = true;
//         $arrayDatos['mensaje'] = "Linea eliminada correctamente.";
//     } else {
//         $arrayDatos['funciona'] = false;
//         $arrayDatos['mensaje'] = "Fallo al eliminar lineaPedido.";
//     }
//     $json = json_encode($arrayDatos);
//     echo $json;
// } else {
//     $result["funciona"] = false;
//     $result["mensaje"] = "no ha cargado ninguna función php";
//     $json = json_encode($result);
//     echo $json;
// }
