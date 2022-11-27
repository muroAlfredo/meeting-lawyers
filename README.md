WORK ENTRY APP
================================================================

Desarrollo de una API REST la cual permite la gestión de usuarios y
de sus respectivos fichajes de trabajo.


Requisitos previos: Arranque local con docker
===============

Para el desarrollo en local vamos a construirla sobre contenedores de Docker 
y hacer que se ejecute de forma aislada del sistema operativo.

Los contenedores de Docker serán los siguientes:

<!-- TOC -->
* PHP
* NGINX
* MySQL
<!-- TOC -->

Por lo tanto, para una ejecución correcta de la construcción inicial de proyecto necesitamos lo siguiente:

- Tener la última version de [docker-ce](https://docs.docker.com/engine/install/)
- Tener la última version de [docker-compose](https://docs.docker.com/compose/install/)

Una vez instalado podemos verificar la instalación mediante los siguientes comandos:

```shell
docker -v
docker-compose -v
```

- Debemos contar con los puertos **33060** (para MySQL), **9000** (para PHP) y **8001** (para NGINX) disponibles en nuestra máquina. 
Si tenéis servicios escuchando en estos puertos, deben pararse.


Para construir y levantar nuestros contenedores lo hacemos desde docker-compose.yml que tenemos en la raíz del proyecto.
Lanzaremos el siguiente comando:

```shell
docker-compose up -d --build
```

Para acceder a los contenedores podemos utilizar uno de los comandos siguientes:

```shell
# para acceder al contenedor de base de datos
docker exec -it database_work_entry bash

# para acceder al contenedor de nginx
docker exec -it nginx_work_entry sh

# para acceder al contenedor de php
docker exec -it php_work_entry bash
```

Para nuestra aplicación se utiliza el framework de Symfony concretamente en su versión 5.4

Una vez arrancado los contenedores podemos acceder a la api doc de la aplicación a través 
de la url http://localhost:8081/api/doc

Tendremos disponibles todos los endpoints para realizar las pruebas de nuestra api rest.


Configuración inicial de la aplicación
=================

Tenemos un fichero de configuración en la raíz del proyecto .env dónde está configurada la conexión
a base de datos

```shell
DATABASE_URL="mysql://user:password@database_work_entry:3306/work_entry?serverVersion=8&charset=utf8mb4"
```

Lanzaremos las migraciones para construir nuestro modelo de datos con el siguiente comando desde
dentro del contenedor de php

```shell
php bin/console doctrine:migrations:migrate
```

#### Test

Para ejecutar los test podemos usar el siguiente comando o desde dentro del propio contenedor

```
docker exec -it  php_work_entry bin/phpunit 
```


### Comandos adicionales

Limpieza de caché:
```
docker exec -it php_work_entry bin/console cache:clear
```

Instalar dependencias de composer:
```
docker exec -it php_work_entry composer install
```

He realizado algunos comandos para lanzarlos desde en composer para hacer más sencillo su uso.
Los puedes ver dentro del archivo de la raíz del proyecto composer.json



