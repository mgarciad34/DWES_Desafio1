<?php

require 'Model/databaseManager.php';

class databaseController{
    
public static function iniciarSesion($conexion, $email, $pass){
    return login($conexion, $email, $pass);
}

public static function anadirUsuario($conexion, Personas $personas){
    return insertarDatos($conexion, $personas->getId(), $personas->getPassword(), $personas->getRol(), $personas->getNombre(), $personas->getEmail(), $personas->getAlta(), $personas->getActivo(), 0, 0);
}

public static function altaUsuario($conexion, Personas $personas){
    return generarAltaBaja($conexion, $personas->getId(), $personas->getAlta(), "Alta");
}

public static function bajaUsuario($conexion, Personas $personas){
    return generarAltaBaja($conexion, $personas->getId(), $personas->getAlta(), "Baja");
}

public static function activoUsuario($conexion, Personas $personas){
    return generarActivoDesactivo($conexion, $personas->getId(), $personas->getActivo(),);
}

public static function desactivoUsuario($conexion, Personas $personas){
    return generarActivoDesactivo($conexion, $personas->getId(), $personas->getActivo(),);
}

public static function leerDatos($conexion){
    return leerTodosLosDatos($conexion);
}

public static function leerDatosId($conexion, Personas $personas){
    return leerDatosPorID($conexion, $personas->getId());
}

public static function eliminarUsuarioId($conexion, Personas $personas){
    return eliminarUsuarioPorID($conexion, $personas->getId());
}

public static function cambiarContrasena($conexion, Personas $personas){
    return cambiarContrasenaPorID($conexion, $personas->getId(), $personas->getPassword());
}
}

?>