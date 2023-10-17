# API de Gestión de Usuarios y Juego Buscaminas

Este es un archivo README para el código PHP que implementa una API de gestión de usuarios y funcionalidad del juego Buscaminas. A continuación, se proporciona una descripción general de las rutas y funcionalidades implementadas en este código.

## Introducción

Este código PHP implementa una API que permite realizar las siguientes acciones:

- Iniciar sesión como administrador o usuario.
- Listar usuarios (solo para administradores).
- Obtener el ranking de partidas ganadas por usuarios (solo para administradores y usuarios).
- Generar tableros de juego Buscaminas.
- Realizar diversas operaciones de gestión de usuarios (alta, baja, activar/desactivar, cambiar contraseña, eliminar, etc.).
- Rendirse en una partida de Buscaminas.
- Jugar una casilla en una partida de Buscaminas.

## Rutas y Funcionalidades

A continuación se describen las rutas y funcionalidades disponibles en este código:

- `GET /api/administrador/usuarios/listar/`: Lista todos los usuarios (solo para administradores).

- `GET /api/usuario/ranking/`: Obtiene el ranking de partidas ganadas por usuarios (disponible para administradores y usuarios).

- `GET /api/usuario/generar/tablero/{ancho}/{alto}/{minas}`: Genera un tablero de juego Buscaminas con las dimensiones especificadas.

- `POST /api/login`: Inicia sesión como administrador o usuario.

  ![LoginAdministrador](.\images\LoginAdministrador.png)

- `POST /api/administrador/usuarios/insertar/`: Inserta un nuevo usuario (solo para administradores).

- `PUT /api/administrador/usuarios/alta/`: Activa un usuario (solo para administradores).

- `PUT /api/administrador/usuarios/baja/`: Desactiva un usuario (solo para administradores).

- `PUT /api/administrador/usuarios/activo/`: Activa un usuario (solo para administradores).

- `PUT /api/administrador/usuarios/desactivo/`: Desactiva un usuario (solo para administradores).

- `PUT /api/administrador/usuarios/cambiarcontrasena/`: Cambia la contraseña de un usuario (solo para administradores).

- `PUT /api/administrador/usuarios/modificar/`: Modifica los datos de un usuario (a implementar).

- `PUT /api/administrador/rendirse/`: Permite a un usuario rendirse en una partida de Buscaminas.

- `PUT /api/jugar/`: Permite a un usuario jugar una casilla en una partida de Buscaminas.

- `DELETE /api/administrador/usuarios/eliminar/{id}`: Elimina un usuario por su ID (solo para administradores).

## Uso

Para utilizar esta API, se deben realizar solicitudes HTTP a las rutas correspondientes utilizando el método HTTP adecuado (GET, POST, PUT, DELETE). Las solicitudes deben incluir los datos necesarios en el cuerpo de la solicitud, en formato JSON.

## Requisitos

Para utilizar esta API, se deben cumplir ciertos requisitos, como la autenticación y los permisos adecuados. Asegúrese de que su sistema cumple con estos requisitos antes de utilizar la API.

## Contribuciones

Este proyecto es de código abierto, y las contribuciones son bienvenidas. Si desea contribuir o informar sobre problemas, hágalo a través de las solicitudes de extracción (pull requests) en GitHub.

## Licencia

Este proyecto se distribuye bajo la Licencia MIT. Consulte el archivo LICENSE para obtener más información.

---

Este README es una descripción general del código PHP proporcionado. Asegúrese de que la documentación esté actualizada y sea completa antes de desplegar este código en un entorno de producción.
