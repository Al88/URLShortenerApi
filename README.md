
# URL Shortener API Service

Este es un API para el  acortamiento de URL utilizando Laravel. Este servicio genera códigos cortos únicos para URLs y permite obtener la URL original a partir del código corto.

## Requisitos

Antes de comenzar, asegúrate de tener las siguientes herramientas instaladas:

- **PHP** 8.3 o superior
- **Composer** para gestionar dependencias PHP
- **SQLite** o MySQL (dependiendo de tu configuración)
- **Node.js** y **npm** para la construcción del front-end (si es necesario)

## Instalación

### 1. Clonar el repositorio

Clona el repositorio a tu máquina local:

```bash
git clone https://github.com/Al88/URLShortenerApi.git
cd url-shortener
```

### 2. Instalar dependencias

Instala las dependencias de PHP utilizando Composer:

```bash
composer install
```

Luego, instala las dependencias de JavaScript (si es necesario para tu aplicación front-end):

```bash
npm install
```

### 3. Configuración del entorno

Copia el archivo `.env.example` a `.env`:

```bash
cp .env.example .env
```

Configura tu base de datos en el archivo `.env`:

- Para usar **SQLite** (recomendado para pruebas):

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

- Para usar **MySQL**:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shortener
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Crear la base de datos

Si usas SQLite, asegúrate de que el archivo `database/database.sqlite` exista:

```bash
touch database/database.sqlite
```

Si usas MySQL, asegúrate de crear la base de datos que configuraste en `.env`.

### 5. Ejecutar migraciones

Ejecuta las migraciones para crear las tablas necesarias en la base de datos:

```bash
php artisan migrate
```

### 6. Ejecutar el servidor

Puedes ejecutar el servidor de desarrollo de Laravel con el siguiente comando:

```bash
php artisan serve
```

Esto iniciará el servidor en `http://localhost:8000`.

## Pruebas

### 1. Ejecutar pruebas unitarias

Para ejecutar las pruebas unitarias en Laravel, puedes usar el siguiente comando:

```bash
php artisan test
```

Esto ejecutará todas las pruebas dentro de `tests/`.

### 2. Ejecutar pruebas con PHPUnit

Si prefieres usar PHPUnit directamente, puedes usar:

```bash
vendor/bin/phpunit
```

### 3. Pruebas en un entorno de desarrollo

Asegúrate de que la base de datos esté correctamente configurada y que el servidor esté en funcionamiento para ejecutar las pruebas de las APIs.

## Documentación Swagger

La documentación de la API se encuentra en Swagger. Para acceder a ella, simplemente navega a la siguiente URL en tu navegador:

```
http://localhost:8000/api/documentation
```

Aquí podrás ver los detalles de los endpoints disponibles, sus parámetros y ejemplos de respuestas.

## Endpoints

### 1. Crear una URL corta

**Método**: `POST`
**Endpoint**: `/api/url`
**Body**:

```json
{
    "original_url": "http://example.com"
}
```

**Respuesta**:

```json
{
    "url": "http://example.com",
    "short_code": "abc123"
}
```

### 2. Obtener la URL original por código corto

**Método**: `GET`
**Endpoint**: `/api/{shortCode}`

**Respuesta**:

```json
{
    "url": "http://example.com"
}
```

### 3. Eliminar una URL

**Método**: `DELETE`
**Endpoint**: `/api/url/{shortCode}`

**Respuesta**:

```json
{
    "message": "URL deleted successfully"
}
```

## Licencia

Este proyecto está bajo la Licencia MIT. Para más detalles, consulta el archivo [LICENSE](LICENSE).
