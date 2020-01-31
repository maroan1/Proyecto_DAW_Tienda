<script></script>
<?php
session_start();
require "modelo.php";
if (!isset($_SESSION['nombre'])) {
    if (isset($_POST['loguear'])) {
        $base = new Bd();
        $login = new Cliente($_POST['dni'], "", "", "", "", "");
        $comp = $login->buscar($base->link);
        if (password_verify($_POST['contr'], $comp['pwd'])) {
            if ($comp['administrador']) {
                header("Location: ../adminUsuarios.html");
                exit();
            } else {
                $_SESSION['nombre'] = $comp['nombre'];
                $_SESSION['dni'] = $comp['dniCliente'];
                $_SESSION['total'] = 0;
            }
        } else {
            // TODO: revisar
            // ? Con un include quizás?
            require "vistas/loginmodal.html";
            // include "vistas/modal.php";
            include "vistas/fin.html";

            // include "vistas/inicio.html";

            // $dato = "El usuario o la contraseña son incorrectos<br><a href='validar.php'> Volver </a>";
            // require "vistas/mensaje.php";
            // include "vistas/fin.html";
        }
        $base->link->close();
    } else {
        require "vistas/login.html";
        include "vistas/fin.html";
    }
}
if (isset($_SESSION['nombre'])) {
    header("Location: principal.php");
}
