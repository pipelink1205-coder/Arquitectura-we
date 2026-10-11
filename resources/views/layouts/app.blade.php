@php
    $empresa = $sitio['empresa'];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('titulo', $sitio['seo']['titulo'])</title>
    <meta name="description" content="@yield('descripcion', $sitio['seo']['descripcion'])">
    <meta name="theme-color" content="{{ $sitio['seo']['color'] }}">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph: vista previa al compartir en WhatsApp, Facebook, LinkedIn --}}
    <meta property="og:type" content="website">
    <meta property="og:locale" content="es_CO">
    <meta property="og:site_name" content="{{ $empresa['nombre'] }}">
    <meta property="og:title" content="{{ $empresa['nombre'] }}">
    <meta property="og:description" content="{{ $sitio['seo']['og_descripcion'] }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset($sitio['seo']['imagen']) }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="twitter:card" content="summary_large_image">

    @php
        $negocio = [
            '@context' => 'https://schema.org',
            '@type' => 'GeneralContractor',
            'name' => $empresa['nombre'],
            'url' => url('/'),
            'logo' => asset($sitio['marca']['monograma']),
            'image' => asset($sitio['seo']['imagen']),
            'email' => $empresa['email'],
            'telephone' => $empresa['telefono'],
            'taxID' => str_replace('.', '', $empresa['nit']),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $empresa['direccion'],
                'addressLocality' => 'Medellín',
                'addressRegion' => 'Antioquia',
                'addressCountry' => 'CO',
            ],
            'areaServed' => 'Antioquia',
            'knowsAbout' => $sitio['seo']['especialidades'],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($negocio, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>

    <link rel="icon" href="{{ asset($sitio['marca']['monograma']) }}" type="image/png" sizes="512x512">
    <link rel="apple-touch-icon" href="{{ asset($sitio['marca']['monograma']) }}">
    <link rel="preload" as="image" href="{{ asset($sitio['hero']['imagen']['src']) }}" fetchpriority="high">

    {{-- Activa las animaciones de entrada antes de pintar, para evitar parpadeos --}}
    <script>document.documentElement.classList.add('js')</script>

    @php
        $agua = $sitio['marca'];
    @endphp
    <style>:root{
        --ma-centro:{{ $agua['agua_centro'] }};
        --ma-centro-m:{{ max(0.06, $agua['agua_centro'] - 0.03) }};
        --ma-esq:{{ $agua['agua_esquina'] }};
        --ma-esq-m:{{ max(0.04, $agua['agua_esquina'] - 0.02) }};
        --ma-esq-dark:{{ $agua['agua_esquina_oscuro'] }};
        --ma-esq-dark-m:{{ max(0.06, $agua['agua_esquina_oscuro'] - 0.02) }};
    }</style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body>
    <div id="pg" aria-hidden="true"></div>

    @include('partials.nav')

    <main>
        @yield('contenido')
    </main>

    @include('partials.footer')
    @include('partials.flotantes')
</body>
</html>
