<?php
$arrayDatos;
$funciona = false;
$nombre = $_FILES['fichero']['name'];
$arrayDatos['foto'] = $nombre;
$tipo = $_FILES['fichero']['type'];
if (is_uploaded_file($_FILES['fichero']['tmp_name']) && strstr($tipo, 'image/')) {
    // $partes = explode('.', $nombre);
    // $npartes = count($partes);
    // if ($npartes > 0) {
    $dir = '../img/';
    // if (!is_dir($dir)) mkdir($dir);
    // if (is_file($dir . $nombre)) {
    //     $idUnico = uniqid();
    //     $nombre = $partes[0];
    //     for ($i = 1; $i < $npartes - 1; $i++) {
    //         $nombre .= "." . $partes[$i];
    //     }
    //     $nombre .= "_" . $idUnico . "." . $partes[$npartes - 1];
    // }
    move_uploaded_file($_FILES['fichero']['tmp_name'], $dir . $nombre);
    $funciona = true;
    $arrayDatos['mensaje'] = "el fichero $nombre se ha subido correctamente";
} else $arrayDatos['mensaje'] = "El archivo no se ha podido subir, asegurate de que sea una imagen.";
$arrayDatos['subida'] = $funciona;
$json = json_encode($arrayDatos);
echo $json;
