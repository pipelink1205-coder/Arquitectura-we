<header class="nav" id="nav">
    <div class="wrap">
        <a class="brand" href="#inicio" aria-label="{{ $sitio['empresa']['nombre'] }}, inicio">
            <x-marca />
            <span>{{ $sitio['empresa']['nombre'] }}<small>{{ $sitio['empresa']['ciudad'] }}</small></span>
        </a>
        <nav aria-label="Principal">
            <ul class="menu" id="menu">
                @foreach ($sitio['menu'] as $ancla => $etiqueta)
                    <li><a href="#{{ $ancla }}">{{ $etiqueta }}</a></li>
                @endforeach
                <li class="m-cta"><a class="btn btn-senal" href="#contacto">Solicitar propuesta</a></li>
            </ul>
        </nav>
        <a class="btn btn-senal nav-cta" href="#contacto">Solicitar propuesta</a>
        <button class="burger" id="burger" aria-label="Abrir menú" aria-controls="menu" aria-expanded="false"><i></i><i></i></button>
    </div>
</header>
