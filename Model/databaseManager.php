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
                $stmt->close();
                return true;
            } else {
                $stmt->close();
                return false;
            }
        } else {
            $stmt->close();
            return false;
        }
    } else {
        $stmt->close();
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
        $stmt->close();
        return array("success" => true, "message" => "Datos insertados correctamente.");
    } else {
        $stmt->close();
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
        $stmt->close();
        return array("success" => true, "message" => "Alta modificada correctamente.");
    } else {
        $stmt->close();
        return array("success" => false, "message" => "Error al modificar el valor de alta: " . $stmt->error);
    }
}


function generarActivoDesactivo($conexion, $id, $nuevoValorActivo) {
    $sql = "UPDATE personas SET activo = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        return array("success" => false, "message" => "Error al preparar la consulta: " . $conexion->error);
    }
    $stmt->bind_param("ii", $nuevoValorActivo, $id);
    if ($stmt->execute()) {
        $stmt->close();
        return array("success" => true, "message" => "Activo modificada correctamente.");
    } else {
        $stmt->close();
        return array("success" => false, "message" => "Error al modificar el valor de alta: " . $stmt->error);
    }
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
                $stmt->close();
                return $datos;
            } else {
                $stmt->close();
                return array();
            }
        } else {
            $stmt->close();
            return false;
        }
    } else {
        $stmt->close();
        return false;
    }
}

function leerDatosPorID($conexion, $id) {
    $consulta = "SELECT * FROM personas WHERE ID = ?";
    if ($stmt = $conexion->prepare($consulta)) {
        $stmt->bind_param("s", $id);
        if ($stmt->execute()) {
            $resultados = $stmt->get_result();
            if ($resultados->num_rows === 1) {
                $fila = mysqli_fetch_assoc($resultados);
                $stmt->close();
                return $fila;
            } else {
                $stmt->close();
                return null;
            }
        } else {
            $stmt->close();
            return false;
        }
    } else {
        $stmt->close();
        return false;
    }
}

function eliminarUsuarioPorID($conexion, $id) {
    $consulta = "DELETE FROM personas WHERE ID = ?";
    if ($stmt = $conexion->prepare($consulta)) {
        $stmt->bind_param("s", $id);
    if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    } else {
        $stmt->close();
        return false;
    }
}

function cambiarContraseñaPorID($conexion, $id, $nuevaContraseña) {
    $consulta = "UPDATE personas SET PASSWORD = ? WHERE ID = ?";
    if ($stmt = $conexion->prepare($consulta)) {
        $stmt->bind_param("ss", $nuevaContraseña, $id);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            return false;
        }
    } else {
        $stmt->close();
        return false;
    }
    
}

?>