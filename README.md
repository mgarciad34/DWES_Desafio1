
# API de Gestión de Usuarios y Juego Buscaminas

Este es un archivo README para el código PHP que implementa una API de gestión de usuarios y funcionalidad del juego Buscaminas. A continuación, se proporciona una descripción general de las rutas y funcionalidades implementadas en este código.

## Rutas y Funcionalidades

A continuación se describen las rutas y funcionalidades disponibles en este código:

- `GET /api/administrador/usuarios/listar/`: Lista todos los usuarios (solo para administradores).

  ![ListarUsuarios](https://github.com/mgarciad34/DWES_Desafio1/blob/main/images/ListarUsuarios.png)

  ![ListarUsuariosID](https://github.com/mgarciad34/DWES_Desafio1/blob/main/images/ListarUsuariosID.png)

- `GET /api/usuario/ranking/`: Obtiene el ranking de partidas ganadas por usuarios (disponible para administradores y usuarios).

  ![RankingUsuarios](https://github.com/mgarciad34/DWES_Desafio1/blob/main/images/Ranking.png)

- `GET /api/usuario/generar/tablero/{id}/{posiciones}/{minas}`: Genera un tablero de juego Buscaminas con las dimensiones especificadas.

  ![TableroPersonalizado](https://github.com/mgarciad34/DWES_Desafio1/blob/main/images/tableroPersonalizado.png)

- `GET /api/usuario/generar/tablero/{id}/{posiciones}/{minas}`: Genera un tablero de juego Buscaminas con las dimensiones definidas.

  ![TableroEstandar](https://github.com/mgarciad34/DWES_Desafio1/blob/main/images/tableroEstandar.png)

- `POST /api/administrador/usuarios/insertar/`: Inserta un nuevo usuario (solo para administradores).

  ![InsertarUsuario](https://github.com/mgarciad34/DWES_Desafio1/blob/main/images/insertarUsuario.png)

- `PUT /api/administrador/usuarios/alta/`: Activa un usuario (solo para administradores).

- `PUT /api/administrador/usuarios/baja/`: Desactiva un usuario (solo para administradores).

- `PUT /api/administrador/usuarios/activo/`: Activa un usuario (solo para administradores).

- `PUT /api/administrador/usuarios/desactivo/`: Desactiva un usuario (solo para administradores).

- `PUT /api/administrador/usuarios/cambiarcontrasena/`: Cambia la contraseña de un usuario (solo para administradores).

- `PUT /api/administrador/usuarios/modificar/`: Modifica los datos de un usuario (a implementar).

- `PUT /api/administrador/rendirse/`: Permite a un usuario rendirse en una partida de Buscaminas.

- `PUT /api/jugar/`: Permite a un usuario jugar una casilla en una partida de Buscaminas.

- `DELETE /api/administrador/usuarios/eliminar/{id}`: Elimina un usuario por su ID (solo para administradores).