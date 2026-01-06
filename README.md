# Veterinaria API

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Acerca del Proyecto

Esta es una API RESTful desarrollada con Laravel para la gestión de una veterinaria municipal. Permite administrar dueños de mascotas, mascotas, historiales veterinarios, y generar carnets en formato PDF. Incluye autenticación JWT, control de permisos con Spatie Permission, y documentación automática de la API con Scramble.

### Características Principales

-   **Autenticación y Autorización**: Usa JWT para autenticación y Spatie Permission para roles y permisos.
-   **Gestión de Mascotas**: CRUD completo para mascotas, incluyendo generación automática de DNI único por año.
-   **Gestión de Dueños**: Administración de propietarios de mascotas.
-   **Historiales Veterinarios**: Registro de consultas y tratamientos.
-   **Generación de PDFs**: Carnets veterinarios con DomPDF y códigos QR.
-   **Documentación de API**: Generada automáticamente con Scramble.
-   **Validación**: Form Requests para validación robusta.
-   **Base de Datos**: Migraciones y seeders para roles y permisos.

## Requisitos

-   PHP 8.3.27
-   Composer
-   Node.js y npm (para Vite)
-   Base de datos (MySQL, PostgreSQL, etc.)

## Instalación

1. Clona el repositorio:

    ```bash
    git clone <url-del-repositorio>
    cd veterinaria-api
    ```

2. Instala las dependencias de PHP:

    ```bash
    composer install
    ```

3. Instala las dependencias de Node.js:

    ```bash
    npm install
    ```

4. Copia el archivo de configuración de entorno:

    ```bash
    cp .env.example .env
    ```

5. Configura tu base de datos en `.env`:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=veterinaria_api
    DB_USERNAME=tu_usuario
    DB_PASSWORD=tu_password
    ```

6. Genera la clave de la aplicación:

    ```bash
    php artisan key:generate
    ```

7. Ejecuta las migraciones y seeders:

    ```bash
    php artisan migrate
    php artisan db:seed --class=RolesAndPermissionsSeeder
    ```

8. Construye los assets:

    ```bash
    npm run build
    ```

9. Inicia el servidor:
    ```bash
    php artisan serve
    ```

## Uso

### Endpoints de API

La API está documentada automáticamente en `/docs/api` gracias a Scramble. Los endpoints principales incluyen:

-   **Autenticación**: `POST /api/auth/register`, `POST /api/auth/login`, etc.
-   **Dueños**: `GET /api/duenos`, `POST /api/duenos`, etc. (ver [`routes/api.php`](routes/api.php))
-   **Mascotas**: `GET /api/mascotas`, `POST /api/mascotas`, etc. (ver [`routes/api.php`](routes/api.php))
-   **Historiales**: `GET /api/historiales`, etc. (ver [`routes/api.php`](routes/api.php))
-   **Carnet PDF**: `GET /api/mascotas/{id}/carnet` (ver [`routes/api.php`](routes/api.php))

### Modelos Principales

-   [`User`](app/Models/User.php): Usuario con roles.
-   [`Mascota`](app/Models/Mascota.php): Mascota con DNI automático.
-   [`Dueno`](app/Models/Dueno.php): Propietario.
-   [`HistorialVeterinario`](app/Models/HistorialVeterinario.php): Historial médico.

### Pruebas

Ejecuta las pruebas con PHPUnit:

```bash
php artisan test
```

### Formateo de Código

Usa Laravel Pint para formatear el código:

```bash
vendor/bin/pint
```

## Contribución

Gracias por considerar contribuir a este proyecto. Sigue las guías de contribución de Laravel en [Laravel Documentation](https://laravel.com/docs/contributions).

## Código de Conducta

Revisa y respeta el [Código de Conducta](https://laravel.com/docs/contributions#code-of-conduct) para asegurar una comunidad acogedora.

## Vulnerabilidades de Seguridad

Si descubres una vulnerabilidad de seguridad, envía un email a Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). Todas las vulnerabilidades serán abordadas prontamente.

## Licencia

Este proyecto está bajo la licencia MIT. Ver [MIT License](https://opensource.org/licenses/MIT) para más detalles.
