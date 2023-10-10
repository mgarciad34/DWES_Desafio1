<?php

header("Content-Type: application/json");

require 'config/routes.php';
require('Model/Personas.php');
require 'Controller/databaseController.php';

$requestMethod = $_SERVER["REQUEST_METHOD"];
$paths = $_SERVER['REQUEST_URI'];
//Conexion con nuestra BBDD
$db = new Database();
$rol = null;

switch ($requestMethod) {
    case 'GET':
        print_r($paths);
       break;

    case 'POST':
       # code...
       break;
    case 'PUT':
       # code...
       break;

    case 'DELETE':
       # code...
       break;          
    default:
        # code...
        break;
}
?>