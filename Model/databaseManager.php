<?php
require '../config/Database.php';

function login($conexion, $id, $password) {
    $consulta = "SELECT * FROM personas WHERE ID = ? AND PASSWORD = ? AND ROL = 0";
    // Preparar la consulta con marcadores de posición
    if ($stmt = $conexion->prepare($consulta)) {
        // Vincular los parámetros
        $stmt->bind_param("ss", $id, $password);
        if ($stmt->execute()) {
            $resultados = $stmt->get_result();
            if ($resultados->num_rows === 1) {
                $array = mysqli_fetch_assoc($resultados);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
    $stmt->close();
}

$db = new Database();
/*echo json_encode(login($db->getConnection(), 0, "administrador"));
echo json_encode(insertarDatos($db->getConnection(), 1, "pswd001", 1, "nombre1", "usuario1@email.com", 0, 0, 0, 0));*/


function insertarDatos($conexion, $id, $password, $rol, $nombre, $email, $alta, $activo, $partidasJugadas, $partidasGanadas) {
    $sql = "INSERT INTO personas (id, password, rol, nombre, email, alta, activo, partidasJugadas, partidasGanadas) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        return array("success" => false, "message" => "Error al preparar la consulta: " . $conexion->error);
    }
    $stmt->bind_param("isssssiii", $id, $password, $rol, $nombre, $email, $alta, $activo, $partidasJugadas, $partidasGanadas);
    if ($stmt->execute()) {
        return array("success" => true, "message" => "Datos insertados correctamente.");
    } else {
        return array("success" => false, "message" => "Error al insertar datos: " . $stmt->error);
    }
    $stmt->close();
}

function generarAltaBaja($conexion, $id, $nuevoValorAlta) {
    $sql = "UPDATE personas SET alta = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        return array("success" => false, "message" => "Error al preparar la consulta: " . $conexion->error);
    }
    $stmt->bind_param("ii", $nuevoValorAlta, $id);
    if ($stmt->execute()) {
        return array("success" => true, "message" => "Alta modificada correctamente.");
    } else {
        return array("success" => false, "message" => "Error al modificar el valor de alta: " . $stmt->error);
    }
    $stmt->close();
}


function generarActivoDesactivo($conexion, $id, $nuevoValorActivo) {
    $sql = "UPDATE personas SET activo = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        return array("success" => false, "message" => "Error al preparar la consulta: " . $conexion->error);
    }
    $stmt->bind_param("ii", $nuevoValorActivo, $id);
    if ($stmt->execute()) {
        return array("success" => true, "message" => "Activo modificada correctamente.");
    } else {
        return array("success" => false, "message" => "Error al modificar el valor de alta: " . $stmt->error);
    }
    $stmt->close();
}

function leerTodosLosDatos($conexion) {
    $consulta = "SELECT * FROM personas";
    if ($stmt = $conexion->prepare($consulta)) {
        if ($stmt->execute()) {
            $resultados = $stmt->get_result();
        if ($resultados->num_rows > 0) {
                $datos = array();
                while ($fila = mysqli_fetch_assoc($resultados)) {
                    $datos[] = $fila;
                }
                return $datos;
            } else {
                return array();
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
    $stmt->close();
}

function leerDatosPorID($conexion, $id) {
    $consulta = "SELECT * FROM personas WHERE ID = ?";
    if ($stmt = $conexion->prepare($consulta)) {
        $stmt->bind_param("s", $id);
        if ($stmt->execute()) {
            $resultados = $stmt->get_result();
        if ($resultados->num_rows === 1) {
                $fila = mysqli_fetch_assoc($resultados);
                return $fila;
            } else {
                return null;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
    $stmt->close();
}

function eliminarUsuarioPorID($conexion, $id) {
    $consulta = "DELETE FROM personas WHERE ID = ?";
    if ($stmt = $conexion->prepare($consulta)) {
        $stmt->bind_param("s", $id);
    if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
    $stmt->close();
}

function cambiarContraseñaPorID($conexion, $id, $nuevaContraseña) {
    $consulta = "UPDATE personas SET PASSWORD = ? WHERE ID = ?";
    if ($stmt = $conexion->prepare($consulta)) {
        $stmt->bind_param("ss", $nuevaContraseña, $id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
    $stmt->close();
}

?>