Ejemplo DDD + CQRS + EventSourcing
===================

Instalación del Proyecto
===================

### Clonar Proyecto

```sh
$ git clone https://github.com/vallsjm/blog.git
```

### Instalar las dependencias de PHP via Composer

```sh
$ docker-compose up -d php-fpm
$ docker-compose run --rm php-fpm php composer.phar install -o --prefer-dist --no-interaction
```

### Levantar todos los contenedores Docker

```sh
$ docker-compose build
$ docker-compose up -d --force-recreate
```

### Crear el event strem inicial

```sh
docker-compose run --rm php-fpm php bin/console event-store:event-stream:create
```
### Ya disponible

```sh
http://localhost
```
Comentarios
===================

El ejercicio pretende ser un pequeño ejemplo de una API con dos simples tablas, Post y Author donde cada Post pertenece a un Author.

Se ha utilizando una arquitectura DDD + CQRS + EventSourcing, para poder realizar el ejercicio hemos aprovechado algunos recursos del framework Symfony y los componentes PROOPH

Es importante decir que no se ha utilizado ODM o ORM de forma intencionada con el propósito de optimizar la consulta en la capa de lectura. Del mismo modo y por la misma razón, tampoco se usa el sistema de Controladores de Symfony ni los Bundles de API que facilitan mucho el trabajo como RESTBundle.

Para facilitar la comprensión de la funcionalidad he añadido las llamadas Curl para cada uno de los endpoints, de todos modos se puede acceder directamente con Postman, Swagger o cualquier cliente REST.

Se ha creado un contenedor con el phpmyadmin para poder acceder de forma sencilla a la base de datos.

Links
===================

- [Libreria Prooph](http://getprooph.org/)
- [Ejemplo original útilizado](https://github.com/prooph/proophessor-do-symfony)

Formato Endpoints
===================

Los endpoints creados permiten trabajar tanto con JSON como con XML. Para definir el formato deseado se hace mediante la técnica HTTP header negotiation.

De este modo la cabecera Content-Type se usa para definir el formato de recepción de datos y Accept para establecer el formato de salida.

```sh
Content-Type application/json
Accept application/xml
```

Listado Endpoints
===================

### POST Author

Primero creamos un author mediante la llamada POST

```sh
curl --location --request POST 'http://localhost/api/author' \
--header 'Content-Type: application/json' \
--header 'Accept: application/xml' \
--data-raw '{"name":"Jose María","surname":"Rodríguez"}'
```

Lo cual retorna la respuesta

```xml
<?xml version="1.0"?>
<response>
    <name>Jose Mar&#xED;a</name>
    <surname>Rodr&#xED;guez</surname>
    <id>fe749042-f744-411c-80cc-5c7bbfb4d02a</id>
</response>
```

### GET Author

Si quememos obtener los datos del author recientemente creado

```sh
curl --location --request GET 'http://localhost/api/author/fe749042-f744-411c-80cc-5c7bbfb4d02a' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
```
Lo cual retorna la respuesta

```json
{
    "id": "fe749042-f744-411c-80cc-5c7bbfb4d02a",
    "name": "Jose María",
    "surname": "Rodríguez"
}
```

### POST Post

Ahora añadimos un Post al Author creado anteriormente.

```sh
curl --location --request POST 'http://localhost/api/post' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--data-raw '{"author_id": "fe749042-f744-411c-80cc-5c7bbfb4d02a", "title":"titulo del post","description":"descripción corta","content":"contenido"}'
```

Lo cual retorna la respuesta

```json
{
    "author_id": "fe749042-f744-411c-80cc-5c7bbfb4d02a",
    "title": "titulo del post",
    "description": "descripción corta",
    "content": "contenido",
    "id": "9c063f99-83ec-4039-a1b9-0c24a4774a84"
}
```

### GET Post

Obtener información del Post con la información adicional del author usando el parámetro info.

```sh
curl --location --request GET 'http://localhost/api/post/9c063f99-83ec-4039-a1b9-0c24a4774a84?info=extended'
```

Lo cual retorna la respuesta

```json
{
    "id": "9c063f99-83ec-4039-a1b9-0c24a4774a84",
    "title": "titulo del post",
    "description": "descripción corta",
    "content": "contenido",
    "author": {
        "id": "fe749042-f744-411c-80cc-5c7bbfb4d02a",
        "name": "Jose María",
        "surname": "Rodríguez"
    }
}
```

La misma llamada sin el parámetro opcional

```sh
curl --location --request GET 'http://localhost/api/post/9c063f99-83ec-4039-a1b9-0c24a4774a84'
```

Lo cual retorna la respuesta

```json
{
    "id": "9c063f99-83ec-4039-a1b9-0c24a4774a84",
    "author_id": "fe749042-f744-411c-80cc-5c7bbfb4d02a",
    "title": "titulo del post",
    "description": "descripción corta",
    "content": "contenido"
}
```

Pruebas
===================

Es cierto que no están muy trabajadas, no tanto como me abría gustado.


```sh
docker-compose run --rm php-fpm ./bin/phpunit
```
