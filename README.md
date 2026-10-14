# Arquitectura y Construcciones WE

Sitio web de **Arquitectura y Construcciones WE**: diseño, construcción e interventoría de obras en Medellín y Antioquia.
Está hecho en Laravel 13, con Blade y Vite.

## Puesta en marcha

Requiere PHP 8.3 o superior, Composer y Node.js.

```bash
composer install
copy .env.example .env        # en macOS/Linux: cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
composer run dev              # servidor + Vite en http://localhost:8000
```

En Windows, si `php artisan` falla por **PHP 8.2 (XAMPP)**, usa los scripts del repo:

```powershell
.\setup.ps1    # migrate + seed (panel admin)
.\dev.ps1      # servidor + Vite con PHP correcto
.\artisan.ps1 migrate   # cualquier comando artisan
```

No ejecutes solo `npm run dev` en otra terminal si ya corre `dev.ps1` (conflicto de puertos Vite). Si no levantas Vite, hace falta `npm run build` al menos una vez.

Pruebas: `php artisan test`

## Dónde está cada cosa

| Qué | Dónde |
|---|---|
| **Textos, contactos, FAQ** | `config/sitio.php` |
| **Servicios y proyectos (editable)** | Panel `/admin` o, si la BD está vacía, `config/sitio.php` |
| Layout (head, SEO, JSON-LD) | `resources/views/layouts/app.blade.php` |
| Secciones de la página | `resources/views/secciones/*.blade.php` |
| Menú, pie, botones flotantes, visor | `resources/views/partials/` |
| Íconos SVG | `resources/views/components/icono.blade.php` → `<x-icono nombre="whatsapp" />` |
| Estilos | `resources/css/app.css` (fuente Archivo en `resources/fonts/`) |
| Interacciones (menú, filtros, visor, formulario) | `resources/js/app.js` |
| Fotos | `public/images/` y `public/images/obras/` |

### Agregar una obra al portafolio

1. Copia la foto (ideal `.webp`, ~900 px de ancho) en `public/images/obras/`.
2. Agrega un elemento al arreglo `obras` de `config/sitio.php` con su categoría (`diseno`, `pead`, `redes`, `casas`, `altura` o `inter`), ancho y alto reales de la imagen.

Los contadores de los filtros se calculan solos.

## Formulario de contacto

`POST /solicitudes`, a cargo de `SolicitudController`:

- Valida con `SolicitudRequest`, con los mensajes en español.
- Guarda cada solicitud en la tabla `solicitudes` (modelo `Solicitud`).
- Envía el correo `SolicitudRecibida` a `SITIO_EMAIL`. Tiene botón para responder por WhatsApp y *reply-to* al cliente.
- Si el correo falla, la solicitud ya quedó guardada y el error queda en el log.
- Tiene un campo trampa contra bots y un límite de 5 envíos por minuto por IP.
- Funciona con JavaScript (envío por `fetch` con errores por campo) y sin él (envío normal del formulario).
- El botón **Enviar por WhatsApp** arma el mensaje en el navegador y abre el chat con la persona elegida.

Para que los correos se envíen de verdad, configura `MAIL_*` en `.env`. Las instrucciones para Gmail están en `.env.example`.

## Panel de administración

Panel ligero en **`/admin`** (sin Filament): editar **servicios** y **proyectos** del sitio. Si hay registros activos en la base de datos, la landing los usa en lugar de `config/sitio.php` para esas secciones.

```bash
php artisan migrate
php artisan db:seed    # crea admin + importa servicios/obras desde config/sitio.php
```

Credenciales por defecto (cámbialas en `.env` con `ADMIN_EMAIL` y `ADMIN_PASSWORD` antes del seed, o edita el usuario en la BD):

| Campo | Valor local |
|---|---|
| URL | http://127.0.0.1:8000/admin |
| Correo | `admin@we.local` |
| Contraseña | `WeAdmin2026!` |

En Windows, si `php artisan` falla por versión de PHP, usa el mismo PATH que `dev.ps1` (PHP 8.5 de Herd Lite).

## Producción

```bash
npm run build
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

Pon `APP_ENV=production`, `APP_DEBUG=false` y `APP_URL` con el dominio real; las etiquetas `og:` y `canonical` lo usan.

## Despliegue en VPS Hostinger

Guía paso a paso (SSH, Nginx, `.env`, SSL, panel `/admin`): **[deploy/HOSTINGER-VPS.md](deploy/HOSTINGER-VPS.md)**.

En el servidor, después de clonar y configurar `.env`:

```bash
chmod +x scripts/deploy.sh
./scripts/deploy.sh --first    # primera vez
./scripts/deploy.sh            # actualizaciones
```

## Despliegue en el servidor (pull)

Repositorio: [pipelink1205-coder/Arquitectura-we](https://github.com/pipelink1205-coder/Arquitectura-we)

Primera vez en el servidor (PHP ≥ 8.3, Composer, Node):

```bash
cd /var/www   # o la carpeta que uses
git clone https://github.com/pipelink1205-coder/Arquitectura-we.git arquitectura-we
cd arquitectura-we
cp .env.example .env
php artisan key:generate
touch database/database.sqlite   # si usas SQLite
php artisan migrate --force
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

Actualizar después de un `git push`:

```bash
cd /ruta/al/proyecto/arquitectura-we
git pull origin main
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
php artisan queue:restart   # si usas cola en producción
```

Configura el virtual host apuntando la raíz web a `public/`. No subas `.env` al repositorio; créalo solo en el servidor.

### HTML en un solo archivo (todo embebido)

Para enviar por correo, USB o hosting estático sin PHP:

```bash
npm run build
php scripts/exportar-html-embebido.php
```

Genera `public/exposicion-embebido.html` (~23 MB): estilos, scripts, fuente Archivo e imágenes en base64.

- **Menú, filtros y visor**: funcionan al abrir el archivo (el JS va al final del `<body>`).
- **WhatsApp**: abre el chat con el mensaje armado.
- **Enviar por correo** (archivo suelto): abre tu app de correo (`mailto:`) hacia `arquitecturayconstruccioneswe@gmail.com`; no envía solo desde el servidor.

Para que el formulario **envíe correo automático** (Laravel + `MAIL_*` en `.env`), usa el sitio completo en `/`, no solo el HTML embebido.
