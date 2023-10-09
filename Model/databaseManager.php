<?php
require '../config/Database.php';

function login($conexion, $id, $password) {
    // Consulta SQL parametrizada para verificar la autenticación del administrador
    $consulta = "SELECT * FROM personas WHERE ID = ? AND PASSWORD = ? AND ROL = 0";

    // Preparar la consulta con marcadores de posición
    if ($stmt = $conexion->prepare($consulta)) {
        // Vincular los parámetros
        $stmt->bind_param("ss", $id, $password);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Obtener los resultados
            $resultados = $stmt->get_result();

            // Verificar si se encontraron resultados
            if ($resultados->num_rows === 1) {
                // Autenticación exitosa
                $array = mysqli_fetch_assoc($resultados);
                return true;
            } else {
                // Autenticación fallida
                return false;
            }
        } else {
            // Error al ejecutar la consulta
            return false;
        }
    } else {
        // Error en la preparación de la consulta
        return false;
    }
    // Cerrar la consulta
    $stmt->close();
}

$db = new Database();
/*echo json_encode(login($db->getConnection(), 0, "administrador"));
echo json_encode(insertarDatos($db->getConnection(), 1, "pswd001", 1, "nombre1", "usuario1@email.com", 0, 0, 0, 0));*/


function insertarDatos($conexion, $id, $password, $rol, $nombre, $email, $alta, $activo, $partidasJugadas, $partidasGanadas) {
    // Preparar la consulta SQL
    $sql = "INSERT INTO personas (id, password, rol, nombre, email, alta, activo, partidasJugadas, partidasGanadas) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Preparar una declaración
    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        return array("success" => false, "message" => "Error al preparar la consulta: " . $conexion->error);
    }
    
    // Vincular los parámetros a la declaración
    // Ajustar los tipos de datos según corresponda
    $stmt->bind_param("isssssiii", $id, $password, $rol, $nombre, $email, $alta, $activo, $partidasJugadas, $partidasGanadas);
    
    // Ejecutar la declaración
    if ($stmt->execute()) {
        // Devolver un indicador de éxito y un mensaje descriptivo
        return array("success" => true, "message" => "Datos insertados correctamente.");
    } else {
        // Devolver un indicador de error y un mensaje descriptivo
        return array("success" => false, "message" => "Error al insertar datos: " . $stmt->error);
    }
    
    // Cerrar la declaración (no es necesario cerrar la conexión aquí)
    $stmt->close();
}

function generarAltaBaja($conexion, $id, $nuevoValorAlta) {
    $sql = "UPDATE personas SET alta = ? WHERE id = ?";
    
    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        return array("success" => false, "message" => "Error al preparar la consulta: " . $conexion->error);
    }
    
    // Vincular los parámetros a la declaración
    $stmt->bind_param("ii", $nuevoValorAlta, $id);
    
    // Ejecutar la declaración de actualización
    if ($stmt->execute()) {
        // Devolver un indicador de éxito y un mensaje descriptivo
        return array("success" => true, "message" => "Alta modificada correctamente.");
    } else {
        // Devolver un indicador de error y un mensaje descriptivo
        return array("success" => false, "message" => "Error al modificar el valor de alta: " . $stmt->error);
    }
    
    // Cerrar la declaración (no es necesario cerrar la conexión aquí)
    $stmt->close();
}


function generarActivoDesactivo($conexion, $id, $nuevoValorActivo) {
    $sql = "UPDATE personas SET activo = ? WHERE id = ?";
    
    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        return array("success" => false, "message" => "Error al preparar la consulta: " . $conexion->error);
    }
    
    // Vincular los parámetros a la declaración
    $stmt->bind_param("ii", $nuevoValorActivo, $id);
    
    // Ejecutar la declaración de actualización
    if ($stmt->execute()) {
        // Devolver un indicador de éxito y un mensaje descriptivo
        return array("success" => true, "message" => "Activo modificada correctamente.");
    } else {
        // Devolver un indicador de error y un mensaje descriptivo
        return array("success" => false, "message" => "Error al modificar el valor de alta: " . $stmt->error);
    }
    
    // Cerrar la declaración (no es necesario cerrar la conexión aquí)
    $stmt->close();
}

function leerTodosLosDatos($conexion) {
    // Consulta SQL para seleccionar todos los registros de la tabla personas
    $consulta = "SELECT * FROM personas";

    // Preparar la consulta
    if ($stmt = $conexion->prepare($consulta)) {
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Obtener los resultados
            $resultados = $stmt->get_result();

            // Verificar si se encontraron resultados
            if ($resultados->num_rows > 0) {
                // Crear un array para almacenar todos los resultados
                $datos = array();

                // Recorrer los resultados y agregarlos al array
                while ($fila = mysqli_fetch_assoc($resultados)) {
                    $datos[] = $fila;
                }

                // Devolver el array de datos
                return $datos;
            } else {
                // No se encontraron registros
                return array();
            }
        } else {
            // Error al ejecutar la consulta
            return false;
        }
    } else {
        // Error en la preparación de la consulta
        return false;
    }
    // Cerrar la consulta
    $stmt->close();
}

function leerDatosPorID($conexion, $id) {
    // Consulta SQL para seleccionar un registro de la tabla personas por ID
    $consulta = "SELECT * FROM personas WHERE ID = ?";

    // Preparar la consulta
    if ($stmt = $conexion->prepare($consulta)) {
        // Vincular el parámetro
        $stmt->bind_param("s", $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Obtener los resultados
            $resultados = $stmt->get_result();

            // Verificar si se encontraron resultados
            if ($resultados->num_rows === 1) {
                // Obtener el registro encontrado
                $fila = mysqli_fetch_assoc($resultados);
                
                // Devolver el registro como un array
                return $fila;
            } else {
                // No se encontró el registro
                return null;
            }
        } else {
            // Error al ejecutar la consulta
            return false;
        }
    } else {
        // Error en la preparación de la consulta
        return false;
    }
    // Cerrar la consulta
    $stmt->close();
}


function eliminarUsuarioPorID($conexion, $id) {
    // Consulta SQL para eliminar un usuario por ID
    $consulta = "DELETE FROM personas WHERE ID = ?";

    // Preparar la consulta
    if ($stmt = $conexion->prepare($consulta)) {
        // Vincular el parámetro
        $stmt->bind_param("s", $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Éxito en la eliminación del usuario
            return true;
        } else {
            // Error al ejecutar la consulta
            return false;
        }
    } else {
        // Error en la preparación de la consulta
        return false;
    }
    // Cerrar la consulta
    $stmt->close();
}

function cambiarContraseñaPorID($conexion, $id, $nuevaContraseña) {
    // Consulta SQL para actualizar la contraseña de un usuario por ID
    $consulta = "UPDATE personas SET PASSWORD = ? WHERE ID = ?";

    // Preparar la consulta
    if ($stmt = $conexion->prepare($consulta)) {
        // Vincular los parámetros
        $stmt->bind_param("ss", $nuevaContraseña, $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Éxito en la actualización de la contraseña
            return true;
        } else {
            // Error al ejecutar la consulta
            return false;
        }
    } else {
        // Error en la preparación de la consulta
        return false;
    }
    // Cerrar la consulta
    $stmt->close();
}

?>