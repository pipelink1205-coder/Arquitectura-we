# Despliegue en VPS Hostinger

Guía para subir **Arquitectura WE** (Laravel 13) a un VPS de Hostinger con SSH.

## Requisitos en el VPS

| Componente | Versión |
|------------|---------|
| PHP | **8.3+** (ideal 8.4) con extensiones: `mbstring`, `openssl`, `pdo`, `pdo_sqlite` o `pdo_mysql`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, `bcmath` |
| Composer | 2.x |
| Node.js | 20+ (solo para compilar CSS/JS en el servidor) |
| Git | cualquier reciente |

Comprobar:

```bash
php -v
composer -V
node -v
```

En Ubuntu/Debian (como root o con sudo):

```bash
apt update
apt install -y git curl unzip nginx
apt install -y php8.4-fpm php8.4-cli php8.4-mbstring php8.4-xml php8.4-sqlite3 php8.4-mysql php8.4-curl php8.4-zip php8.4-bcmath
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt install -y nodejs
```

(Ajusta `php8.4` si Hostinger trae otra versión: `php -v`.)

## 1. Subir el código

### Opción A — GitHub (recomendada)

En tu PC, asegúrate de haber hecho **push** de todo a:

`https://github.com/pipelink1205-coder/Arquitectura-we`

En el VPS:

```bash
mkdir -p /var/www
cd /var/www
git clone https://github.com/pipelink1205-coder/Arquitectura-we.git arquitectura-we
cd arquitectura-we
```

### Opción B — Sin Git

Comprime el proyecto en tu PC (sin `vendor/`, `node_modules/`, `.env`) y súbelo por SFTP a `/var/www/arquitectura-we`.

## 2. Archivo `.env` en el servidor

```bash
cp .env.example .env
nano .env
```

Valores mínimos de producción:

```ini
APP_NAME="Arquitectura WE"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://TU-DOMINIO.com
APP_TIMEZONE=America/Bogota

# SQLite (simple, un solo sitio)
DB_CONNECTION=sqlite
# DB_DATABASE se deja por defecto: database/database.sqlite

# O MySQL (panel Hostinger → Bases de datos)
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=u123456789_we
# DB_USERNAME=u123456789_we
# DB_PASSWORD=********

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=sync

SITIO_EMAIL=arquitecturayconstruccioneswe@gmail.com

ADMIN_EMAIL=tu-correo@TU-DOMINIO.com
ADMIN_PASSWORD=ContraseñaSegura2026!

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=arquitecturayconstruccioneswe@gmail.com
MAIL_PASSWORD=contraseña-de-aplicacion-google
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=arquitecturayconstruccioneswe@gmail.com
MAIL_FROM_NAME="Arquitectura WE"
```

Generar clave:

```bash
php artisan key:generate
```

## 3. Primera instalación

```bash
chmod +x scripts/deploy.sh
./scripts/deploy.sh --first
```

Eso instala Composer, compila Vite, migra la BD, crea el usuario **admin** y deja cachés listas.

Panel: `https://TU-DOMINIO.com/admin`

## 4. Nginx (DocumentRoot en `public/`)

Copia y edita `deploy/nginx-arquitectura-we.conf.example`:

```bash
nano /etc/nginx/sites-available/arquitectura-we.conf
# server_name y root → /var/www/arquitectura-we/public
# fastcgi_pass → el socket que use tu PHP-FPM (ls /run/php/)
ln -s /etc/nginx/sites-available/arquitectura-we.conf /etc/nginx/sites-enabled/
nginx -t && systemctl reload nginx
```

Certificado HTTPS:

```bash
apt install -y certbot python3-certbot-nginx
certbot --nginx -d TU-DOMINIO.com -d www.TU-DOMINIO.com
```

## 5. Apache (alternativa)

Si usas Apache, lo ideal es apuntar el **DocumentRoot** a `.../arquitectura-we/public`.

Si solo puedes usar la carpeta del dominio sin tocar el vhost, el repo incluye `index.php` y `.htaccess` en la raíz que redirigen a `public/` (menos seguro; preferir `public/`).

## 6. Actualizar tras cambios en GitHub

```bash
cd /var/www/arquitectura-we
git pull origin main
./scripts/deploy.sh
```

## 7. Comprobaciones

- [ ] `/` carga la landing y las imágenes.
- [ ] Formulario de contacto (correo o log si SMTP falla).
- [ ] `/admin` login con `ADMIN_EMAIL` / `ADMIN_PASSWORD`.
- [ ] Editar un servicio y ver el cambio en `/`.

## Problemas frecuentes

| Síntoma | Qué hacer |
|---------|-----------|
| 500 al guardar formulario / login | `chmod -R ug+rwx storage bootstrap/cache`; revisar `storage/logs/laravel.log` |
| CSS roto | Falta build: `npm ci && npm run build` o sube `public/build/` desde tu PC |
| `Composer requires PHP >= 8.4` | Actualiza PHP en el VPS o usa la versión que pide el proyecto |
| Correo no llega | Revisa `MAIL_*` y contraseña de aplicación de Gmail |

## Hostinger — dónde encontrar datos

1. **hPanel → VPS** → IP y contraseña SSH (o llave SSH).
2. Conéctate: `ssh root@TU-IP` (o el usuario que te den).
3. **Dominios**: apunta el DNS del dominio a la IP del VPS (registro A).
4. **MySQL** (si no usas SQLite): créala en hPanel y copia host, usuario, BD y clave al `.env`.
