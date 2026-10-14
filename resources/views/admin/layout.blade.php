<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Panel') — WE</title>
    @vite(['resources/css/admin.css'])
</head>
<body class="admin-body">
<div class="admin-shell">
    <aside class="admin-side">
        <h1>Panel WE</h1>
        <nav>
            <a href="{{ route('admin.home') }}" @class(['act' => request()->routeIs('admin.home')])>Inicio</a>
            <a href="{{ route('admin.servicios.index') }}" @class(['act' => request()->routeIs('admin.servicios.*')])>Servicios</a>
            <a href="{{ route('admin.obras.index') }}" @class(['act' => request()->routeIs('admin.obras.*')])>Proyectos</a>
            <a href="{{ route('inicio') }}" target="_blank" rel="noopener">Ver sitio</a>
        </nav>
        <form action="{{ route('admin.logout') }}" method="post" style="margin-top:24px">
            @csrf
            <button type="submit" class="admin-btn admin-btn--line" style="width:100%">Cerrar sesión</button>
        </form>
    </aside>
    <main class="admin-main">
        @if (session('ok'))
            <div class="admin-flash">{{ session('ok') }}</div>
        @endif
        @yield('contenido')
    </main>
</div>
</body>
</html>
