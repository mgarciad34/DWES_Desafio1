<?php

require 'Model/databaseManager.php';

class databaseController{
    
public static function iniciarSesion($conexion, $email, $pass){
    return login($conexion, $email, $pass);
}

public static function anadirUsuario($conexion, Personas $personas){
    return insertarDatos($conexion, $personas->getId(), $personas->getPassword(), $personas->getRol(), $personas->getNombre(), $personas->getEmail(), $personas->getAlta(), $personas->getActivo(), 0, 0);
}

public static function altaUsuario($conexion, $id){
    return generarAltaBaja($conexion, $id, "Alta");
}

public static function bajaUsuario($conexion, $id){
    return generarAltaBaja($conexion, $id, "Baja");
}

public static function activoUsuario($conexion, $id){
    return generarActivoDesactivo($conexion, $id, "Activo");
}

public static function desactivoUsuario($conexion, $id){
    return generarActivoDesactivo($conexion, $id, "Desactivo");
}

public static function leerDatos($conexion){
    return leerTodosLosDatos($conexion);
}

public static function leerDatosId($conexion, $id){
    return leerDatosPorID($conexion, $id);
}

public static function eliminarUsuarioId($conexion, $id){
    return eliminarUsuarioPorID($conexion, $id);
}

public static function cambiarContrasena($conexion, $id, $nuevaContrasena){
    return cambiarContrasenaPorID($conexion, $id, $nuevaContrasena);
}
}

?>