# Change.org monolítico · Despliegue con Docker

Réplica de Change.org hecha con **Laravel 12** como aplicación monolítica (módulo DWES): vistas Blade, autenticación con Laravel Breeze y estilos compilados con Vite. Desplegada con **Docker** y **Docker Compose** para el módulo de Despliegue de Aplicaciones Web (2º DAW).

El despliegue no necesita tener instalado PHP, Composer, Node.js ni MySQL en el equipo: todo se ejecuta en contenedores.

## Requisitos

- Docker Desktop (o Docker Engine con Docker Compose)
- El puerto **8001** libre en el equipo

## Arquitectura

| Servicio | Imagen | Función | Puerto |
|---|---|---|---|
| `app` | `mk1379/change-monolitico:v2` (construida desde `node:26-alpine` y `php:8.3-apache`) | Apache + PHP 8.3 + Laravel | `8001` → `80` |
| `db` | `mysql:8.4` | Base de datos MySQL | Solo red interna |

- La imagen se construye en **dos etapas** (*multi-stage*). En la primera, Node 26 instala las dependencias (`npm ci`) y compila el CSS y el JavaScript (`npm run build`). En la segunda, la imagen de PHP y Apache copia solo la carpeta `public/build` ya compilada. La imagen final no lleva Node ni `node_modules`.
- La aplicación se conecta a la base de datos con el nombre del servicio (`DB_HOST=db`).
- Los datos de MySQL se guardan en el volumen `datos-change-mono` y las fotos subidas de las peticiones en el volumen `fotos-peticiones` (montado en `public/peticiones`). Así no se pierden al borrar o reconstruir los contenedores.
- `db` tiene un *healthcheck*, y `app` no arranca hasta que MySQL está lista.

## Ficheros del despliegue

| Fichero | Para qué sirve |
|---|---|
| `Dockerfile` | Construye la imagen en dos etapas: compilación de los recursos con Node y aplicación con PHP 8.3 + Apache, `pdo_mysql`, `mod_rewrite`, la carpeta `public` como raíz y dependencias de Composer sin las de desarrollo, límite de subida de 5 MB por foto y la carpeta `public/peticiones` con permisos para Apache |
| `compose.yaml` | Define los servicios `app` y `db`, el puerto, los volúmenes y el healthcheck |
| `.dockerignore` | Deja fuera de la imagen `vendor`, `node_modules`, `public/build`, los `.env`, las fotos subidas en local y la caché generada en Windows |
| `.env.example` | Plantilla de configuración, sin contraseñas reales |

## Instalación

1. Entra en la carpeta del proyecto y crea el `.env` a partir de la plantilla:

   ```bash
   cp .env.example .env
   ```

   En Windows (PowerShell): `copy .env.example .env`

2. Abre el `.env` y pon tus contraseñas:

   ```env
   DB_DATABASE=change_monolitico_mario
   DB_USERNAME=mario
   DB_PASSWORD=pon_una_password
   DB_ROOT_PASSWORD=pon_otra_password
   ```

   `DB_USERNAME` no puede ser `root`: la imagen de MySQL crea ese usuario aparte. Estos mismos valores los usan Laravel y el contenedor de MySQL.

3. Construye la imagen (tarda un poco más que la de la API porque también compila los estilos):

   ```bash
   docker compose build
   ```

4. Genera la clave de la aplicación y pégala en `APP_KEY=` del `.env`:

   ```bash
   docker compose run --rm app php artisan key:generate --show
   ```

5. Levanta los servicios y comprueba que `db` aparece como `healthy`:

   ```bash
   docker compose up -d
   docker compose ps
   ```

6. Crea las tablas y carga los datos de prueba (usuarios, categorías y peticiones con fotos y firmas):

   ```bash
   docker compose exec app php artisan migrate --seed
   ```

   Si el volumen ya tenía tablas de una versión anterior, usa `migrate:fresh --seed` (borra los datos y empieza de cero).

La aplicación queda disponible en **http://localhost:8001**.

## Uso

| URL | Página |
|---|---|
| `/` | Portada con los temas |
| `/register` y `/login` | Registro e inicio de sesión (Laravel Breeze) |
| `/peticiones/index` | Listado de peticiones aceptadas |
| `/categorias/{id}/peticiones` | Peticiones de una categoría |
| `/peticiones/{id}` | Detalle de una petición (firmar, editar y borrar) |
| `/peticion/add` | Crear una petición con fotos (requiere sesión) |
| `/mispeticiones` | Mis peticiones (requiere sesión) |
| `/peticionesfirmadas` | Mis firmas (requiere sesión) |

Usuarios de prueba creados por los seeders (contraseña `password`):

| Usuario | Email |
|---|---|
| Mario | `mario@test.com` |
| Ana | `ana@test.com` |

Las peticiones nuevas se crean como **pendientes** y no aparecen en el listado público hasta que se cambia su `estado` a `aceptada` en la base de datos.

## Comandos útiles

| Comando | Qué hace |
|---|---|
| `docker compose ps` | Muestra el estado de los contenedores |
| `docker compose logs app` | Muestra el log de la aplicación (añade `-f` para seguirlo en directo) |
| `docker compose exec app bash` | Abre una terminal dentro del contenedor de la aplicación |
| `docker compose down` | Para y borra los contenedores. **Los datos se conservan** en el volumen |
| `docker compose down -v` | Borra también el volumen: **se pierden los datos** |
| `docker compose up -d --build` | Reconstruye la imagen y vuelve a levantar los servicios tras cambiar el código o los estilos |

## Problemas frecuentes

| Error | Causa | Solución |
|---|---|---|
| `port is already allocated` | El puerto 8001 lo usa otro programa o contenedor | Para ese programa o cambia el puerto en `compose.yaml` |
| La web se ve sin estilos | No se ha copiado `public/build` | Vuelve a construir la imagen con `docker compose build` y revisa el log de la etapa `assets` |
| `Connection refused` al migrar | MySQL aún no está lista | Espera a que `db` salga como `healthy` en `docker compose ps` |
| MySQL no arranca y el log habla de ficheros de datos incompatibles | El volumen tiene datos de otra base de datos (por ejemplo, de MariaDB) | `docker compose down -v` y vuelve a empezar (se borran los datos) |
| Al subir fotos sale "failed to upload" | La foto pasa de 5 MB | Usa fotos más pequeñas |
| Error al guardar una petición con fotos (permiso denegado) | La imagen es antigua y `public/peticiones` no es de `www-data` | `docker compose down`, `docker volume rm` del volumen de fotos y `docker compose up -d --build` |

## Autor

**Mario Díaz González** · 2º DAW · CSC Jesuitas Logroño
[GitHub](https://github.com/MK-1379) · [Portfolio](https://mk-1379.github.io)
