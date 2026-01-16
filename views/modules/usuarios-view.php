<?php
    // Procesamos el envío si existe
    if (isset($_POST['usuario_nombre-registro'])){
        require_once "./app/controllers/usuarioControlador.php";
        $instancia_usuario = new usuarioControlador();
        $peticion = true;    
        $instancia_usuario->agregar_usuario_controlador();
    }

    // Al recargar, si hay alertas en sesión, significa que el modal debe estar abierto
    $mostrar_modal = false;
    if (isset($_SESSION['usuario_alerta']) || isset($_SESSION['usuario_alerta-exito'])) {
        $mostrar_modal = true;
    }

    // Recuperamos los datos que guardamos en el controlador si hubo error
    $datos = (isset($_SESSION['usuario_datos_temp'])) ? $_SESSION['usuario_datos_temp'] : [];
?>

<div class="modulo__title-container p-2 pt-0">
    <div class="d-flex align-items-center gap-1">
        <svg class="modulo__title-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_iconCarrier">
                <circle cx="12" cy="6" r="4" fill="currentColor"></circle>
                <path d="M20 17.5C20 19.9853 20 22 12 22C4 22 4 19.9853 4 17.5C4 15.0147 7.58172 13 12 13C16.4183 13 20 15.0147 20 17.5Z" fill="currentColor"></path>
            </g>
        </svg>
        <h3 class="m-0">Gestión de Usuarios</h3>
    </div>
    <p class="m-0 ms-1 text-muted small">Bienvenido al módulo de gestión de usuarios. Aquí puedes agregar, editar o eliminar usuarios del sistema.</p>
</div>
<div class="row modulo__content-container">
    <div class="col-12 d-flex justify-content-between align-items-center border-bottom pb-3 pt-2">
        <div class="col-4 d-flex align-items-center gap-2">
            <svg class="modulo__content-icon" fill="#0c0c27" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 95.494 95.494" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <circle cx="10.906" cy="17.294" r="10.906"></circle> <circle cx="10.906" cy="47.294" r="10.906"></circle> <circle cx="10.906" cy="78.2" r="10.906"></circle> <g> <path d="M34.258,24.43h59.236c0.529,0,1.039-0.211,1.414-0.586s0.586-0.884,0.586-1.414l-0.002-10.271c0-1.104-0.896-2-2-2 H34.258c-1.104,0-2,0.896-2,2V22.43C32.258,23.534,33.153,24.43,34.258,24.43z"></path> <path d="M93.492,40.158H34.258c-1.104,0-2,0.896-2,2v10.271c0,1.104,0.896,2,2,2h59.236c0.529,0,1.039-0.211,1.414-0.586 s0.586-0.885,0.586-1.414l-0.002-10.271C95.492,41.054,94.598,40.158,93.492,40.158z"></path> <path d="M93.492,71.064H34.258c-1.104,0-2,0.896-2,2v10.271c0,1.104,0.896,2,2,2h59.236c0.529,0,1.039-0.211,1.414-0.586 s0.586-0.885,0.586-1.414l-0.002-10.271C95.492,71.96,94.598,71.064,93.492,71.064z"></path> </g> </g> </g> </g></svg>
            <h5 class="m-0">Registro de Usuarios</h5>
        </div>
        <div class="col-8 d-flex align-items-center justify-content-end gap-2">
            <div class="input-group input-group-sm w-50">
                <span class="input-group-text">Buscar</span>
                <input type="text" class="form-control">
            </div>
            <button class="btn btn-sm text-light" onclick="abrir_modal('modalNuevoUsuario')" style="background-color: #00c298; padding: 0.15rem 0.8rem; padding-bottom: 0.2rem;">Nuevo Usuario</button>
        </div>
    </div>
    <div class="col-12 p-0 mt-2">
        <?php 
            if (!isset($_SESSION['busqueda_usuario']) && empty($_SESSION['busqueda_usuario'])) {

                $cantidad_registros = (isset($_COOKIE['cat_registros'])) ? (int)$_COOKIE['cat_registros'] : 6;
                $pagina_actual = isset($pagina[1]) ? $pagina[1] : 1;
                
                require_once "app/controllers/usuarioControlador.php";
                $instancia_usuario = new usuarioControlador();
                
                echo $instancia_usuario->paginador_usuario_controlador($pagina_actual, $cantidad_registros, $_SESSION['id'], $pagina[0], "");
            }
        ?>
    </div>
