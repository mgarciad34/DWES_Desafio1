<?php

session_start(); // Inicia la sesión

header("Content-Type: application/json");

require 'config/routes.php';
require('Model/Personas.php');
require 'Controller/databaseController.php';

$requestMethod = $_SERVER["REQUEST_METHOD"];
$paths = $_SERVER['REQUEST_URI'];
$argus = explode('/', $paths);
unset($argus[0]);
$rol = null;
$db = new Database();

switch ($requestMethod) {
    case 'GET':
      if (obtenerRol() === "0") {
        
      }elseif(obtenerRol() === "1"){
      
      }else{

      }
      break;

    case 'POST':
      /*
      {
        "email": "administrador@buscaminas.com",
        "password": "admin"
      }
      */
      if (str_contains(LOGIN, $paths)) {
        $requestBody = file_get_contents("php://input");
        $data = json_decode($requestBody);
        
        //isset -> Comprueba si una variable esta definida y no es nula
        if ($data !== null && isset($data->email) && isset($data->password)) {
            $rol = databaseController::iniciarSesion($db->getConnection(), $data->email, $data->password);
            if ($rol !== null) {
                header("HTTP/1.1 200 OK");
              // Almacenar el rol en la sesión
              $_SESSION['rol'] = $rol;
          } else {
            //Si el inicio de sesion es incorrecto mostrara el 401
            header("HTTP/1.1 401 Unauthorized");
          }
      } else {
          //Si la peticion es incorrecta mostrara el 400
          header("HTTP/1.1 400 Bad Request");
      }
    }else if(str_contains(ALTAUSUARIO, $paths)){
      if(obtenerRol() === "0"){
        $requestBody = file_get_contents("php://input");
        $data = json_decode($requestBody);
      
        //isset -> Comprueba si una variable esta definida y no es nula
        if ($data !== null && isset($data->id) && isset($data->password) && isset($data->rol) && isset($data->nombre) && isset($data->email) && isset($data->alta) && isset($data->activo) && isset($data->partidasJugadas) && isset($data->partidasGanadas)) {
          $persona = new Personas($data->id, $data->password, $data->rol, $data->nombre, $data->email, $data->alta, $data->activo, $data->partidasJugadas, $data->partidasGanadas);
          $result = databaseController::anadirUsuario($db->getConnection(), $persona);
          if ($result !== null) {
            header("HTTP/1.1 200 OK");
          } else {
            header("HTTP/1.1 401 Unauthorized");
          }
      } else {
          header("HTTP/1.1 400 Bad Request");
      }
      }else if(obtenerRol() === "1"){

      }else{

      }
    }
      break;
    case 'PUT':
      if (obtenerRol() === "0") {
        
      }elseif(obtenerRol() === "1"){
      
      }else{

      }
      break;

    case 'DELETE':
      if (obtenerRol() === "0") {
        
      }elseif(obtenerRol() === "1"){
      
      }else{

      }

      break;          
    default:
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

?>