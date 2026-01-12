<?php
    require_once "../config/APP.php";
    require_once "../app/controllers/vistasControlador.php";

    $plantilla = new vistasControlador();
    $plantilla->obtener_plantilla_controlador();