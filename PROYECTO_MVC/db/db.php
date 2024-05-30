<?php
    class Conexion {  
        public static function conectar(){
            $server = "localhost";
            $user = "root";
            $password = "";
            $db = "form_db";
            $port = 3306;    
    
            $conexion = new mysqli(
                $server, 
                $user, 
                $password, 
                $db, 
                $port
            );
            return $conexion;
        }
    }