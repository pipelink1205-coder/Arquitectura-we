<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceso — Panel WE</title>
    @vite(['resources/css/admin.css'])
</head>
<body class="admin-body">
@php($marca = config('sitio.marca'))
<div class="admin-login">
    <div class="admin-login__panel">
        <header class="admin-login__head">
            <img
                class="admin-login__logo"
                src="{{ asset($marca['monograma']) }}"
                width="72"
                height="72"
                alt="{{ $marca['monograma_alt'] }}"
            >
            <h1>Panel de administración</h1>
            <p>Arquitectura y Construcciones WE</p>
        </header>

        <div class="admin-login__body">
            @if ($errors->any())
                <div class="admin-errors" role="alert">{{ $errors->first() }}</div>
            @endif

            <form class="admin-login__form" method="post" action="{{ route('admin.login') }}">
                @csrf
                <label>
                    <span>Correo electrónico</span>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="tu@correo.com"
                    >
                </label>
                <label>
                    <span>Contraseña</span>
                    <input
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                    >
                </label>
                <div class="admin-login__row">
                    <label class="admin-login__remember">
                        <input type="checkbox" name="remember" value="1">
                        Recordarme
                    </label>
                </div>
                <button type="submit" class="admin-btn admin-login__submit">Entrar al panel</button>
            </form>
        </div>

        <footer class="admin-login__foot">
            Solo personal autorizado · WE Medellín
        </footer>
    </div>
</div>
</body>
</html>
