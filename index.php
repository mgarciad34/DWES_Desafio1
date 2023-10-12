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
       // En una solicitud GET, puedes acceder al valor de $rol almacenado en la sesión.
    if (isset($_SESSION['rol'])) {
      $rol = $_SESSION['rol'];
      echo json_encode(["rol" => $rol]);
  } else {
      echo json_encode(["message" => "No se ha iniciado sesión"]);
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
            // Después de asignar $rol
            echo "Rol después de iniciar sesión: " . $rol;

            // Almacenar en la sesión
            $_SESSION['rol'] = $rol;
          } else {
            // Si los datos JSON no se decodificaron correctamente o faltan campos
            echo json_encode(["error" => "Datos de inicio de sesión incorrectos"]);
        }
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
