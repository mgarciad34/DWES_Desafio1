<?php
// routes.php

//Administradores
//POST
define('LOGIN', '/api/login');
define('INSERTARUSUARIO', '/api/administrador/usuarios/insertar/');

//GET
define('LISTARUSUARIOS', '/api/administrador/usuarios/listar');
define('LISTARUSUARIOSID', '/api/administrador/usuarios/listarid/');
//PUT
define('ALTAUSUARIO', '/api/administrador/usuarios/alta/');
define('BAJAUSUARIO', '/api/administrador/usuarios/baja/');
define('ACTIVARUSUARIO', '/api/administrador/usuarios/activo/');
define('DESACTIVARUSUARIO', '/api/administrador/usuarios/desactivo/');
define('CAMBIARCONTRASENA', '/api/administrador/usuarios/cambiarcontrasena/');
define('MODIFICARUSUARIOID', '/api/administrador/usuarios/modificar/?');

//DELETE
define('ELIMINARUSUARIOID', '/api/administrador/usuarios/eliminar/?');
?>