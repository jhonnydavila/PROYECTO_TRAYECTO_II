<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <?php include "../views/include/head.php"; ?>
        <title><?php echo APP_NAME ?></title>
    </head>
    <body>
        <?php
            require_once "../app/controllers/vistasControlador.php";
            $sistema = new vistasControlador();
            $vistas = $sistema->obtener_vistas_controlador();

            if($vistas == "login" || $vistas == "404"){
                require_once "../views/modules/".$vistas."-view.php";
            }else {
                session_start(['name'=>'SCI']);
                $pagina = explode("/", $_GET['views']);

                require_once "../app/controllers/loginControlador.php";
                $lc = new loginControlador();

                if(!isset($_SESSION['usuario']) || !isset($_SESSION['id']) || !isset($_SESSION['nombre'])){
                    echo $lc->forzar_cierre_sesion_controlador();
                    exit();
                }
                include "../views/include/navbar.php";
        ?>
        <main>
            <?php  
                include $vistas;
                ?>
        </main>
    </body>
</html>
<?php
        include "../views/include/scripts.php";
        include "../views/include/logout.php"; 
    } 
?>