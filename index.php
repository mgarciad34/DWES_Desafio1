<?php

header("Content-Type: application/json");

require 'config/routes.php';
require('Model/Personas.php');
require 'Controller/databaseController.php';

$requestMethod = $_SERVER["REQUEST_METHOD"];
$paths = $_SERVER['REQUEST_URI'];
$argus = explode('/', $paths);
unset($argus[0]);

//Conexion con nuestra BBDD
$rol = null;
$db = new Database();


switch ($requestMethod) {
    case 'GET':
       
      break;

    case 'POST':
      /*
      {
        "email": "administrador@buscaminas.com",
        "password": "admin"
      }
      */
      if(str_contains(LOGIN, $paths)){
        $requestBody = file_get_contents("php://input");
        $data = json_decode($requestBody);
        $rol = databaseController::iniciarSesion($db->getConnection(), $data->email, $data->password);    
        echo $rol;
      }
      break;
    case 'PUT':
      break;

    case 'DELETE':
      break;          
    default:
      break;
}
?>