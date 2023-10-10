<?php
// routes.php

//Constante para iniciar en el login
define('LOGIN', '/api/login');

//Administradores

define('ALTAUSUARIO', '/api/administrador/usuarios/alta/');
define('BAJAUSUARIO', '/api/administrador/usuarios/baja/?');
define('MODIFICARUSUARIOID', '/api/administrador/usuarios/modificar/?');
define('ELIMINARUSUARIOID', '/api/administrador/usuarios/eliminar/?');

define('LISTARUSUARIOS', '/api/administrador/usuarios/listar');
define('LISTARUSUARIOSID', '/api/administrador/usuarios/listar/?');

define('ACTIVARUSUARIO', '/api/administrador/usuarios/activo/?');
define('DESACTIVARUSUARIO', '/api/administrador/usuarios/desactivo/?');
?>