<?php

//Funcion que inicia el tablero
function iniciarTablero($posiciones, $valor){
    $vectorJuego = array_fill(0, $posiciones, $valor);
    return $vectorJuego;
}
// Funcion para colocar las minas
function colocarMinas($tablero, $minas) {
    $totalCasillas = count($tablero);
    $contadorMinas = 0;

    for ($i = 0; $i < $totalCasillas; $i++) {
        //Numero aleatorio para elegir la posicion de la mina por defecto elegimos con el 1
        $aleatorio = rand(0, 1);
        if ($aleatorio == 0) {
            $tablero[$i] = "0";
        } else {
            //Si el contador de minas es menor de dos agregamos la mina, sino la cambiamos por un 0
            if($contadorMinas < $minas){
                $tablero[$i] = "M";
                $contadorMinas++;    
            }else{
                $tablero[$i] = "0";
            }
            
        }
    }
    return $tablero;
}

function generarPistas($tablero) {
    for ($i = 0; $i < count($tablero); $i++) {
        if ($tablero[$i] === "0") {
            $contadorMinas = 0;
            
            // Comprobar la casilla anterior (una posición menos)
            if ($i > 0 && $tablero[$i - 1] === "M") {
                $contadorMinas++;
            }

            // Comprobar la casilla siguiente (una posición más)
            if ($i < count($tablero) - 1 && $tablero[$i + 1] === "M") {
                $contadorMinas++;
            }

            // Asignar el valor del contador como pista en la casilla actual
            $tablero[$i] = strval($contadorMinas);
        }
    }

    return $tablero;
}

function generarTableroJugador($tableroJugador, $posiciones, $valor) {
    $tableroJugador = iniciarTablero($posiciones, $valor);


    return $tableroJugador;
}
?>