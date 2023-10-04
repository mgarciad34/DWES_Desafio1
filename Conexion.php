<?php
require "Constantes.php";
class Conexion{
    public $host;
    public $user;
    public $password;
    public $port;
    public $database;

    public function __construct($host, $user, $password, $port, $database) {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->port = $port;
        $this->database = $database;
    }

    /**
     * Get the value of host
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set the value of host
     */
    public function setHost($host): self
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Get the value of user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     */
    public function setUser($user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of port
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set the value of port
     */
    public function setPort($port): self
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get the value of database
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * Set the value of database
     */
    public function setDatabase($database): self
    {
        $this->database = $database;

        return $this;
    }

    function conexion(){
        $conexion = mysqli_connect($this->host, $this->user, $this->password, $this->database, 3306);
        if(!$conexion){
            die("Error de conexión: " . mysqli_connect_error());
        }
        return $conexion;
    }

    function desconexion($conexion){
        return mysqli_close($conexion);
    }
}

?>