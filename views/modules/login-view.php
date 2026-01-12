<div class="container-fluid align-items-center" style="height: 100dvh; background-image: url('<?php echo APP_URL ?>public/img/login_gradient.jpg'); background-size: cover; background-position: center;">

    <div class="row h-100 align-items-center">
        <div class="col-md-4 col-sm-6 mx-auto shadow bg-light p-0">

            <div class="col-12">
                <img src="<?php echo APP_URL ?>public/img/login_image.jpg" class="img-fluid" alt="" style="width: 100%; max-height: 40vh; object-fit: cover;">
            </div>

            <form class="row g-2 p-4 text-center" autocomplete="off">
                <h3 class="p-0 m-0">BIENVENIDO!</h3>
                <span class="text-muted p-0 m-0">Ingrese sus datos para iniciar sesión</span>
                
                <div class="col-12 px-3">
                    <input type="text" class="form-control py-2" placeholder="Usuario" id="input_usuario" pattern="[0-9]{4,200}" maxlength="200" required>
                </div>

                <div class="col-12 px-3">
                    <input type="password" class="form-control py-2" placeholder="Contraseña" id="input_clave" required>
                </div>

                <div class="col-12 px-3 mb-2">
                    <button class="btn btn-primary bg-gradient w-100" type="submit">Entrar</button>
                </div>
            </form>

        </div>
    </div>
</div>

