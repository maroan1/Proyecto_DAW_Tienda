<?php

require_once "../vendor/autoload.php";

    $mpdf = new \Mpdf\Mpdf();
    $stylesheet = file_get_contents('../css/shop.css');

    $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
    
    $mpdf->Output("factura#$id#.pdf", "I");
