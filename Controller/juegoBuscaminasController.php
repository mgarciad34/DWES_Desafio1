<?php

require "Model/juegoBuscaminas.php";
class juegoBuscaminasController{

public static function crearTableroJuego($db, $posicionesTablero, $posicionesMinas, $id){
    $tablero = iniciarTablero($posicionesTablero, 0);
    $tablero = colocarMinas($tablero, $posicionesMinas);
    $tablerousuario = iniciarTablero($posicionesTablero, "t");
    return insertarTablero($db, $id, json_encode($tablero), json_encode($tablerousuario), "false");
}

}

?>