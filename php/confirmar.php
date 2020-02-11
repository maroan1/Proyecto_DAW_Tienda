<?php
include "vistas/inicio.html";
if (isset($_COOKIE['nombre'])) {
    if ($_GET['total'] > 0) {
        $precioTotal = 0;
        //*GUARDO EL PEDIDO Y BORRO EL CARRITO SI TODO ES CORRECTO
        $postData = array('dniCliente' => $_COOKIE['dni']);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/Proyecto_DAW_Tienda/php/pedido");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        //http_build_query => Generar una cadena de consulta codificada estilo URL a partir de array  
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = json_decode(curl_exec($ch), true);
        // print_r($data);
        curl_close($ch);



        $fecha = DateTime::createFromFormat('Y-m-d', $data['fecha']);
        $idPedido = $data['idPedido'];
        sleep(2);
        //*PIDO LAS LINEAS DEL PEDIDO PARA CREAR LA FACTURA
        $url = "http://localhost/Proyecto_DAW_Tienda/php/lineaPedido/" . $idPedido;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $datos = json_decode(curl_exec($ch), true);
        print_r($datos);
        curl_close($ch);

        $dato = "<div class='detalle_pedido_cuerpo'><div class='detalle_pedido_datos'>";
        $dato .= "<div>ID: " . $idPedido . "</div>";
        $dato .= "<div>Fecha: " . $fecha->format('d-m-Y') . "</div>";
        $dato .= "<div>DNI Cliente: " . $_COOKIE['dni'] . "</div></div><div class='detalle_pedido_tabla'>";
        $dato .= "<div class='detalle_pedido_cabecera'><div>ID</div><div>Producto</div><div>Precio</div><div>Cantidad</div></div>";

        foreach ($datos as $key => $value) {
            $url = "http://localhost/Proyecto_DAW_Tienda/php/producto/" . $value['idProducto'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $detalle = json_decode(curl_exec($ch), true);
            curl_close($ch);
            $dato .= "<div class='detalle_pedido_linea'><div>" . $value['idProducto'] . "</div><div>" . $detalle['nombre'] . "</div><div>" . $value['precio'] . "€</div><div>" . $value['cantidad'] . "</div></div>";
            $precioTotal += $value['precio'] * $value['cantidad'];
        }


        $dato .= "</div>";
        $dato .= "<div class='detalle_pedido_precioTotal'>TOTAL: $precioTotal €</div></div><br>";
        require "vistas/mensaje.php";
    } else {
        $dato = "El carrito esta vacío.<br><a href='index'>Volver a la tienda</a>";
        require "vistas/mensaje.php";
    }
} else {
    $dato = "Debes de loguearte antes de realizar la compra.<br><a href='carrito'>Volver al carrito</a>.";
    require "vistas/mensaje.php";
    // echo "<a class='boton_carrito' href='index'> imprimir </a>";
}

// if (isset($_GET['imprimir'])) {
require_once "/Proyecto_DAW_Tienda/vendor/autoload.php";

$mpdf = new \Mpdf\Mpdf();
$stylesheet = file_get_contents('/Proyecto_DAW_Tienda/css/shop.css');

$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($dato, \Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->Output();
// }


include "vistas/fin.html";


function imprimir($html)
{
    require_once "../vendor/autoload.php";

    $mpdf = new \Mpdf\Mpdf();
    $stylesheet = file_get_contents('../css/shop.css');

    $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
}
