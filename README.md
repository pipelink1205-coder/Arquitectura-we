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

Pruebas: `php artisan test`

## Dónde está cada cosa

| Qué | Dónde |
|---|---|
| **Textos, obras, contactos, FAQ** | `config/sitio.php` (lo único que hay que tocar para cambiar contenido) |
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

## Producción

```bash
npm run build
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

Pon `APP_ENV=production`, `APP_DEBUG=false` y `APP_URL` con el dominio real; las etiquetas `og:` y `canonical` lo usan.