</div>

<div class="modal fade <?php echo ($mostrar_modal) ? 'show' : ''; ?>" id="modalNuevoUsuario" style="box-shadow: none; border: none; <?php echo ($mostrar_modal) ? 'display: block; background: rgba(0,0,0,0.5);' : ''; ?>">
    <div class="modal-dialog modal-md mt-5 p-3"> 
        <div class="modal-content" style="box-shadow: none; border: none;">
            <div class="modal-header">
                <h5 class="modal-title fs-5">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal('modalNuevoUsuario')"></button>
            </div>
            <form class="modal-body" action="" method="POST" autocomplete="off">
                <div class="row gy-2 gx-3">
                    <div class="col-6">
                        <label class="small fw-bold">Nombre</label>
                        <input type="text" class="form-control form-control-sm" name="usuario_nombre-registro" 
                            value="<?php echo $datos['usuario_nombre-registro'] ?? ''; ?>" required>
                    </div>
                    <div class="col-6">
                        <label class="small fw-bold">Apellido</label>
                        <input type="text" class="form-control form-control-sm" name="usuario_apellido" 
                            value="<?php echo $datos['usuario_apellido'] ?? ''; ?>" required>
                    </div>
                    
                    <div class="col-6">
                        <label class="small fw-bold">Cédula</label>
                        <input type="text" class="form-control form-control-sm" name="usuario_ci" 
                            value="<?php echo $datos['usuario_ci'] ?? ''; ?>" required>
                    </div>
                    <div class="col-6">
                        <label class="small fw-bold">Teléfono</label>
                        <input type="text" class="form-control form-control-sm" name="usuario_telefono" 
                            value="<?php echo $datos['usuario_telefono'] ?? ''; ?>" required>
                    </div>
                    
                    <div class="col-6">
                        <label class="small fw-bold">Email</label>
                        <input type="email" class="form-control form-control-sm" name="usuario_email" 
                            value="<?php echo $datos['usuario_email'] ?? ''; ?>">
                    </div>
                    <div class="col-6">
                        <label class="small fw-bold">Usuario</label>
                        <input type="text" class="form-control form-control-sm" name="usuario_usuario" 
                            value="<?php echo $datos['usuario_usuario'] ?? ''; ?>" required>
                    </div>

                    <div class="col-6">
                        <label class="small fw-bold">Contraseña</label>
                        <input type="password" class="form-control form-control-sm" name="usuario_clave1" required>
                    </div>
                    <div class="col-6">
                        <label class="small fw-bold">Confirmar Contraseña</label>
                        <input type="password" class="form-control form-control-sm" name="usuario_clave2" required>
                    </div>
                    <div class="col-12">
                        <?php
                            if(session_status() !== PHP_SESSION_ACTIVE){ session_start(['name'=>'SCI']); }
                            if(isset($_SESSION['usuario_alerta'])){ 
                        ?>
                            <div class="alert alert-danger w-100 m-0 py-2" role="alert">
                                <?php 
                                    echo $_SESSION['usuario_alerta']; 
                                ?>
                            </div>
                        <?php } ?>
                        
                        <?php if(isset($_SESSION['usuario_alerta-exito'])){ ?>
                            <div class="alert alert-success w-100 m-0 py-2" role="alert">
                                <?php echo $_SESSION['usuario_alerta-exito']; ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                    <button type="button" class="btn btn-sm btn-secondary" onclick="cerrar_modal('modalNuevoUsuario')" class="btn-4">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
    unset($_SESSION['usuario_alerta']);
    unset($_SESSION['usuario_alerta-exito']);
    unset($_SESSION['usuario_datos_temp']); 
?>