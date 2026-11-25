# Change.org monolítico · Despliegue con Docker

Réplica de Change.org hecha con **Laravel 12** como aplicación monolítica (módulo DWES): vistas Blade, autenticación con Laravel Breeze y estilos compilados con Vite. Desplegada con **Docker** y **Docker Compose** para el módulo de Despliegue de Aplicaciones Web (2º DAW).

El despliegue no necesita tener instalado PHP, Composer, Node.js ni MySQL en el equipo: todo se ejecuta en contenedores.

## Requisitos

- Docker Desktop (o Docker Engine con Docker Compose)
- El puerto **8001** libre en el equipo

## Arquitectura

| Servicio | Imagen | Función | Puerto |
|---|---|---|---|
| `app` | `mk1379/change-monolitico:v1` (construida desde `node:26-alpine` y `php:8.3-apache`) | Apache + PHP 8.3 + Laravel | `8001` → `80` |
| `db` | `mysql:8.4` | Base de datos MySQL | Solo red interna |

- La imagen se construye en **dos etapas** (*multi-stage*). En la primera, Node 26 instala las dependencias (`npm ci`) y compila el CSS y el JavaScript (`npm run build`). En la segunda, la imagen de PHP y Apache copia solo la carpeta `public/build` ya compilada. La imagen final no lleva Node ni `node_modules`.
- La aplicación se conecta a la base de datos con el nombre del servicio (`DB_HOST=db`).
- Los datos de MySQL se guardan en el volumen `datos-change-mono`, así que no se pierden al borrar los contenedores.
- `db` tiene un *healthcheck*, y `app` no arranca hasta que MySQL está lista.

## Ficheros del despliegue

| Fichero | Para qué sirve |
|---|---|
| `Dockerfile` | Construye la imagen en dos etapas: compilación de los recursos con Node y aplicación con PHP 8.3 + Apache, `pdo_mysql`, `mod_rewrite`, la carpeta `public` como raíz y dependencias de Composer sin las de desarrollo |
| `compose.yaml` | Define los servicios `app` y `db`, el puerto, el volumen y el healthcheck |
| `.dockerignore` | Deja fuera de la imagen `vendor`, `node_modules`, `public/build`, los `.env` y la caché generada en Windows |
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

6. Crea las tablas:

   ```bash
   docker compose exec app php artisan migrate
   ```

La aplicación queda disponible en **http://localhost:8001**.

## Uso

| URL | Página |
|---|---|
| `/` | Portada |
| `/register` y `/login` | Registro e inicio de sesión (Laravel Breeze) |
| `/dashboard` | Panel del usuario |
| `/peticiones/index` | Listado de peticiones |
| `/peticiones/{id}` | Detalle de una petición |

La aplicación todavía no permite crear peticiones desde la web (crear, firmar y "Mis peticiones" están pendientes en DWES). Para tener datos de prueba, registra primero un usuario en `/register` y después crea una categoría y una petición con la consola de Laravel:

```bash
docker compose exec app php artisan tinker
```

```php
App\Models\Categoria::create(['nombre' => 'Medio ambiente']);
$p = new App\Models\Peticione(['titulo' => 'Más carriles bici', 'descripcion' => 'Queremos más carriles bici en Logroño', 'destinatario' => 'Ayuntamiento de Logroño', 'firmantes' => 0, 'estado' => 'pendiente']);
$p->user_id = 1;
$p->categoria_id = 1;
$p->save();
exit
```

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
| Error 500 en "Mis peticiones", "Crear petición" o "Firmar" | Esos métodos aún no existen en `PeticioneController` | Pendiente de programar en DWES; no es un fallo del despliegue |
| `db:seed` falla | Faker es una dependencia de desarrollo y la imagen se instala con `--no-dev` | Crea los datos de prueba desde la web y con tinker |

## Autor

**Mario Díaz González** · 2º DAW · CSC Jesuitas Logroño
[GitHub](https://github.com/MK-1379) · [Portfolio](https://mk-1379.github.io)
