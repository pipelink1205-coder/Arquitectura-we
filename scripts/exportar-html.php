<?php

declare(strict_types=1);

/**
 * Genera public/exposicion.html (portada estática) para previsualizar o enlazar desde el servidor.
 *
 * Uso:
 *   php scripts/exportar-html.php
 *   php scripts/exportar-html.php https://tudominio.com
 *
 * Nota: el formulario de contacto necesita Laravel (POST /solicitudes). Esta página es vista + anclas.
 */

require __DIR__.'/../vendor/autoload.php';

$publicBase = isset($argv[1]) ? rtrim($argv[1], '/') : '';

$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

Illuminate\Support\Facades\Config::set('app.env', 'production');
Illuminate\Support\Facades\Config::set('app.debug', false);

$placeholder = 'https://__laravel-export__.test';
Illuminate\Support\Facades\Config::set('app.url', $placeholder);
Illuminate\Support\Facades\URL::forceRootUrl($placeholder);

Illuminate\Support\Facades\View::share('errors', new Illuminate\Support\ViewErrorBag);

$hot = dirname(__DIR__).'/public/hot';
$hotBackup = null;
if (is_file($hot)) {
    $hotBackup = file_get_contents($hot);
    unlink($hot);
}

$html = view('inicio', ['sitio' => config('sitio')])->render();

if ($hotBackup !== null) {
    file_put_contents($hot, $hotBackup);
}

$roots = [$placeholder, str_replace('https://', 'http://', $placeholder)];
$target = $publicBase !== '' ? $publicBase : '';
foreach ($roots as $root) {
    $html = str_replace($root, $target, $html);
}

$destino = dirname(__DIR__).'/public/exposicion.html';
file_put_contents($destino, $html);

echo "OK: {$destino}\n";
echo 'Tamaño: '.number_format(strlen($html))." bytes\n";
echo $publicBase !== ''
    ? "URL base: {$publicBase}\n"
    : "Rutas del sitio desde la raíz (/build, /images…)\n";
