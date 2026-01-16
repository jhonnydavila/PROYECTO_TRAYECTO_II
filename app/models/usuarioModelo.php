<?php
    require_once "mainModelo.php";

    class usuarioModelo extends mainModelo{
        
        // Modelo agregar usuario
        protected static function agregar_usuario_modelo($datos){
            $sql = mainModelo::conexion()->prepare("INSERT INTO usuarios(usuario_nombre, usuario_apellido, usuario_ci, usuario_usuario, usuario_telefono, usuario_email, usuario_clave) VALUES(:nombre, :apellido, :ci,:usuario, :telefono, :email, :clave)");
            $sql->bindParam(":nombre", $datos['nombre']);
            $sql->bindParam(":apellido", $datos['apellido']);
            $sql->bindParam(":ci", $datos['ci']);
            $sql->bindParam(":usuario", $datos['usuario']);
            $sql->bindParam(":telefono", $datos['telefono']);
            $sql->bindParam(":email", $datos['email']);
            $sql->bindParam(":clave", $datos['clave']);
            $sql->execute();
            return $sql;
        }
        
        // Modelo actualizar usuario
        protected static function actualizar_usuario_modelo($datos){
            $sql = mainModelo::conexion()->prepare("UPDATE usuarios SET usuario_nombre=:nombre, usuario_apellido=:apellido, usuario_ci=:ci, usuario_usuario=:usuario, usuario_telefono=:telefono, usuario_email=:email WHERE usuario_id=:id");
            $sql->bindParam(":nombre", $datos['nombre']);
            $sql->bindParam(":apellido", $datos['apellido']);
            $sql->bindParam(":ci", $datos['ci']);
            $sql->bindParam(":usuario", $datos['usuario']);
            $sql->bindParam(":telefono", $datos['telefono']);
            $sql->bindParam(":email", $datos['email']);
            $sql->bindParam(":id", $datos['id']);
            $sql->execute();
            
            return $sql;
        }

        // Modelo eliminar usuario
        protected static function eliminar_usuario_modelo($id){
            $sql = mainModelo::conexion()->prepare("DELETE FROM usuarios WHERE usuario_id=:id");
            $sql->bindParam(":id", $id);
            $sql->execute();
            return $sql;
        }
    }