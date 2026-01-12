<?php
    require_once "./../app/models/loginModelo.php";

    class loginControlador extends loginModelo{

        // controlador ininciar sesion
        public function iniciar_sesion_controlador(){
            
            if(session_status() !== PHP_SESSION_ACTIVE){ session_start(['name'=>'SCI']); }

            $usuario = mainModelo::limpiar_cadena($_POST['login_usuario']);
            $clave = mainModelo::limpiar_cadena($_POST['login_clave']);
            
            // Validación de campos
            if($usuario=="" || $clave==""){
                $_SESSION['login_alerta'] = "No has llenado todos los campos obligatorios.";
                header("Location: ".APP_URL."login/");
                exit();
            }

            // Verificacion de integridad
            if (mainModelo::validacion_datos("[a-zA-Z0-9\.\@\-\_]{4,20}",$usuario)) {
                $_SESSION['login_alerta'] = "El Usuario no cumple con el formato solicitado.";
                header("Location: ".APP_URL."login/");
                exit();
            }

            $clave_encriptada = mainModelo::encryption($clave);

            $datos_login = [
                "usuario"=>$usuario,
                "clave"=>$clave_encriptada
            ];
			if($datos_login['usuario'] == "admin"){
				$clave_encriptada = mainModelo::decryption($datos_login['clave']);
			}

            $datos_cuenta = loginModelo::iniciar_sesion_modelo($datos_login);

            if($datos_cuenta->rowCount()==1){
                $row = $datos_cuenta->fetch();
                // Verificamos la clave
                if($row['usuario_clave'] == $clave_encriptada){
                    
                    $_SESSION['id'] = $row['usuario_id'];
                    $_SESSION['nombre'] = $row['usuario_nombre'];
                    $_SESSION['apellido'] = $row['usuario_apellido'];
                    $_SESSION['usuario'] = $row['usuario_usuario'];
                    $_SESSION['cerrar'] = md5(uniqid(mt_rand(),true));

                    return header("Location: ".APP_URL."home/");
                }else{
                    $_SESSION['login_alerta'] = "La Contraseña ingresada es incorrecta.";
                }
            }else{
                $_SESSION['login_alerta'] = "No se encontró el usuario en el sistema.";
            }

            header("Location: ".APP_URL."login/");
            exit();
        }

        // controlador forzar cierre de session
        public function forzar_cierre_sesion_controlador(){
            session_unset();
            session_destroy();
            header("Location: ".APP_URL."login/");
        }

        // controlador forzar cierre de session
        public function cerrar_sesion_controlador(){
            session_start(['name'=>'SCI']);
            $token = mainModelo::decryption($_POST['token']);
            $usuario = mainModelo::decryption($_POST['usuario']);

            if ($token == $_SESSION['cerrar'] && $usuario == $_SESSION['usuario']) {
                session_unset();
                session_destroy();
                header("Location: ".APP_URL."login/");
            }else{
                $alerta = 'No se pudo cerrar la sesión correctamente. Por favor intente nuevamente';
            }
            echo ($alerta);
        }
    }