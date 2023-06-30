# API de Galería de Fotos

Este proyecto es una API para administrar imágenes y colecciones en una Galería de Fotos. Utiliza el framework Laravel y Docker con Laravel Sail para facilitar la instalación y ejecución del proyecto.

## Requisitos

Antes de comenzar, asegúrate de tener los siguientes requisitos instalados en tu sistema:

- [Docker](https://www.docker.com/get-started)

#!/bin/bash

# Clonar el repositorio
git clone https://github.com/tu-usuario/galeria-fotos.git

# Copiar el archivo de entorno
cp .env.example .env

# Agregar un alias para Laravel Sail
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

# Instalar las dependencias de Composer
sail composer install

# Iniciar Laravel Sail
sail up -d

# Ejecutar migraciones
sail artisan migrate

# Ejecutar seeders
sail artisan db:seed

# Ajustar el cronjob
echo "* * * * * sail artisan schedule:run >> /dev/null 2>&1" | crontab -

# El cronjob se ejecutará cada minuto para ejecutar las tareas programadas de Laravel.
# En este caso, se utiliza para limpiar la tabla de registros de actividad y eliminar de forma definitiva las colecciones e imágenes que hayan estado en la papelera durante un mes.
# Las tareas programadas de Laravel están configuradas en el archivo `app/Console/Kernel.php`.

# Mostrar instrucciones finales
echo "¡La API de Galería de Fotos se ha instalado correctamente!"
echo "Puedes acceder a la API a través de los siguientes endpoints:"
echo ""
echo "Descripción de la API:"
echo "La API de Galería de Fotos te permite gestionar imágenes y colecciones de fotos. Los usuarios pueden registrarse, iniciar sesión, subir imágenes, crear y modificar colecciones, y más."
echo ""
echo "Endpoints:"
echo "- Autenticación:"
echo "  - POST /register: Registra un nuevo usuario."
echo "  - POST /login: Inicia sesión y devuelve un token de acceso."
echo "  - POST /forgot-password: Solicita un correo electrónico para restablecer la contraseña."
echo "  - POST /reset-password: Restablece la contraseña del usuario."
echo "- Imágenes:"
echo "  - POST /create-image: Guarda una nueva imagen."
echo "  - GET /images: Obtiene el listado de todas las imágenes."
echo "  - GET /image/{id}: Obtiene los detalles de una imagen específica."
echo "  - PATCH /edit-image/{id}: Actualiza los detalles de una imagen existente."
echo "  - DELETE /delete-image/{id}: Elimina una imagen existente."
echo "- Colección (de imágenes):"
echo "  - POST /create-collection: Crea una nueva colección de imágenes."
echo "  - GET /collections: Obtiene el listado de todas las colecciones de imágenes."
echo "  - GET /collection/{id}: Obtiene los detalles de una colección de imágenes específica."
echo "  - PATCH /edit-collection/{id}: Actualiza los detalles de una colección de imágenes existente."
echo "  - DELETE /delete-collection/{id}: Elimina una colección de imágenes existente."
echo ""

# Ejecutar pruebas de integración
sail test
