<?php

require_once "../vendor/autoload.php";

// echo $_COOKIE['html'];

$mpdf = new \Mpdf\Mpdf();
$stylesheet = file_get_contents('../css/factura.css');

$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($_COOKIE['html'], \Mpdf\HTMLParserMode::HTML_BODY);

$mpdf->Output("factura.pdf", "I");
