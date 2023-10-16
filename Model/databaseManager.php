<?php
require 'config/Database.php';
require 'Model/mail.php';

function login($conexion, $email, $pass) {
    $consulta = "SELECT ROL FROM personas WHERE EMAIL = ? AND PASSWORD = ?";
    
    if ($stmt = $conexion->prepare($consulta)) {
        $stmt->bind_param("ss", $email, md5($pass));

        if ($stmt->execute()) {
            $resultados = $stmt->get_result();

            if ($resultados->num_rows === 1) {
                $array = mysqli_fetch_assoc($resultados);
                $stmt->close();
                return json_encode($array); // Devuelve un objeto JSON en caso de éxito
            } else {
                $stmt->close();
                return json_encode(["error" => "Credenciales incorrectas"]); // Devuelve un objeto JSON en caso de credenciales incorrectas
            }
        } else {
            $stmt->close();
            return json_encode(["error" => "Error en la consulta SQL"]); // Devuelve un objeto JSON en caso de error en la consulta SQL
        }
    } else {
        return json_encode(["error" => "Error en la preparación de la consulta SQL"]); // Devuelve un objeto JSON en caso de error en la preparación de la consulta SQL
    }
}

/*echo json_encode(login($db->getConnection(), 0, "administrador"));
echo json_encode(insertarDatos($db->getConnection(), 1, "pswd001", 1, "nombre1", "usuario1@email.com", 0, 0, 0, 0));*/


function insertarDatos($conexion, $id, $password, $rol, $nombre, $email, $alta, $activo, $partidasJugadas, $partidasGanadas) {
    $sql = "INSERT INTO personas (id, password, rol, nombre, email, alta, activo, partidasJugadas, partidasGanadas) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        return array("success" => false, "message" => "Error al preparar la consulta: " . $conexion->error);
    }
    $pass = md5($password);
    $stmt->bind_param("isssssiii", $id, $pass, $rol, $nombre, $email, $alta, $activo, $partidasJugadas, $partidasGanadas);
    if ($stmt->execute()) {
        $stmt->close();
        enviarCorreo($email, "Alta de usuario", "Su usuario acaba de ser dado de alta en el juego del Buscaminas");
        return array("success" => true, "message" => "Datos insertados correctamente.");
    } else {
        $stmt->close();
        return array("success" => false, "message" => "Error al insertar datos: " . $stmt->error);
    }
    $stmt->close();
    
}

function generarAltaBaja($conexion, $id, $funcion) {
    $nuevoValorAlta = null;
    if($funcion === "Alta"){
        $nuevoValorAlta = 1;
    }else if($funcion == "Baja"){
        $nuevoValorAlta = 0;
    }
    $sql = "UPDATE personas SET alta = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        return array("success" => false, "message" => "Error al preparar la consulta: " . $conexion->error);
    }
    $stmt->bind_param("ii", $nuevoValorAlta, $id);
    if ($stmt->execute()) {
        $stmt->close();
        return  $funcion;
    } else {
        $stmt->close();
        return false;
    }
}


function generarActivoDesactivo($conexion, $id, $funcion) {
    $nuevoValorActivo = null;
    if($funcion === "Activo"){
        $nuevoValorActivo = 1;
    }else if($funcion === "Desactivo"){
        $nuevoValorActivo = 0;
    }
    
    $sql = "UPDATE personas SET activo = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        return array("success" => false, "message" => "Error al preparar la consulta: " . $conexion->error);
    }
    $stmt->bind_param("ii", $nuevoValorActivo, $id);
    if ($stmt->execute()) {
        $stmt->close();
        return  $funcion;
    } else {
        $stmt->close();
        return  false;
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
                echo "No se encontró ningún resultado o se encontraron múltiples resultados.";
                return null;
            }
        } else {
            $stmt->close();
            echo "Error en la ejecución de la consulta.";
            return false;
        }
    } else {
        $stmt->close();
        echo "Error en la preparación de la consulta.";
        return false;
    }
}

