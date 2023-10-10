<?php
require 'config/constantes.php';
class Database{

    private $conexion;

    public function __construct() {
        $this->conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        

        if ($this->conexion->connect_error) {
            
            die("Error de conexión a la base de datos: " . $this->conexion->connect_error);
        }
    }

    public function getConnection() {
        return $this->conexion;
    }
   
}
?>