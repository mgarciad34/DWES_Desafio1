<?php
// routes.php

//Constante para iniciar en el login
define('LOGIN', '/api/login');

//Administradores

//POST
define('ALTAUSUARIO', '/api/administrador/usuarios/alta/');

//GET
define('LISTARUSUARIOS', '/api/administrador/usuarios/listar');
define('LISTARUSUARIOSID', '/api/administrador/usuarios/listar/?');

//PUT
define('BAJAUSUARIO', '/api/administrador/usuarios/baja/?');
define('MODIFICARUSUARIOID', '/api/administrador/usuarios/modificar/?');
define('ACTIVARUSUARIO', '/api/administrador/usuarios/activo/?');
define('DESACTIVARUSUARIO', '/api/administrador/usuarios/desactivo/?');
define('CAMBIARCONTRASENA', '/api/administrador/usuarios/cambiarcontrasena/?');

//DELETE
define('ELIMINARUSUARIOID', '/api/administrador/usuarios/eliminar/?');
?>