function eliminarUsuarioPorID($conexion, $id) {
    $consulta = "DELETE FROM personas WHERE ID = ?";
    if ($stmt = $conexion->prepare($consulta)) {
        $stmt->bind_param("s", $id);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                // Al menos un registro se eliminó con éxito
                $stmt->close();
                return true;
            } else {
                // No se eliminaron registros, pero la consulta se ejecutó sin errores
                $stmt->close();
                return false;
            }
        } else {
            // Error en la ejecución de la consulta
            $stmt->close();
            return false;
        }
    } else {
        // Error en la preparación de la consulta
        return false;
    }
}

function cambiarContrasenaPorID($conexion, $id, $nuevaContrasena) {
    $consulta = "UPDATE personas SET PASSWORD = ? WHERE ID = ?";
    if ($stmt = $conexion->prepare($consulta)) {
        $stmt->bind_param("ss", md5($nuevaContrasena), $id);
        if ($stmt->execute()) {
            $stmt->close();
            return "Contraseña Cambiada";
        } else {
            return false;
        }
    } else {
        $stmt->close();
        return false;
    }
    
}

function actualizarDatosPorId($conexion, $id, $data) {
    
    foreach ($data as $key => $value) {
        echo $key;
    }
    echo $data->password;
    
    

    /*$queryStart = "UPDATE personas SET";
    $queryEnd = "WHERE id = ". $id;

    $query = $queryStart . $queryInt . $queryEnd;
        try{
            mysqli_query($conexion, $query);
            echo "Datos actualizados";
        }catch(Exception $e){
            echo "Fallo al actualizar: (" . $e->getMessage() . ") <br>";
        }*/
}

function mostrarRanking($conexion) {
    $consulta = "SELECT ID, PARTIDASJUGADAS, PARTIDASGANADAS FROM personas ORDER BY PARTIDASGANADAS DESC";
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


function insertarTablero($conexion, $idU, $to, $tj, $finalizada) {
    $sql = "INSERT INTO partidas (idU, oculto, tj, finalizada) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        return array("success" => false, "message" => "Error al preparar la consulta: " . $conexion->error);
    }
    $stmt->bind_param("isss", $idU, $to, $tj, $finalizada);
    if ($stmt->execute()) {
        $stmt->close();
        return array("success" => true, "message" => "Datos insertados correctamente.");
    } else {
        $stmt->close();
        return array("success" => false, "message" => "Error al insertar datos: " . $stmt->error);
    }
    $stmt->close();
}

function rendirse($conexion, $idPartida, $idJugador){
    $sql = "UPDATE partidas SET finalizada = 'true' WHERE id = ? AND idU = ?";
    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        return array("success" => false, "message" => "Error al preparar la consulta: " . $conexion->error);
    }

    $stmt->bind_param("ii", $idPartida, $idJugador);

    if ($stmt->execute()) {
        $stmt->close();
        return array("success" => true, "message" => "Partida finalizada");
    } else {
        $stmt->close();
        return array("success" => false, "message" => "Error al modificar dato 'finalizada': " . $stmt->error);
    }
}

function obtenerDatosPartida($conexion, $idPartida, $idUsuario) {
    $sql = "SELECT * FROM partidas WHERE id = ? AND idU = ?";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        return array("success" => false, "message" => "Error al preparar la consulta: " . $conexion->error);
    }
    $stmt->bind_param("ii", $idPartida, $idUsuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        $stmt->close();
        $conexion->close();
        return $resultado->fetch_assoc();
    } else {
        $stmt->close();
        $conexion->close();
        return null;
    }
}

function actualizarTableroUsuario($conexion, $idPartida, $idJugador){
    $sql = "UPDATE partidas SET tj = ? WHERE id = ? AND idU = ?";
    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        return array("success" => false, "message" => "Error al preparar la consulta: " . $conexion->error);
    }

    $stmt->bind_param("iii", $idJugador, $idPartida, $idJugador);

    if ($stmt->execute()) {
        $stmt->close();
        return array("success" => true, "message" => "Partida finalizada");
    } else {
        $stmt->close();
        return array("success" => false, "message" => "Error al modificar dato 'finalizada': " . $stmt->error);
    }
}
?>