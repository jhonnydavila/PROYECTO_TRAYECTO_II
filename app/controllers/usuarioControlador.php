<?php
    if($peticion){
        require_once "../app/models/usuarioModelo.php";
    }else{
        require_once "./app/models/usuarioModelo.php";
    }

    class usuarioControlador extends usuarioModelo{

        public function agregar_usuario_controlador(){
            if(session_status() !== PHP_SESSION_ACTIVE){ session_start(['name'=>'SCI']); }
            
            // Limpiar inputs
            $nombre = mainModelo::limpiar_cadena($_POST['usuario_nombre-registro']);
            $apellido = mainModelo::limpiar_cadena($_POST['usuario_apellido']);
            $ci = mainModelo::limpiar_cadena($_POST['usuario_ci']);
            $usuario = mainModelo::limpiar_cadena($_POST['usuario_usuario']);
            
            $telefono = mainModelo::limpiar_cadena($_POST['usuario_telefono']);
            $email = mainModelo::limpiar_cadena($_POST['usuario_email']);
            $clave1 = mainModelo::limpiar_cadena($_POST['usuario_clave1']);
            $clave2 = mainModelo::limpiar_cadena($_POST['usuario_clave2']);

            // Validaciones de campos bligatorios
            if($nombre=="" || $apellido=="" || $ci=="" || $telefono=="" || $usuario=="" || $clave1=="" || $clave2==""){
                $_SESSION['usuario_alerta'] = "No has llenado todos los campos obligatorios.";
                return;
            }

            // Verificacion de integridad de los datos
            if ($apellido!="") {
                if (mainModelo::validacion_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)) {
                    $_SESSION['usuario_alerta'] = "El Apellido no cumple con el formato solicitado.";
                    return;
                }
            }
            if (mainModelo::validacion_datos("[0-9]{6,8}",$ci)) {
                $_SESSION['usuario_alerta'] = "La Cédula no cumple con el formato solicitado.";
                return;
            }
            if (mainModelo::validacion_datos("[0-9+()]{7,20}",$telefono)) {
                $_SESSION['usuario_alerta'] = "El Teléfono no cumple con el formato solicitado.";
                return;
            }
            if (mainModelo::validacion_datos("[a-zA-Z0-9\.\@\-\_]{4,20}",$usuario)) {
                $_SESSION['usuario_alerta'] = "El Usuario no cumple con el formato solicitado.";
                return;
            }
            if ($clave1!="" || $clave2!="") {
                if (mainModelo::validacion_datos("[a-zA-Z0-9]{7,200}",$clave1) || mainModelo::validacion_datos("[a-zA-Z0-9]{7,200}",$clave2)) {
                    $_SESSION['usuario_alerta'] = "Las Contraseñas no cumple con el formato solicitado.";
                    return;
                }
            }

            // Comprobando usuario en la BD
            $check_usuario = mainModelo::ejecutar_consulta_simple("SELECT usuario_usuario FROM usuarios WHERE usuario_usuario='$usuario'");
            if($check_usuario->rowCount()>0){
                $_SESSION['usuario_alerta'] = "El Nombre de Usuario ya se encuentra registrado... Porfavor elija otro.";
                return;
            }

            // Comprobando usuario en la BD
            $check_ci = mainModelo::ejecutar_consulta_simple("SELECT usuario_ci FROM usuarios WHERE usuario_ci='$ci'");
            if($check_ci->rowCount()>0){
                $_SESSION['usuario_alerta'] = "La Cédula ingresada ya se encuentra registrada.";
                return;
            }

            // verificacion del email
            if ($email!="") {
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $check_email = mainModelo::ejecutar_consulta_simple("SELECT usuario_email FROM usuarios WHERE usuario_email='$email'");
                    if($check_email->rowCount()>0){
                        $_SESSION['usuario_alerta'] = "EL Email ingresado ya se encuentra registrado.";
                        return; 
                    }
                }else{
                    $_SESSION['usuario_alerta'] = "Ha ingresado un Email no valido.";
                    return; 
                }
            }

            // verificacion de contraseñas
            if ($clave1 != $clave2) {
                $_SESSION['usuario_alerta'] = "Las Contraseñas ingresadas no coinciden.";
                return;
            }else{
                $clave = mainModelo::encryption($clave1);
            }

            // Preparando datos para el modelo
            $datos_usuario_registro = [
                "nombre"=>$nombre,
                "apellido"=>$apellido,
                "ci"=>$ci,
                "usuario"=>$usuario,
                "telefono"=>$telefono,
                "clave"=>$clave,
                "email"=>$email
            ];

            // Enviando al modelo
            $agregar_usuario = usuarioModelo::agregar_usuario_modelo($datos_usuario_registro);

            if($agregar_usuario->rowCount()==1){
                $_SESSION['usuario_alerta-exito'] = "El Usuario se registró con éxito.";
                unset($_SESSION['usuario_datos_temp']); 
            }else{
                $_SESSION['usuario_alerta'] = "No se pudo registrar el usuario.";
            }

            return;
        }

        // Controlador paginador usuarios
        public function paginador_usuario_controlador($pagina, $registros, $id, $url, $busqueda){
            
            $pagina = mainModelo::limpiar_cadena($pagina);
            $registros = mainModelo::limpiar_cadena($registros);
            $id = mainModelo::limpiar_cadena($id);

            $url = mainModelo::limpiar_cadena($url);
            $url = APP_URL.$url."/";

            $busqueda = mainModelo::limpiar_cadena($busqueda);

            $tabla = "";
            
            $pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
            $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

            if(isset($busqueda) && $busqueda!=""){
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM usuarios WHERE ((usuario_id!='$id' AND usuario_id!='1') AND (usuario_ci LIKE '%$busqueda%' OR usuario_nombre LIKE '%$busqueda%' OR usuario_usuario LIKE '%$busqueda%' OR usuario_telefono LIKE '%$busqueda%'  OR usuario_apellido LIKE '%$busqueda%')) ORDER BY usuario_nombre ASC LIMIT $inicio,$registros";
            }else{
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM usuarios WHERE usuario_id!='$id' AND usuario_id!='1' ORDER BY usuario_nombre ASC LIMIT $inicio,$registros";
            }

            $conexion = mainModelo::conexion();

            $datos = $conexion->query($consulta);
            $datos = $datos->fetchAll();

            $total = $conexion->query("SELECT FOUND_ROWS()");
            $total = (int) $total->fetchColumn();
            
            $Npaginas = ceil($total/$registros);

            $tabla .='
                <div class="table-responsive">
                    <table class="table modulo__content-table">
                        <thead>
                            <tr>
                                <th class="modulo__content-table-text-left">#</th>
                                <th>Nombre</th>
                                <th>Usuario</th>
                                <th>Cédula</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
            ';
            if($total >=1 && $pagina <= $Npaginas) {
                $contador = $inicio+1;
                $pag_inicio =  $inicio+1;
                foreach ($datos as $rows) {
                    $tabla .='
                            <tr>
                                <td>'.$contador.'</td>
                                <td>'.substr($rows['usuario_nombre'],0,10).' '.substr($rows['usuario_apellido'],0,10).'</td>
                                <td>'.substr($rows['usuario_usuario'],0,16).'</td>
                                <td>'.substr($rows['usuario_ci'],0,8).'</td>
                                <td>'.substr($rows['usuario_telefono'],0,11).'</td>
                                <td>'.substr($rows['usuario_email'],0,26).'</td>
                                <td>
                                    <button class="btn btn-sm btn-primary">Editar</button>
                                    <button class="btn btn-sm btn-danger">Eliminar</button>
                                </td>
                            </tr>
                    ';
                    $contador++;
                }
                $pag_final = $contador -1;
            }else {
                if ($total >= 1) {
                    $tabla .='
                        <tr>
                            <td>
                                <a href="'.$url.'" class="btn btn-sm btn-primary">Haga click para recargar.</a>
                            </td>
                        </tr>
                    ';
                }else {
                    $tabla .='
                        <tr>
                            <td>
                                No hay registros en el sistema
                            </td>
                        </tr>
                    ';
                }
            }

            
            $tabla .='
                        </tbody>
                    </table>
                </div>
                ';

            if ($total >= 1 && $pagina <= $Npaginas) {
                $botones_html = "";

                $tabla .='
                    <div class="tabla__info">
                        <div class="tabla__info-list-btns">
                            '.$botones_html.'
                        </div>
                        <div class="tabla__info-texto">
                            Mostrando Usuarios del <strong>'.$pag_inicio .'</strong> al <strong>'.$pag_final.'</strong> de un total de <strong>'.$total.'</strong>
                        </div>
                    </div>
                ';
            }
            
            if ($total >= 1 && $pagina <= $Npaginas) {
                $tabla .= mainModelo::paginador_tablas($pagina, $Npaginas, $url, 10);
            }
            $tabla .= '</div>';
            return $tabla;
        }

        // Controlador para actualizar un usuario 
        public function actualizar_usuario_controlador(){

            if($_SESSION['nivel']==1){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No tienes los permisos necesarios para actualizar usuarios.",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            
            // Limpiar inputs
            $id = mainModelo::decryption($_POST['usuario_id_actualizar']);
            $id = mainModelo::limpiar_cadena($id);

            // Comprobando existencia del usuario en la BD
            $check_usuario_id = mainModelo::ejecutar_consulta_simple("SELECT * FROM usuarios WHERE usuario_id='$id'");
            if($check_usuario_id->rowCount()<=0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos podido encontrar el Usuario en el sistema.",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $campos = $check_usuario_id->fetch();
            }

            $nombre = mainModelo::limpiar_cadena($_POST['usuario_nombre-actualizar']);
            $apellido = mainModelo::limpiar_cadena($_POST['usuario_apellido']);
            $ci = mainModelo::limpiar_cadena($_POST['usuario_ci']);
            $usuario = mainModelo::limpiar_cadena($_POST['usuario_usuario']);
            $email = mainModelo::limpiar_cadena($_POST['usuario_email']);
            $telefono = mainModelo::limpiar_cadena($_POST['usuario_telefono']);

            $admin_usuario = mainModelo::limpiar_cadena($_POST['admin_usuario']);
            $admin_clave = mainModelo::limpiar_cadena($_POST['admin_clave']);
            $tipo_cuenta = mainModelo::limpiar_cadena($_POST['tipo_cuenta']);

            
            // Validaciones de campos bligatorios
            if($nombre=="" || $apellido=="" || $ci=="" || $telefono=="" || $usuario=="" || $admin_clave=="" || $admin_usuario==""){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No has llenado todos los campos obligatorios.",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            // Verificacion de integridad de los datos
            if ($apellido!="") {
                if (mainModelo::validacion_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)) {
                    $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El Apellido no cumple con el formato solicitado",
                    "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }
            if (mainModelo::validacion_datos("[0-9]{6,8}",$ci)) {
                $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error inesperado",
                "Texto"=>"La Cedula no cumple con el formato solicitado",
                "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if (mainModelo::validacion_datos("[0-9+()]{7,20}",$telefono)) {
                $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error inesperado",
                "Texto"=>"El Telefono no cumple con el formato solicitado",
                "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if (mainModelo::validacion_datos("[a-zA-Z0-9$@.-]{4,20}",$usuario)) {
                $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error inesperado",
                "Texto"=>"El Usuario no cumple con el formato solicitado",
                "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if (mainModelo::validacion_datos("[a-zA-Z0-9$@.-]{4,20}",$admin_usuario)) {
                $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error inesperado",
                "Texto"=>"Tu nombre de Usuario no cumple con el formato solicitado",
                "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if (mainModelo::validacion_datos("[a-zA-Z0-9$@.-]{7,200}",$admin_clave)) {
                $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error inesperado",
                "Texto"=>"Tu Contraseña no cumple con el formato solicitado",
                "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            
            
            // Comprobando nombre de usuario en la BD
            if ($usuario!=$campos['usuario_usuario']) {
                $check_usuario = mainModelo::ejecutar_consulta_simple("SELECT usuario_usuario FROM usuarios WHERE usuario_usuario='$usuario'");
                if($check_usuario->rowCount()>0){
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El Nombre de Usuario ya se encuentra registrado... Porfavor elija otro.",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            // Comprobando ci del usuario en la BD
            if ($ci!=$campos['usuario_ci']) {
                $check_ci = mainModelo::ejecutar_consulta_simple("SELECT usuario_ci FROM usuarios WHERE usuario_ci='$ci'");
                if($check_ci->rowCount()>0){
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"La Cédula ingresada ya se encuentra registrada.",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }
            
            // Comprobando email en la BD
            if ($email!=$campos['usuario_email'] && $email!="") {
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $check_email = mainModelo::ejecutar_consulta_simple("SELECT usuario_email FROM usuarios WHERE usuario_email='$email'");
                    if($check_email->rowCount()>0){
                        $alerta = [
                                "Alerta"=>"simple",
                            "Titulo"=>"Ocurrió un error inesperado",
                            "Texto"=>"EL Email ingresado ya se encuentra registrado.",
                            "Tipo"=>"error"
                        ];
                        echo json_encode($alerta);
                        exit();    
                    }
                }else{
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"Ha ingresado un Email no valido.",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            // Comprobando contraseñas
            if ($_POST['usuario_clave1']!="" || $_POST['usuario_clave2']!="") {
                if ($_POST['usuario_clave1']!=$_POST['usuario_clave2']) {
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"Las nuevas Contraseñas ingresadas no coinciden.",
                        "Tipo"=>"error"
                    ];
                echo json_encode($alerta);
                exit();
                } else {
                    if (mainModelo::validacion_datos("[a-zA-Z0-9$@.-]{7,200}",$_POST['usuario_clave1']) || mainModelo::validacion_datos("[a-zA-Z0-9$@.-]{7,200}",$_POST['usuario_clave2'])) {
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrió un error inesperado",
                            "Texto"=>"Las nuevas Contraseñas no cumple con el formato solicitado",
                            "Tipo"=>"error"
                        ];
                        echo json_encode($alerta);
                        exit();
                    }
                    $clave = mainModelo::encryption($_POST['usuario_clave1']);
                }
            } else {
                $clave = $campos['usuario_contraseña'];
            }
            
            // Comprobando credenciales para actualizar datos
            $admin_clave = mainModelo::encryption($admin_clave);
            if ($tipo_cuenta=="Propia") {
                $check_cuenta = mainModelo::ejecutar_consulta_simple("SELECT usuario_id FROM usuarios WHERE usuario_usuario='$admin_usuario' AND usuario_contraseña='$admin_clave' AND usuario_id ='$id'");
            } else {
                $check_cuenta = mainModelo::ejecutar_consulta_simple("SELECT usuario_id FROM usuarios WHERE usuario_usuario='$admin_usuario' AND usuario_contraseña='$admin_clave'");
            }
            
            if ($check_cuenta->rowCount()<=0) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"Usuario y Contraseña de sesión no validos.",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            // Preparando datos para el modelo
            $datos_usuario_actualizar = [
                "nombre"=>$nombre,
                "apellido"=>$apellido,
                "ci"=>$ci,
                "telefono"=>$telefono,
                "usuario"=>$usuario,
                "clave"=>$clave,
                "email"=>$email,
                "id"=>$id
            ];

            // Enviando al modelo
            if (usuarioModelo::actualizar_usuario_modelo($datos_usuario_actualizar)) {
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Usuario registrado",
                    "Texto"=>"Los datos del Usuario se actualizaron con éxito.",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No se pudo actualizar los datos... Por favor intente nuevamente.",
                    "Tipo"=>"error"
                ];  
            }
            echo json_encode($alerta);
        }

        // Controlador para eliminar un usuario 
        public function eliminar_usuario_controlador(){
            
            $id = mainModelo::decryption($_POST['usuario_id_eliminar']);
            $id = mainModelo::limpiar_cadena($id);

            // Comprobando usuario principal en la BD
            if($id=="1"){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No se puede eliminar el usuario principal del sistema.",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            // Comprobando usuario en la BD
            $check_usuario = mainModelo::ejecutar_consulta_simple("SELECT usuario_id FROM usuarios WHERE usuario_id='$id'");
            if($check_usuario->rowCount()<=0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El usuario que intenta eliminar no existe.",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            // Comprobando si hay creditos asociados al usuario
            $check_creditos = mainModelo::ejecutar_consulta_simple("SELECT usuario_id FROM credito WHERE usuario_id='$id' LIMIT 1");
            if($check_creditos->rowCount()>0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No se puede eliminar el usuario porque tiene créditos asociados.",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            // Comprobando nivel de usuario
            session_start(['name'=>'SCI']);
            if($_SESSION['nivel']!=3){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No tienes los permisos necesarios para eliminar usuarios.",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            // Eliminando usuario
            $eliminar_usuario = usuarioModelo::eliminar_usuario_modelo($id);

            if($eliminar_usuario->rowCount()==1){
                $alerta = [
                    "Alerta"=>"recargar",
                    "Titulo"=>"Usuario eliminado",
                    "Texto"=>"El Usuario se eliminó con éxito.",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No se pudo eliminar el usuario.",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
        }
    }