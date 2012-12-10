RecordApp
=========

Bienvenidos a RecordApp - Una aplicación desarrollada en Symfony2 que me 
ermite gestionar todas las Tareas y los Enlaces que ejecutamos a diario en 
nuestra actividad.

En este documento se encuentra los pasos para poder instalar correctamente 
RecodApp en un entorno local ya sea en un entorno de Desarrollo o de 
Producción.

1) Instalación de RecordApp
---------------------------

Antes de comenzar con el proceso de instalación es necesario mencionar los 
requerimientos del sistema, basta con tener instalado un entorno LAMP (Linux 
Apache MySQL PHP) para proceder a la instalación.

### Descargar la Aplicación

El Código fuente de RecordApp se encuentra en los repositorios públicos de 
GitHub es por ello que para descargar solo bastará con hacer un clon de este
repositorio en su servidor local.

    git clone https://github.com/elcodigok/recordapp.git recordapp

Dentro del directorio generado ejecutamos:

    php composer.phar install

2) Configuración de la Base de Datos
-------------------------------------

Para utilizar RecordApp es necesario contar con una Base de Datos en MySQL 
junto a las credenciales de un usuario válido.

Para ello necesitamos copiar el contenido del archivo parameters.yml.dis de la
siguiente manera:

    cp app/config/parameters.yml.dis app/config/parameters.yml

De esta forma solo queda modificar el archivo parameters.yml con los datos de 
nuestra bases de datos y generar el esquema de base de datos de la siguiente 
forma:

    php app/console doctrine:schema:create

3) Permiso en los Directorios
-----------------------------

Antes de corroborar y comenzar a utilizar RecordApp es necesario asignarle 
algunos permisos especiales a dos directorios:

    chown www-data:www-data app/cache/ -R
    chown www-data:www-data app/logs/ -R
    chmod 777 app/cache/ -R
    chmod 777 app/logs/ -R

4) Configuraciones Finales
--------------------------

Finalmente solo nos queda ejecutar los siguientes comandos de Symfony2 para 
terminar de cargar los datos inicial y crear algunos enlaces simbólicos que 
necesita el sistema.

    php app/console assets:install web/
    php app/console doctrine:fixtures:load --append

Ahora solo queda entrar desde un navegador web a http://<ip servidor>/recordapp/web/app.php


5) Usuarios por defecto
-----------------------

### Credenciales para el usuario Administrador

 * admin@admin.com / admin

### Credenciales para el usuario con menos privilegios

 * usuario@usuario.com / usuario