**API de Fotografías**

El proyecto API de Galería de Fotos es una aplicación que proporciona una interfaz de programación de aplicaciones (API) para administrar imágenes y colecciones. Permite a los usuarios registrarse, iniciar sesión, cargar imágenes, crear y gestionar colecciones, y realizar diversas acciones relacionadas con ellas. La API se ha desarrollado utilizando el framework Laravel y sigue las convenciones RESTful para una estructura clara y fácil de usar.

**Instalación y Ejecución**

Para instalar y ejecutar el proyecto de Laravel Sail, se deben seguir los siguientes pasos en la terminal:

1. Asegurarse de tener instalado Docker y PHP 8.1 en el sistema.
1. Clonar el repositorio del proyecto con el siguiente comando: **git clone https://github.com/Majo97/API-GaleriaFotos.git**
1. Crear una copia del archivo **.env.example** y renombrarla como **.env**. En este archivo se deben configurar las variables de entorno, incluyendo la conexión a la base de datos MySQL.
1. Agregar un alias a Sail para facilitar su uso en la terminal: **alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'**
1. Instalar las dependencias de Composer con el siguiente comando: **sail composer install**
1. Iniciar Sail con el siguiente comando: **sail up -d**
1. Ejecutar las migraciones de la base de datos con el siguiente comando: **sail artisan migrate**
1. Ejecutar los seeders de la base de datos con el siguiente comando: **sail artisan db:seed**
1. Ejecutar el comando para generar la clave del proyecto: **sail artisan key:generate**
1. Configurar el cronjob en la consola crontab para que se ejecute el script que elimina los registros de la tabla activity log, las fotos que tienen un mes de eliminadas (soft delete) y las colecciones que tienen un mes de eliminadas (soft delete).
1. Las pruebas de integración se pueden ejecutar con el siguiente comando: **sail artisan test**

**Endpoints**

El proyecto cuenta con los siguientes endpoints:

**Rutas de Autenticación**

- **POST /register**: Permite a los usuarios registrarse en la aplicación.
- **POST /login**: Permite a los usuarios iniciar sesión en la aplicación.
- **POST /forgot-password**: Permite a los usuarios solicitar un correo electrónico para restablecer su contraseña en caso de olvido.
- **POST /reset-password**: Permite a los usuarios restablecer su contraseña utilizando el enlace enviado por correo electrónico.

**Rutas Protegidas (Requieren Autenticación)**

- **POST /logout**: Permite a los usuarios cerrar sesión en la aplicación.
- **POST /add-collection**: Permite a los usuarios crear una nueva colección.
- **PATCH /edit-collection/{id}**: Permite al propietario de la colección actualizar una colección existente.
- **DELETE /delete-collection/{id}**: Permite al propietario de la colección eliminar una colección existente.
- **GET /my-collections**: Obtiene todas las colecciones pertenecientes al usuario autenticado, incluyendo las públicas y privadas.
- **GET /collections**: Obtiene todas las colecciones disponibles en la aplicación, incluyendo las públicas de otros usuarios.
- **GET /collection/{id}**: Obtiene los detalles de una colección específica mediante su ID, incluyendo las imágenes asociadas.
- **POST /create-image**: Permite a los usuarios crear una nueva imagen.
- **PATCH /edit-image/{id}**: Permite al propietario de la imagen actualizar el título, descripción o tipo de una imagen existente.
- **DELETE /delete-image/{id}**: Permite al propietario de la imagen eliminar una imagen existente.
- **POST /asociate-images/{id}**: Permite agregar imágenes a una colección existente.
- **DELETE /disassociate-images/{id}**: Permite eliminar imágenes de una colección existente.

Para leer la documentación completa de los endpoints, se puede consultar el siguiente enlace: <https://documenter.getpostman.com/view/26976998/2s93z9ci6v>.
