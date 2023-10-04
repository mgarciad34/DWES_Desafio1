<?php


//Llamamos a la clase Buscaminas
require 'Buscaminas.php';
$posiciones = 6;
$tableroUsuario = null;

//Creamos una variable que nos da el tablero inicial, sin colocar minas
$tablero = iniciarTablero($posiciones, 0);

//Actualizamos el tablero con las minas
$tablero = colocarMinas($tablero, 2);

// Añadimos las pistas y se actualiza el tablero, que ya estaría montado
$tablero = generarPistas($tablero);

//Ahora agregamos el tablero del usuario
$tableroUsuario = generarTableroJugador($tableroUsuario, $posiciones, "t");
echo json_encode($tableroUsuario);



?>