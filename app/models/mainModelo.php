<?php
    if($peticion){
        require_once "../config/SERVER.php";
    }else{
        require_once "./config/SERVER.php";
    }

    class mainModelo{
        
        // Función para conectar a BD 
        protected static function conexion(){
            $conexion = new PDO(SGBD,USER,PASS);
            $conexion->exec("SET CHARACTER SET utf8");
            return $conexion;
        }

        // Función para ejecutar consultas simples
        protected static function ejecutar_consulta_simple($consulta){
            $sql = self:: conexion()->prepare($consulta);
            $sql->execute();
            return $sql;
        }

        // Función para incriptar cadenas
        public static function encryption($string){
            $output = FALSE;
            $key = hash('sha256', SECRET_KEY);
            $iv = substr(hash('sha256', SECRET_IV), 0, 16);
            $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
            $output = base64_encode($output);
            return $output;
        }

        // Función para desencriptar cadenas
        protected static function decryption($string){
            $key = hash('sha256', SECRET_KEY);
            $iv = substr(hash('sha256', SECRET_IV), 0, 16);
            $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
            return $output;
        }

        // Función para limpiar cadenas de texto
        protected static function limpiar_cadena($cadena){
            $cadena = trim($cadena);
            $cadena = stripslashes($cadena);
            $cadena = str_ireplace("<script>","",$cadena);
            $cadena = str_ireplace("</script>","",$cadena);
            $cadena = str_ireplace("<script src","",$cadena);
            $cadena = str_ireplace("<script type=","",$cadena);
            $cadena = str_ireplace("SELECT * FROM","",$cadena);
            $cadena = str_ireplace("DELETE FROM","",$cadena);
            $cadena = str_ireplace("INSERT INTO","",$cadena);
            $cadena = str_ireplace("DROP TABLE","",$cadena);
            $cadena = str_ireplace("DROP DATABASE","",$cadena);
            $cadena = str_ireplace("TRUNCATE TABLE","",$cadena);
            $cadena = str_ireplace("SHOW TABLES","",$cadena);
            $cadena = str_ireplace("SHOW DATABASES","",$cadena);
            $cadena = str_ireplace("<?PHP","",$cadena);
            $cadena = str_ireplace("?>","",$cadena);
            $cadena = str_ireplace("--","",$cadena);
            $cadena = str_ireplace("^","",$cadena);
            $cadena = str_ireplace("<","",$cadena);
            $cadena = str_ireplace("[","",$cadena);
            $cadena = str_ireplace("]","",$cadena);
            $cadena = str_ireplace("==","",$cadena);
            $cadena = str_ireplace(";","",$cadena);
            $cadena = str_ireplace("::","",$cadena);
            $cadena = trim($cadena);
            $cadena = stripslashes($cadena);
            return $cadena;
        }

        // Función para validar datos permitidos en los formularios
        protected static function validacion_datos($filtro, $cadena){
            if(preg_match("/^".$filtro."$/", $cadena)){
                return false;
            }else{
                return true;
            }
        }

        // Función para las paginaciones de las tablas de datos
        protected static function paginador_tablas($pagina, $Npaginas,$url,$botones){
            $list='
                <nav class="paginacion">
            ';

            if ($pagina <= 1) {
                $list.='
                    <a class="pagina-link deshabilitado" aria-label="anterior">
                        <span aria-hidden="true">< Anterior</span>
                    </a>
                ';
            }else {
                $list.='
                    <a class="pagina-link" aria-label="anterior" href="'.$url.($pagina-1).'">
                        <span aria-hidden="true">< Anterior</span>
                    </a>
                ';
            }

            $contadorI = 0;
            for ($i = 1; $i <= $Npaginas; $i++) {
                if ($contadorI >= $botones) {
                    break;
                }
                if ($pagina == $i) {
                    $list.='
                        <li class="pagina-item activado">
                            <a class="pagina-link" href="'.$url.$i.'">'.$i.'</a>
                        </li>
                    ';
                }else {
                    $list.='
                        <li class="pagina-item">
                            <a class="pagina-link" href="'.$url.$i.'">'.$i.'</a>
                        </li>
                    ';
                }
                $contadorI++;
            }

            if ($pagina == $Npaginas) {
                $list.='
                    <a class="pagina-link deshabilitado" aria-label="siguiente">
                        <span aria-hidden="true">Siguiente ></span>
                    </a>
                ';
            }else {
                $list.='
                    <a class="pagina-link" href="'.$url.($pagina+1).'" aria-label="siguiente">
                        <span aria-hidden="true">Siguiente ></span>
                    </a>
                ';
            }

            $list.='
                </nav>
            ';
            return $list;
        }
    }