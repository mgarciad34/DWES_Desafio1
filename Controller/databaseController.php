<?php

require 'Model/databaseManager.php';

class databaseController{
    
public static function iniciarSesion($conexion, $email, $pass, $rol){
    $rol =  login($conexion, $email, $pass);
    if ($rol !== null) {
        header("HTTP/1.1 200 OK");
        $_SESSION['rol'] = $rol;
        echo $rol;
        return $rol;
    } else {
        header("HTTP/1.1 401 Unauthorized");
    }
}

public static function anadirUsuario($conexion, Personas $personas){
    $result = insertarDatos($conexion, $personas->getId(), $personas->getPassword(), $personas->getRol(), $personas->getNombre(), $personas->getEmail(), $personas->getAlta(), $personas->getActivo(), 0, 0);
    if ($result !== null) {
        header("HTTP/1.1 200 OK");
    } else {
        header("HTTP/1.1 401 Unauthorized");
    }
}

public static function altaUsuario($conexion, $id){
    $result = generarAltaBaja($conexion, $id, "Alta");
    if ($result !== null) {
        header("HTTP/1.1 200 OK");
        echo json_encode($result);
    } else {
        header("HTTP/1.1 401 Unauthorized");
    }
}

public static function bajaUsuario($conexion, $id){
    return generarAltaBaja($conexion, $id, "Baja");
}

public static function activoUsuario($conexion, $id){
    $result = generarActivoDesactivo($conexion, $id, "Activo");
    if ($result !== null) {
        header("HTTP/1.1 200 OK");
        echo json_encode($result);
    } else {
        header("HTTP/1.1 401 Unauthorized");
    }
}

public static function desactivoUsuario($conexion, $id){
    return generarActivoDesactivo($conexion, $id, "Desactivo");
}

public static function leerDatos($conexion){
    $result = leerTodosLosDatos($conexion);
    if ($result !== null) {
        header("HTTP/1.1 200 OK");
        echo json_encode($result);
      } else {
        header("HTTP/1.1 400 Bad Request");
      }
}

public static function leerDatosId($conexion, $id){
    $result =  leerDatosPorID($conexion, $id);
    if ($result !== null) {
        header("HTTP/1.1 200 OK");
        echo json_encode($result);
    } else {
        header("HTTP/1.1 400 Bad Request");
    }
}

public static function eliminarUsuarioId($conexion, $id){
    $result = eliminarUsuarioPorID($conexion, $id);
    if ($result !== null) {
        header("HTTP/1.1 200 OK");
        echo json_encode($result);
    } else {
        header("HTTP/1.1 400 Bad Request");
    }
}

public static function cambiarContrasena($conexion, $id, $nuevaContrasena){
    $result = cambiarContrasenaPorID($conexion, $id, $nuevaContrasena);
    if ($result !== null) {
        header("HTTP/1.1 200 OK");
        echo json_encode($result);
    } else {
        header("HTTP/1.1 401 Unauthorized");
    }
}

public static function actualizarDatos($conexion, $id, $data){
    $result = actualizarDatosPorId($conexion, $id, $data);
    if ($result !== null) {
        header("HTTP/1.1 200 OK");
        echo json_encode($result);
    } else {
        header("HTTP/1.1 400 Bad Request");
    }
}

public static function rankingGanadas($conexion){
    $result = mostrarRanking($conexion);

    if ($result !== null) {
        header("HTTP/1.1 200 OK");
        echo json_encode($result);
    } else {
        header("HTTP/1.1 400 Bad Request");
    }
}

public static function jugarPartida($conexion, $idPartida, $idJugador, $casilla) {
    $consultaDatosPartida = obtenerDatosPartida($conexion, $idPartida, $idJugador);
    
    if (is_array($consultaDatosPartida)) {
        $consultaDatosPartida = json_encode($consultaDatosPartida);
    }

    $data = json_decode($consultaDatosPartida, true);
    $tableroOcultoBBDD = $data['oculto']; // Supongamos que $tableroOcultoBBDD es un array
    if (is_array($tableroOcultoBBDD)) {
        $stringOculto = implode(',', $tableroOcultoBBDD);
        $stringOculto = implode('[');
        echo $stringOculto;
    }

    echo json_encode($tableroOcultoBBDD);
}




public static function rendirsePartida($conexion, $idPartida, $idJugador){
    $result = rendirse($conexion, $idPartida, $idJugador);
    if ($result !== null) {
        header("HTTP/1.1 200 OK");
        echo json_encode($result);
    } else {
        header("HTTP/1.1 400 Bad Request");
    }
}
}


?>