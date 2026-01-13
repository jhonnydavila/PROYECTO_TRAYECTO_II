<?php
    class vistasModelo{

        protected static function obtener_vistas_modelo($vistas){
            $listaBlanca = ["home"];

            if(in_array($vistas, $listaBlanca)){
                if(is_file("./views/modules/".$vistas."-view.php")){
                    $contenido = "./views/modules/".$vistas."-view.php";
                }else{
                    $contenido = "404";
                }
            } else if($vistas == "login" || $vistas == "index"){
                $contenido = "login";
            } else {
                $contenido = "404";
            }
            return $contenido;
        }
    }