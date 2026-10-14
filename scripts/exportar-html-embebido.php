<?php

declare(strict_types=1);

/**
 * Genera public/exposicion-embebido.html — un solo archivo con CSS, JS, fuentes e imágenes en base64.
 *
 * Uso: php scripts/exportar-html-embebido.php
 */

require __DIR__.'/../vendor/autoload.php';

$raiz = dirname(__DIR__);
$public = $raiz.'/public';
$destino = $public.'/exposicion-embebido.html';

/** @var array<string, string> */
$cacheDataUri = [];

function mimePublico(string $path): string
{
    return match (strtolower(pathinfo($path, PATHINFO_EXTENSION))) {
        'webp' => 'image/webp',
        'jpg', 'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'woff2' => 'font/woff2',
        'ico' => 'image/x-icon',
        default => mime_content_type($path) ?: 'application/octet-stream',
    };
}

function embeberArchivo(string $path, array &$cache): string
{
    if (isset($cache[$path])) {
        return $cache[$path];
    }
    if (! is_file($path)) {
        throw new RuntimeException("No se encontró: {$path}");
    }
    $cache[$path] = 'data:'.mimePublico($path).';base64,'.base64_encode((string) file_get_contents($path));

    return $cache[$path];
}

function renderPortada(): string
{
    $app = require dirname(__DIR__).'/bootstrap/app.php';
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

    foreach ([$placeholder, str_replace('https://', 'http://', $placeholder)] as $root) {
        $html = str_replace($root, '', $html);
    }

    return $html;
}

$html = renderPortada();

$manifest = json_decode((string) file_get_contents($public.'/build/manifest.json'), true, 512, JSON_THROW_ON_ERROR);
$cssPath = $public.'/build/'.$manifest['resources/css/app.css']['file'];
$jsPath = $public.'/build/'.$manifest['resources/js/app.js']['file'];
$fontPath = $public.'/build/'.$manifest['resources/fonts/archivo.woff2']['file'];

$css = (string) file_get_contents($cssPath);
$js = (string) file_get_contents($jsPath);
$fontUri = embeberArchivo($fontPath, $cacheDataUri);

$css = preg_replace('#url\(/build/assets/[^)]+\)#', 'url('.$fontUri.')', $css) ?? $css;

$html = preg_replace_callback(
    '#/(images/[a-zA-Z0-9_./\-]+\.(?:webp|png|jpe?g))#',
    function (array $m) use ($public, &$cacheDataUri): string {
        return embeberArchivo($public.'/'.$m[1], $cacheDataUri);
    },
    $html
) ?? $html;

$html = preg_replace('#<link rel="preload" as="image"[^>]*>\s*#', '', $html) ?? $html;

$html = preg_replace(
    '#<link rel="preload" as="style"[^>]*>\s*<link rel="modulepreload"[^>]*>\s*<link rel="stylesheet"[^>]*>\s*<script type="module"[^>]*></script>#',
    '<style>'.$css.'</style>',
    $html,
    1
) ?? $html;

$js = str_replace('</script>', '<\\/script>', $js);
$html = preg_replace('#</body>#', '<script defer>'.$js.'</script>'."\n</body>", $html, 1) ?? $html;

$html = preg_replace('#<meta name="csrf-token" content="">#', '<meta name="csrf-token" content="offline">', $html) ?? $html;

$aviso = <<<'HTML'
<!-- Archivo autónomo: CSS, JS, fuentes e imágenes embebidos. Generado con php scripts/exportar-html-embebido.php -->
<!-- El envío por formulario abre correo o WhatsApp si no hay servidor Laravel. -->
HTML;

$html = preg_replace('#<!DOCTYPE html>#', "<!DOCTYPE html>\n{$aviso}", $html, 1) ?? $html;
$html = preg_replace('#<html lang="[^"]*">#', '<html lang="es" data-standalone="1">', $html, 1) ?? $html;

file_put_contents($destino, $html);

$tam = filesize($destino);
$imgs = count($cacheDataUri);

echo "OK: {$destino}\n";
echo 'Tamaño: '.number_format($tam / 1024 / 1024, 2)." MB ({$tam} bytes)\n";
echo "Recursos embebidos: {$imgs}\n";
