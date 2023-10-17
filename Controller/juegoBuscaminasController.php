<?php
require 'Model/juegoBuscaminas.php';

class juegoBuscaminasController{

public static function crearTableroJuego($db, $posicionesTablero, $posicionesMinas, $id){
    $tablero = iniciarTablero($posicionesTablero, 0);
    $tablero = colocarMinas($tablero, $posicionesMinas);
    $tablero = generarPistas($tablero);
    $tablerousuario = iniciarTablero($posicionesTablero, "t");
    $datosTableroUsuario = implode(", ", $tablerousuario);
    $datosTableroOculto = implode(", ", $tablero);
    $result = insertarTablero($db, $id, $datosTableroOculto, $datosTableroUsuario, "0");
    if ($result !== null) {
        header("HTTP/1.1 200 OK");
        return $result;
    } else {
        header("HTTP/1.1 400 Bad Request");
    }
    
}

}

?>