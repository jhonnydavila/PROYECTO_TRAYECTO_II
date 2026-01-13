<?php
    // Procesar el login si se envía el formulario
    if (isset($_POST['login_usuario']) && isset($_POST['login_clave'])) {
        require_once "./app/controllers/loginControlador.php";
        $instancia_login = new loginControlador();
        $instancia_login->iniciar_sesion_controlador();
    }
?>

<div class="container-fluid align-items-center" style="height: 100dvh; background-image: url('assets/img/login_gradient.jpg'); background-size: cover; background-position: center;">
    <div class="row h-100 align-items-center">
        <div class="col-lg-4 col-md-7 col-sm-8 mx-auto shadow bg-light p-0">

            <div class="col-12">
                <img src="assets/img/login_image.jpg" class="img-fluid" alt="" style="width: 100%; max-height: 40vh; object-fit: cover;">
            </div>

            <form class="row g-2 p-4 text-center" action="" method="post" autocomplete="off">
                <h3 class="p-0 m-0">BIENVENIDO!</h3>
                <span class="text-muted p-0 m-0 mb-3">Ingrese sus datos para iniciar sesión</span>
                
                <div class="col-12 px-3">
                <?php
                    if(session_status() !== PHP_SESSION_ACTIVE){ session_start(['name'=>'SCI']); }
                    if(isset($_SESSION['login_alerta'])){ 
                ?>
                    <div class="alert alert-danger w-100 m-0 py-2" role="alert" style="font-size: 0.9rem;">
                        <?php 
                            echo $_SESSION['login_alerta']; 
                            unset($_SESSION['login_alerta']);
                        ?>
                    </div>
                <?php } ?>
                </div>

                <div class="col-12 px-3">
                    <input type="text" class="form-control py-2" placeholder="Usuario" name="login_usuario" maxlength="20" required>
                </div>

                <div class="col-12 px-3">
                    <input type="password" class="form-control py-2" placeholder="Contraseña" name="login_clave" required>
                </div>

                <div class="col-12 px-3 mb-2">
                    <button class="btn btn-primary bg-gradient w-100" type="submit">Entrar</button>
                </div>

            </form>
        </div>
    </div>
</div>