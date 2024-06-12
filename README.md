# AppLibrary Backend

Backend para la aplicación de Libreta de Direcciones desarrollada con Laravel.

## Requisitos

- PHP >= 8.0
- Composer
- MySQL

## Instalación

Sigue estos pasos para configurar y ejecutar el backend del proyecto:

### 1. Clonar el Repositorio

Clona el repositorio a tu máquina local usando el siguiente comando:
 
git clone https://github.com/tu_usuario/AppLibrary.git


### 2. Navegar al Directorio del Proyecto
Ve al directorio del proyecto:

cd AppLibrary/backend

### 3. Instalar Dependencias
Instala las dependencias del proyecto utilizando Composer:

composer install

### 4. Configurar el Archivo .env
Copia el archivo .env.example y renómbralo a .env:

cp .env.example .env

Genera la clave de la aplicación:

php artisan key:generate


Configura las variables de entorno en el archivo .env para tu base de datos y otros servicios:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_base_de_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña


### 5. Migrar la Base de Datos
Ejecuta las migraciones de la base de datos:

php artisan migrate


### 6. Poblar la Base de Datos
Ejecuta el seeder para poblar la base de datos con información ficticia:

php artisan db:seed --class=ContactsTableSeeder

### 7. Ejecutar el Servidor de Desarrollo
Inicia el servidor de desarrollo de Laravel:

php artisan serve


La aplicación debería estar disponible en http://localhost:8000.



