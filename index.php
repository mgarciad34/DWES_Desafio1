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
            if (str_contains(LISTARUSUARIOS, $paths)) {
                // Procesa la solicitud para listar usuarios
            } elseif (str_contains(LISTARUSUARIOSID, $paths)) {
              
            }
        } elseif (obtenerRol() === "1") {
            // Procesa solicitudes para un rol diferente
        } else {
            // Si no se ha iniciado sesión, mostrar el mensaje
            echo json_encode(["message" => "No se ha iniciado sesión"]);
        }
        break;

    case 'POST':
        if (str_contains(LOGIN, $paths)) {
            $requestBody = file_get_contents("php://input");
            $data = json_decode($requestBody);

            if ($data !== null && isset($data->email) && isset($data->password)) {
                $rol = databaseController::iniciarSesion($db->getConnection(), $data->email, $data->password);

                if ($rol !== null) {
                    header("HTTP/1.1 200 OK");
                    $_SESSION['rol'] = $rol;
                } else {
                    header("HTTP/1.1 401 Unauthorized");
                }
            } else {
                header("HTTP/1.1 400 Bad Request");
            }
        } elseif (str_contains(INSERTARUSUARIO, $paths)) {
            if (obtenerRol() === "0") {
                $requestBody = file_get_contents("php://input");
                $data = json_decode($requestBody);

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
            } elseif (obtenerRol() === "1") {
                // Procesar solicitud para un rol diferente
            } else {
                header("HTTP/1.1 400 Bad Request");
            }
        }
        break;

    case 'PUT':
        if (obtenerRol() === "0") {
          if (str_contains(ALTAUSUARIO, $paths)) {
            $requestBody = file_get_contents("php://input");
            $data = json_decode($requestBody);

            if ($data !== null && isset($data->id)) {
                $result = databaseController::altaUsuario($db->getConnection(), $data->id);

                if ($result !== null) {
                    header("HTTP/1.1 200 OK");
                    echo json_encode($result);
                } else {
                    header("HTTP/1.1 401 Unauthorized");
                }
            } else {
                header("HTTP/1.1 400 Bad Request");
            }
          }elseif (str_contains(BAJAUSUARIO, $paths)) {
            $requestBody = file_get_contents("php://input");
            $data = json_decode($requestBody);

            if ($data !== null && isset($data->id)) {
                $result = databaseController::bajaUsuario($db->getConnection(), $data->id);

                if ($result !== null) {
                    header("HTTP/1.1 200 OK");
                    echo json_encode($result);
                } else {
                    header("HTTP/1.1 401 Unauthorized");
                }
          } else {
              header("HTTP/1.1 400 Bad Request");
          }
      }elseif (str_contains(ACTIVARUSUARIO, $paths)) {
        $requestBody = file_get_contents("php://input");
        $data = json_decode($requestBody);

        if ($data !== null && isset($data->id)) {
            $result = databaseController::activoUsuario($db->getConnection(), $data->id);

            if ($result !== null) {
                header("HTTP/1.1 200 OK");
                echo json_encode($result);
            } else {
                header("HTTP/1.1 401 Unauthorized");
            }
      } else {
          header("HTTP/1.1 400 Bad Request");
      }
  }else if (str_contains(DESACTIVARUSUARIO, $paths)) {
    $requestBody = file_get_contents("php://input");
    $data = json_decode($requestBody);

    if ($data !== null && isset($data->id)) {
        $result = databaseController::desactivoUsuario($db->getConnection(), $data->id);

        if ($result !== null) {
            header("HTTP/1.1 200 OK");
            echo json_encode($result);
        } else {
            header("HTTP/1.1 401 Unauthorized");
        }
  } else {
      header("HTTP/1.1 400 Bad Request");
  }
}else if (str_contains(CAMBIARCONTRASENA, $paths)) {
  $requestBody = file_get_contents("php://input");
  $data = json_decode($requestBody);

  if ($data !== null && isset($data->id) && isset($data->password)) {
      $result = databaseController::cambiarContrasena($db->getConnection(), $data->id, $data->password);

      if ($result !== null) {
          header("HTTP/1.1 200 OK");
          echo json_encode($result);
      } else {
          header("HTTP/1.1 401 Unauthorized");
      }
} else {
    header("HTTP/1.1 400 Bad Request");
}
}


        } elseif (obtenerRol() === "1") {
            // Procesar solicitudes PUT para rol 1
        } else {
            // Procesar otras solicitudes PUT
        }
        break;

    case 'DELETE':
        if (obtenerRol() === "0") {
            // Procesar solicitudes DELETE para rol 0
        } elseif (obtenerRol() === "1") {
            // Procesar solicitudes DELETE para rol 1
        } else {
            // Procesar otras solicitudes DELETE
        }
        break;

    default:
        // Procesar otros métodos
        break;
}

function obtenerRol()
{
    if (isset($_SESSION['rol'])) {
        $rol = $_SESSION['rol'];
        return $rol[7];
    } else {
        echo json_encode(["message" => "No se ha iniciado sesión"]);
    }
}
?>
