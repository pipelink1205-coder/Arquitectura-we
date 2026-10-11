@php($empresa = $sitio['empresa'])
<footer>
    <div class="wrap">
        <div class="pie">
            <div>
                <a class="brand" href="#inicio"><x-marca carga="lazy" /><span>{{ $empresa['nombre'] }}</span></a>
                <p>{{ $empresa['eslogan'] }}</p>
            </div>
            <div>
                <h4>Navegación</h4>
                @foreach (['servicios', 'proceso', 'proyectos', 'contacto'] as $ancla)
                    <a href="#{{ $ancla }}">{{ $sitio['menu'][$ancla] }}</a>
                @endforeach
            </div>
            <div>
                <h4>Contacto</h4>
                <a href="mailto:{{ $empresa['email'] }}">{{ $empresa['email'] }}</a>
                <a href="tel:{{ $empresa['telefono'] }}">{{ $empresa['telefono_visible'] }}</a>
                <span>{{ $empresa['direccion'] }}, Medellín</span>
            </div>
        </div>
        <div class="legal">
            <span>© {{ now()->year }} {{ $empresa['nombre'] }}</span>
            <span>NIT {{ $empresa['nit'] }}</span>
        </div>
    </div>
</footer>
