# Change.org · Réplica monolítica en Laravel

Réplica de [Change.org](https://www.change.org) hecha con **Laravel** como aplicación monolítica: el servidor genera las páginas con **Blade** y las sirve ya montadas al navegador. Incluye registro e inicio de sesión de usuarios, y un listado y detalle de peticiones que se leen de la base de datos.

Las vistas parten del diseño que hice con Bootstrap en el módulo de **Diseño de Interfaces Web (DIW)**, adaptado a Laravel.

> Práctica del módulo **Desarrollo Web en Entorno Servidor (DWES)** · 2º DAW · CSC Jesuitas Logroño

---

## Tecnologías

| Parte | Tecnología |
|---|---|
| Backend | Laravel 12 · PHP 8.2 |
| Base de datos | MySQL / MariaDB (XAMPP) |
| Vistas | Blade |
| Estilos de la web | Bootstrap 5.3 · Bootstrap Icons · CSS propio |
| Autenticación | Laravel Breeze (Blade + Tailwind) |

---

## Funcionalidades

**Usuarios**
- Registro de usuarios. Al registrarte, la aplicación te lleva al login con un mensaje para que inicies sesión con tus datos.
- Inicio y cierre de sesión.
- Dashboard y edición del perfil (de Breeze), en modo oscuro.

**Barra de navegación según la sesión**

| Sin sesión | Con sesión iniciada |
|---|---|
| Registrarse · Entrar | Mis peticiones · tu nombre (enlace al dashboard) · Logout |

**Peticiones**
- Listado de peticiones de la base de datos, con categoría, destinatario y número de firmas.
- Página de detalle de cada petición, con título, descripción, destinatario, categoría, creador y fecha.

---

## Base de datos

### Tablas

| Tabla | Contenido |
|---|---|
| `users` | Usuarios (de Laravel) |
| `categorias` | Categorías de las peticiones |
| `peticiones` | Peticiones: `titulo`, `descripcion`, `destinatario`, `firmantes`, `estado` (`aceptada` / `pendiente`), `user_id`, `categoria_id` |
| `peticione_user` | Tabla pivote de las firmas, con clave primaria compuesta (`user_id`, `peticione_id`) |
| `files` | Archivos de una petición (`name`, `file_path`, `peticione_id`) |

### Relaciones

| Relación | Tipo | En los modelos |
|---|---|---|
| Un usuario crea muchas peticiones | 1:N | `User::peticiones()` · `Peticione::user()` |
| Una categoría tiene muchas peticiones | 1:N | `Categoria::peticiones()` · `Peticione::categoria()` |
| Una petición tiene muchos archivos | 1:N | `Peticione::files()` · `File::peticione()` |
| Un usuario firma muchas peticiones y una petición tiene muchos firmantes | N:M | `User::firmas()` · `Peticione::firmas()` |

> El modelo se llama `Peticione` (y no `Peticion`) para que Laravel deduzca bien el nombre de la tabla: le añade una **s** al nombre del modelo y queda `peticiones`.

---

## Instalación

### Requisitos

- PHP 8.2 o superior
- Composer
- Node.js y npm
- MySQL o MariaDB (por ejemplo, con XAMPP)

### Pasos

1. Clona el repositorio y entra en la carpeta:
   ```bash
   git clone <url-del-repositorio>
   cd change_mario_monolitic
   ```

2. Instala las dependencias de PHP y de JavaScript:
   ```bash
   composer install
   npm install
   ```

3. Crea el archivo `.env` y genera la clave de la aplicación:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Crea una base de datos vacía en MySQL y pon sus datos en el `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=change_monolitico_mario
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. Crea las tablas:
   ```bash
   php artisan migrate
   ```

6. Compila los estilos de las vistas de Breeze (login, registro, dashboard):
   ```bash
   npm run build
   ```

7. Arranca el servidor:
   ```bash
   php artisan serve
   ```
   La aplicación queda en <http://127.0.0.1:8000>.

### Datos de prueba

La aplicación todavía no permite crear peticiones desde la web. Para ver algo en el listado, añade datos a mano en la base de datos, en este orden: **usuario → categoría → petición**.

```sql
INSERT INTO categorias (nombre, created_at, updated_at)
VALUES ('Educación', NOW(), NOW());

INSERT INTO peticiones (titulo, descripcion, destinatario, firmantes, estado, user_id, categoria_id, created_at, updated_at)
VALUES ('Más pediatras en los centros de salud rurales',
        'En muchos pueblos solo hay pediatra un día a la semana.',
        'Consejería de Salud de La Rioja', 0, 'pendiente', 1, 1, NOW(), NOW());
```

`user_id = 1` tiene que ser un usuario que exista. Créalo antes registrándote en la aplicación.

---

## Rutas

| Método | URL | Nombre | Qué hace | Estado |
|---|---|---|---|---|
| GET | `/` | `home` | Portada | ✔ |
| GET | `/peticiones/index` | `peticiones.index` | Listado de peticiones | ✔ |
| GET | `/peticiones/{id}` | `peticiones.show` | Detalle de una petición | ✔ |
| GET | `/peticion/add` | `peticiones.create` | Formulario para crear una petición | Pendiente |
| POST | `/peticion` | `peticiones.store` | Guardar una petición | Pendiente |
| POST | `/peticiones/firmar/{id}` | `peticiones.firmar` | Firmar una petición | Pendiente |
| GET | `/mispeticiones` | `peticiones.mine` | Peticiones del usuario | Pendiente |
| GET | `/peticionesfirmadas` | `peticiones.peticionesfirmadas` | Peticiones firmadas por el usuario | Pendiente |
| PUT | `/peticiones/{id}` | `peticiones.update` | Editar una petición | Pendiente |
| DELETE | `/peticiones/{id}` | `peticiones.delete` | Borrar una petición | Pendiente |
| GET | `/dashboard` | `dashboard` | Panel del usuario (Breeze) | ✔ |
| GET | `/login` · `/register` | `login` · `register` | Inicio de sesión y registro (Breeze) | ✔ |
| POST | `/logout` | `logout` | Cerrar sesión (Breeze) | ✔ |

Las rutas marcadas como **Pendiente** ya están definidas en `routes/web.php`, pero su método todavía no existe en `PeticioneController`. Se harán en las siguientes fases de la práctica.

---

## Estructura

```
app/
├── Http/Controllers/
│   ├── PagesController.php        Portada
│   ├── PeticioneController.php    index y show
│   ├── CategoriaController.php
│   ├── UserController.php
│   ├── FileController.php
│   └── Auth/                      Controladores de Breeze
└── Models/
    ├── User.php
    ├── Peticione.php
    ├── Categoria.php
    └── File.php

resources/views/
├── layouts/
│   ├── public.blade.php           Layout de la web: navbar y footer de DIW
│   ├── app.blade.php              Layout del dashboard (Breeze)
│   └── guest.blade.php            Layout del login y el registro (Breeze)
├── pages/home.blade.php           Portada
├── peticiones/
│   ├── index.blade.php            Listado
│   ├── show.blade.php             Detalle
│   └── create.blade.php           Formulario de crear (sin controlador todavía)
└── auth/                          Vistas de login, registro, etc. (Breeze)

public/
├── css/styles.css                 Estilos de la réplica (DIW)
├── css/estilos.css                Ajustes del layout
├── js/main.js
└── img/                           Imágenes de la web
```

---

## Autor

**Mario Díaz González** · [GitHub](https://github.com/MK-1379) · [Portfolio](https://mk-1379.github.io)
