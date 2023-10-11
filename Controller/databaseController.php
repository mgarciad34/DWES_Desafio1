<?php

require 'Model/databaseManager.php';


function iniciarSesion($conexion, Personas $personas){
    return login($conexion, $personas->getId(), $personas->getPassword(), $personas->getRol());
}

function anadirUsuario($conexion, Personas $personas){
    return insertarDatos($conexion, $personas->getId(), $personas->getPassword(), $personas->getRol(), $personas->getNombre(), $personas->getEmail(), $personas->getAlta(), $personas->getActivo(), 0, 0);
}

function altaUsuario($conexion, Personas $personas){
    return generarAltaBaja($conexion, $personas->getId(), $personas->getAlta(), "Alta");
}

function bajaUsuario($conexion, Personas $personas){
    return generarAltaBaja($conexion, $personas->getId(), $personas->getAlta(), "Baja");
}

function activoUsuario($conexion, Personas $personas){
    return generarActivoDesactivo($conexion, $personas->getId(), $personas->getActivo(),);
}

function desactivoUsuario($conexion, Personas $personas){
    return generarActivoDesactivo($conexion, $personas->getId(), $personas->getActivo(),);
}

function leerDatos($conexion){
    return leerTodosLosDatos($conexion);
}

function leerDatosId($conexion, Personas $personas){
    return leerDatosPorID($conexion, $personas->getId());
}

function eliminarUsuarioId($conexion, Personas $personas){
    return eliminarUsuarioPorID($conexion, $personas->getId());
}

function cambiarContrasena($conexion, Personas $personas){
    return cambiarContrasenaPorID($conexion, $personas->getId(), $personas->getPassword());
}

?>