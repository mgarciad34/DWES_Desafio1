<?php

class Personas{
    private $id;
    private $password;
    private $rol;
    private $nombre;
    private $email;
    private $alta;
    private $activo;
    private $partidasJugadas;
    private $partidasGanadas;

    public function __construct($id, $password, $rol, $nombre, $email, $alta, $activo, $partidasJugadas, $partidasGanadas) {
        $this->id = $id;
        $this->password = $password;
        $this->rol = $rol;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->alta = $alta;
        $this->activo = $activo;
        $this->partidasJugadas = $partidasJugadas;
        $this->partidasGanadas = $partidasGanadas;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self
    {
        $this->id = $id;

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
     * Get the value of rol
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set the value of rol
     */
    public function setRol($rol): self
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre($nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of alta
     */
    public function getAlta()
    {
        return $this->alta;
    }

    /**
     * Set the value of alta
     */
    public function setAlta($alta): self
    {
        $this->alta = $alta;

        return $this;
    }

    /**
     * Get the value of activo
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set the value of activo
     */
    public function setActivo($activo): self
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get the value of partidasJugadas
     */
    public function getPartidasJugadas()
    {
        return $this->partidasJugadas;
    }

    /**
     * Set the value of partidasJugadas
     */
    public function setPartidasJugadas($partidasJugadas): self
    {
        $this->partidasJugadas = $partidasJugadas;

        return $this;
    }

    /**
     * Get the value of partidasGanadas
     */
    public function getPartidasGanadas()
    {
        return $this->partidasGanadas;
    }

    /**
     * Set the value of partidasGanadas
     */
    public function setPartidasGanadas($partidasGanadas): self
    {
        $this->partidasGanadas = $partidasGanadas;

        return $this;
    }
}

?>