<?php
session_start(); // Inicia la sesión
header("Content-Type: application/json");

require('Model/Personas.php');
require 'Controller/databaseController.php';
require 'Controller/juegoBuscaminasController.php';

$requestMethod = $_SERVER["REQUEST_METHOD"];
$paths = $_SERVER['REQUEST_URI'];
$argus = explode('/', $paths);
unset($argus[0]);
$rol = null;
$idLogin = null;
$db = new Database();

switch ($requestMethod) {
    case 'GET':
        if (obtenerRol() === "0") {
            if (str_contains('/api/administrador/usuarios/listar/', $paths)) {
                $result = databaseController::leerDatos($db->getConnection());
            }else{
                $urlArray = explode('/', parse_url($paths, PHP_URL_PATH));
                if(count($urlArray) === 7){
                    if (count($urlArray) >= 5 && strpos($urlArray[1], 'api') !== false && strpos($urlArray[2], 'administrador') !== false && strpos($urlArray[3], 'usuarios') !== false && strpos($urlArray[4], 'listar') !== false) {
                        $id = $urlArray[5];
                        $result = databaseController::leerDatosId($db->getConnection(), $id);
                    }
                }else{
                    solicitudError();
                }
            }
        }else if(obtenerRol() === "0" || obtenerRol() === "1"){
            if (str_contains("/api/usuario/ranking/", $paths)) {
                $result = databaseController::rankingGanadas($db->getConnection());
            }else{
                solicitudError();
            }
        }else{
            solicitudError();
        }
        break;
    case 'POST':
        //Login ADMINISTRADORES / USUARIOS
        if (str_contains("/api/login", $paths)) {
            $requestBody = file_get_contents("php://input");
            $data = json_decode($requestBody);
            if ($data !== null and isset($data->email) and isset($data->password)) {
                $return = databaseController::iniciarSesion($db->getConnection(), $data->email, $data->password, $rol);
            }else{
                solicitudError();
            }
        //Insertar USUARIOS -> Funcionalidad del Administrador
        }else if(str_contains("/api/administrador/usuarios/insertar/", $paths)){
            switch (obtenerRol()) {
                case 0:
                    $requestBody = file_get_contents("php://input");
                    $data = json_decode($requestBody);
                    if ($data !== null and isset($data->id) and isset($data->password) and isset($data->rol) and isset($data->nombre) and isset($data->email) and isset($data->alta) and isset($data->activo) and isset($data->partidasJugadas) and isset($data->partidasGanadas)) {
                        $persona = new Personas($data->id, $data->password, $data->rol, $data->nombre, $data->email, $data->alta, $data->activo, 0, 0);
                        $result = databaseController::anadirUsuario($db->getConnection(), $persona);
                    }else{
                        solicitudError();
                    }    
                    break;
                
                default:
                    solicitudError();
                    break;
            }
        //Generar Tablero -> Funcionalidad común
        }else if (obtenerRol() === "0" || obtenerRol() === "1") {
            $urlArray = explode('/', parse_url($paths, PHP_URL_PATH));
            if($urlArray[2] === "generar" && $urlArray[3] === "tablero"){
                if(count($urlArray) === 6){
                    $result = juegoBuscaminasController::crearTableroJuego($db->getConnection(), POSICIONESTABLERO, MINAS, $urlArray[4]);
                }else if(count($urlArray) === 8){
                    $result = juegoBuscaminasController::crearTableroJuego($db->getConnection(), $urlArray[5], $urlArray[6], $urlArray[4]);
                }else{
                    header("HTTP/1.1 400 Bad Request");
                }
            }
        }else{
            http_response_code(405); // Código de estado 405 Bad Request
            echo json_encode(["error" => "Verbo no soportado"]);
        }
        break;
    case 'PUT':
        if (obtenerRol() === "0") {
            if (str_contains("/api/administrador/usuarios/alta/", $paths)) {
                $requestBody = file_get_contents("php://input");
                $data = json_decode($requestBody);
    
                if ($data !== null and isset($data->id)) {
                    $result = databaseController::altaUsuario($db->getConnection(), $data->id);
    
                } else {
                    solicitudError();
                }
            }else if (str_contains("/api/administrador/usuarios/baja/", $paths)) {
                $requestBody = file_get_contents("php://input");
                $data = json_decode($requestBody);
    
                if ($data !== null and isset($data->id)) {
                    $result = databaseController::bajaUsuario($db->getConnection(), $data->id);
                } else {
                  solicitudError();
                }
            }else if (str_contains("/api/administrador/usuarios/activo/", $paths)) {
                $requestBody = file_get_contents("php://input");
                $data = json_decode($requestBody);
        
                if ($data !== null and isset($data->id)) {
                    $result = databaseController::activoUsuario($db->getConnection(), $data->id);
                } else {
                    solicitudError();
                }
            }else if (str_contains("/api/administrador/usuarios/desactivo/", $paths)) {
                $requestBody = file_get_contents("php://input");
                $data = json_decode($requestBody);
            
                if ($data !== null and isset($data->id)) {
                    $result = databaseController::desactivoUsuario($db->getConnection(), $data->id);
                    if ($result !== null) {
                        header("HTTP/1.1 200 OK");
                        echo json_encode($result);
                    } else {
                        header("HTTP/1.1 401 Unauthorized");
                    }
                }else{
                  header("HTTP/1.1 400 Bad Request");
                }
            }else if (str_contains("/api/administrador/usuarios/cambiarcontrasena/", $paths)) {
                $requestBody = file_get_contents("php://input");
                $data = json_decode($requestBody);
                if ($data !== null and isset($data->id) and isset($data->password)) {
                    $result = databaseController::cambiarContrasena($db->getConnection(), $data->id, $data->password);
                } else {
                    solicitudError();
                }
            }else if(str_contains("/api/administrador/usuarios/modificar/", $paths)){
                //No funciona
                $urlArray = explode('/', parse_url($paths, PHP_URL_PATH));
                $requestBody = file_get_contents("php://input");
                $data = json_decode($requestBody);
                if (count($urlArray) >= 5 && strpos($urlArray[1], 'api') !== false && strpos($urlArray[2], 'administrador') !== false && strpos($urlArray[3], 'usuarios') !== false && strpos($urlArray[4], 'modificar') !== false) {
                    $id = end($urlArray);
                    $result = databaseController::actualizarDatos($db->getConnection(), $id, $data); 
                }
            }else{
                solicitudError();
            }
        }else if(obtenerRol() === "1"){

        }else{
            solicitudError();
        }
        break;
    case 'DELETE':
        if(obtenerRol() === "0"){
            $urlArray = explode('/', parse_url($paths, PHP_URL_PATH));
      
            if (count($urlArray) >= 5 && strpos($urlArray[1], 'api') !== false && strpos($urlArray[2], 'administrador') !== false && strpos($urlArray[3], 'usuarios') !== false && strpos($urlArray[4], 'eliminar') !== false) {
                $id = end($urlArray);
                $result = databaseController::eliminarUsuarioId($db->getConnection(), $id);
            }else{
                solicitudError();
            }  
        }else if(obtenerRol() === "1"){

        }else{
            solicitudError();
        }
        break;
    default:
        solicitudError();
        break;
}

function obtenerRol(){
    if (isset($_SESSION['rol'])) {
        $rol = $_SESSION['rol'];
        return $rol[7];
    } else {
        echo json_encode(["message" => "No se ha iniciado sesión"]);
    }
}

function solicitudError(){
    // La solicitud está incompleta o mal formada
    http_response_code(400); // Código de estado 400 Bad Request
    echo json_encode(["error" => "Solicitud incorrecta"]);
    
}

?>