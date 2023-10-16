<?php

class juegoBuscaminasController{

public static function crearTableroJuego($db, $posicionesTablero, $posicionesMinas, $id){
    $tablero = iniciarTablero($posicionesTablero, 0);
    $tablero = colocarMinas($tablero, $posicionesMinas);
    $tablerousuario = iniciarTablero($posicionesTablero, "t");

    $result = insertarTablero($db, $id, $tablero, $tablerousuario, "false");
    if ($result !== null) {
        header("HTTP/1.1 200 OK");
        return $result;
    } else {
        header("HTTP/1.1 400 Bad Request");
    }
    
}

}

?>