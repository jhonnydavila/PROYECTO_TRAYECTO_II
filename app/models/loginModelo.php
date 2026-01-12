<?php
    require_once "mainModelo.php";

    class loginModelo extends mainModelo{

    	// modelo para iniciar sesion
		protected static function iniciar_sesion_modelo($datos){
			$sql = mainModelo::conexion()->prepare("SELECT * FROM usuarios WHERE usuario_usuario=:usuario");
			$sql->bindParam(":usuario",$datos['usuario']);
			$sql->execute();
			return $sql;
		}
    }