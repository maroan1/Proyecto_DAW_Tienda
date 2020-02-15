<?php

require_once('../vendor/autoload.php');
require "./plantillas/example1/example1/index.php";

$css = file_get_contents('factura.css');
$id = 1282;

$mpdf = new \Mpdf\Mpdf([]);


$mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);


$mpdf->Output("factura#$id#.pdf", "I");
