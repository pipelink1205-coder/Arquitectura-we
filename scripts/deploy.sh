#!/usr/bin/env bash
# Despliegue / actualización en VPS (Hostinger u otro Linux).
# Uso en el servidor:
#   chmod +x scripts/deploy.sh
#   ./scripts/deploy.sh          # actualizar
#   ./scripts/deploy.sh --first  # primera vez (migrate + seed)

set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"

FIRST=0
if [[ "${1:-}" == "--first" ]]; then
    FIRST=1
fi

if [[ ! -f .env ]]; then
    echo "Falta .env — copia .env.example y configura APP_URL, BD y correo."
    exit 1
fi

echo "==> Modo mantenimiento"
php artisan down --retry=60 || true

echo "==> Dependencias PHP"
composer install --no-dev --optimize-autoloader --no-interaction

if command -v npm >/dev/null 2>&1; then
    echo "==> Assets (Vite)"
    npm ci
    npm run build
else
    echo "AVISO: npm no encontrado. Sube public/build/ desde tu PC o instala Node en el VPS."
fi

echo "==> Base de datos"
if [[ "$FIRST" -eq 1 ]]; then
    if grep -q '^DB_CONNECTION=sqlite' .env 2>/dev/null; then
        mkdir -p database
        touch database/database.sqlite
    fi
    php artisan migrate --force
    php artisan db:seed --force
else
    php artisan migrate --force
fi

echo "==> Permisos storage"
chmod -R ug+rwx storage bootstrap/cache 2>/dev/null || true

echo "==> Cachés"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Sitio en línea"
php artisan up

echo "Listo: $(grep '^APP_URL=' .env | cut -d= -f2-)"
