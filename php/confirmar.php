<?php
include "vistas/inicioFactura.html";
if (isset($_COOKIE['nombre'])) {
    if ($_GET['total'] > 0) {
        require_once('../vendor/autoload.php');
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
        sleep(1);
        //*PIDO LAS LINEAS DEL PEDIDO PARA CREAR LA FACTURA
        $url = "http://localhost/Proyecto_DAW_Tienda/php/lineaPedido/" . $idPedido;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $datos = json_decode(curl_exec($ch), true);
        // print_r($datos);
        curl_close($ch);

        //*PIDO EL CLIENTE PARA CREAR LA FACTURA
        $url = "http://localhost/Proyecto_DAW_Tienda/php/cliente/" . $_COOKIE['dni'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $cliente = json_decode(curl_exec($ch), true);
        // print_r($datos);
        curl_close($ch);

        $dato = "<header>
    <div id='logo'>
        <img src='/Proyecto_DAW_Tienda/img/logo.png' alt='logo de la compañia' width='120px'>
        XaxiVinilos
    </div>";
        $dato .= "<h1 id='idFactura'>PEDIDO#" . $idPedido . "#</h1>";
        $dato .= "<div id='cliente' class='datos'>
        <div><span>CLIENTE</span> " . $cliente['nombre'] . "</div>
        <div><span>DNI</span> " . $_COOKIE['dni'] . "</div>
        <div><span>DIRECCIÓN</span> " . $cliente['direccion'] . "</div>
    </div>";
        $dato .= "<div id='empresa' class='datos'>
        <div>XaxiVinilos</div>
        <div>Carrer de la Reina Na Germana, 24,<br> 46005 València, Valencia</div>
        <div>969 999 999</div>
        <div><a href='mailto:xaxivinilos@mail.es'></a></div>
    </div>";
        $dato .= "</header>
<main>
    <table border=1>
        <thead>
            <th>ID</th>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Total</th>
        </thead>
        <tbody>";

        foreach ($datos as $key => $value) {
            $url = "http://localhost/Proyecto_DAW_Tienda/php/producto/" . $value['idProducto'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $detalle = json_decode(curl_exec($ch), true);
            curl_close($ch);
            $dato .= "<tr>
                <td>" . $value['idProducto'] . "</td>
                <td>" . $detalle['nombre'] . "</td>
                <td>" . $value['precio'] . "€</td>
                <td>" . $value['cantidad'] . "</td>
                <td>" . $value['precio'] * $value['cantidad'] . "</td>
            </tr>";
            $precioTotal += $value['precio'] * $value['cantidad'];
        }


        $dato .= "<tr>
                <td class='total' colspan='4'>SUBTOTAL</td>
                <td>" . $precioTotal . "€</td>
            </tr>";
        $dato .= "<tr>
                <td class='total' colspan='4'>IVA 21%</td>
                <td>" . round($precioTotal * 0.21, 2) . "€</td>
            </tr>";
        $dato .= "<tr>
                <td class='total' colspan='4'>TOTAL</td>
                <td>" . round($precioTotal * 1.21, 2) . "€</td>
            </tr>";
        $dato .= "</tbody>
    </table>
    <div id='notas'>
        <div>NOTAS:</div>
        <div class='nota'>Tiene 30 días de compromiso para devolver el producto sin desperfectos (se comprueba el
            buen
            estado de nuestros productos antes de entregar).</div>
        <div class='nota'>Para devoluciones en compras online pongasé en contacto con nuestro servico de atención al
            cliente.</div>
    </div>
</main>
<footer>
    Factura creada por ordenador, valida sin firma ni sello.
</footer>";
        $html = $dato;
        setcookie('html', $html, time() + 60000, "/Proyecto_DAW_Tienda/php");
        $dato .= "<a class='btn-imprimir' href='/Proyecto_DAW_Tienda/php/imprimir'>Imprimir</a>";
        // $dato .= "<div class='row m-0'>
        //     <form action='\Proyecto_DAW_Tienda\php\imprimir' method='post'>
        //     <input type='text' name='html' value='$html' hidden>
        //     <input class='btn btn-outline-success' type='submit' name='imprimir'>
        //     </form>
        // </div>";
        require "vistas/mensaje.php";
    } else {
        $dato .= "El carrito esta vacío.<br><a href='index'>Volver a la tienda</a>";
        require "vistas/mensaje.php";
    }
} else {
    $dato = "Debes de loguearte antes de realizar la compra.<br><a href='/Proyecto_DAW_Tienda/php/carrito'>Volver al carrito</a>.";
    require "vistas/mensaje.php";
    // echo "<a class='boton_carrito' href='index'> imprimir </a>";
}

// if (isset($_GET['imprimir'])) {
// require_once "../vendor/autoload.php";

// $mpdf = new \Mpdf\Mpdf();
// $stylesheet = file_get_contents('/Proyecto_DAW_Tienda/css/shop.css');

// $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
// $mpdf->WriteHTML($dato, \Mpdf\HTMLParserMode::HTML_BODY);
// $mpdf->Output();
// // }


include "vistas/finalFactura.html";
